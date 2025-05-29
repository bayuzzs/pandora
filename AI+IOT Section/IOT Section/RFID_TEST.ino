#include <SPI.h>
#include <MFRC522.h>

#define SS_PIN     D2    // SDA RC522 ke D2
#define RST_PIN    D1    // RST RC522 ke D1
#define BUZZER_PIN D3    // Buzzer ke D3

MFRC522 mfrc522(SS_PIN, RST_PIN);  // Buat instance RFID

void setup() {
  Serial.begin(115200);
  SPI.begin();              // Inisialisasi SPI
  mfrc522.PCD_Init();       // Inisialisasi RC522
  pinMode(BUZZER_PIN, OUTPUT); // Set buzzer sebagai output
  digitalWrite(BUZZER_PIN, LOW);
  Serial.println("Scan kartu RFID...");
}

void loop() {
  // Cek kartu baru
  if (!mfrc522.PICC_IsNewCardPresent() || !mfrc522.PICC_ReadCardSerial()) {
    return;
  }

  // Bunyikan buzzer
  digitalWrite(BUZZER_PIN, HIGH);
  delay(100);
  digitalWrite(BUZZER_PIN, LOW);

  // Tampilkan UID kartu
  Serial.print("UID kartu: ");
  for (byte i = 0; i < mfrc522.uid.size; i++) {
    Serial.print(mfrc522.uid.uidByte[i] < 0x10 ? "0" : "");
    Serial.print(mfrc522.uid.uidByte[i], HEX);
  }
  Serial.println();

  // Matikan kartu
  mfrc522.PICC_HaltA();
  mfrc522.PCD_StopCrypto1();
}
