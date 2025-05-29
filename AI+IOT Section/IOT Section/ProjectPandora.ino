// All Packages must be installed before running this code
#include <SPI.h>
#include <MFRC522.h>
#include <ESP8266WiFi.h> 
#include <PubSubClient.h>


// Pin untuk koneksi RC522
#define SS_PIN  D2
#define RST_PIN D1

MFRC522 mfrc522(SS_PIN, RST_PIN);


// Wifi Intialization
const char* ssid = "Wifi Rumah "; // Ganti dengan SSID WiFi 
const char* password = "Password Wifi"; // Ganti dengan password WiFi 

const char* mqtt_server = "Address Broker MQTT"; // Ganti dengan alamat broker MQTT 
WiFiClient espClient;
PubSubClient client(espClient);

void setup_wifi() {
  delay(10);
  Serial.println();
  Serial.print("Menghubungkan ke WiFi...");
  WiFi.begin(ssid, password);
  
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println(" Terhubung ke WiFi");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
}

void reconnect() {
  while (!client.connected()) {
    Serial.print("Mencoba koneksi MQTT...");
    
    if (client.connect("ArduinoClient")) {
      Serial.println("Terhubung ke broker MQTT");
    } else {
      Serial.print("Gagal, status kode: ");
      Serial.print(client.state());
      delay(2000);
    }
  }
}

void setup() {
  Serial.begin(9600);
  SPI.begin();
  mfrc522.PCD_Init();
  setup_wifi();
  client.setServer(mqtt_server, 1883);
}

void loop() {
  if (!client.connected()) {
    reconnect();
  }
  
  client.loop();
 

  //Proses pembacaan kartu RFID
  if (mfrc522.PICC_IsNewCardPresent() && mfrc522.PICC_ReadCardSerial()) {
    String uid = "";
    for (byte i = 0; i < mfrc522.uid.size; i++) {
      uid += String(mfrc522.uid.uidByte[i], HEX);
    } }
    Serial.print("UID Kartu: ");  Serial.print("UID Kartu: ");
    Serial.println(uid);
    client.publish("rfid/uid", uid.c_str());    client.publish("rfid/uid", uid.c_str());
    delay(1000);
  }
}