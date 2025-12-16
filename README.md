
# 🐑 Pandora – Sistem Pencatatan Domba Rahayu

**Pandora** adalah aplikasi web berbasis Laravel yang dirancang khusus untuk membantu pencatatan data domba di peternakan **Rahayu Agro Makmur**. Sistem ini juga dilengkapi dengan teknologi **AI berbasis Python** yang mampu mendeteksi **jumlah domba di kandang**.

> 🎯 Tujuan: Digitalisasi peternakan untuk pencatatan rapi & deteksi cerdas di lapangan.

---

## 🚀 Fitur Utama

- ✅ CRUD data domba (nama, UID RFID, jenis kelamin, ras, bobot, status kesehatan)
- 📅 Catat kelahiran, bobot, dan riwayat kesehatan
- 📸 **AI Deteksi Visual**: perhitungan jumlah domba di kandang dengan object detection
- 📡 **Integrasi MQTT**: untuk menerima data dari perangkat IoT seperti pembaca RFID

---


🔧 Persiapan Perangkat

Sebelum menggunakan perangkat, pastikan hal-hal berikut sudah terpenuhi:

🔋 Baterai terpasang dengan benar pada perangkat.

🔌 Baterai dalam kondisi penuh atau memiliki daya yang cukup.

📶 Jaringan WiFi tersedia dan stabil.

🌐 Perangkat dan website berada dalam satu jaringan.

▶️ Langkah Menjalankan Perangkat

Nyalakan perangkat IoT.

Pastikan perangkat berhasil terhubung ke jaringan WiFi.

Perangkat akan otomatis mencoba terhubung ke MQTT Server.

Jika koneksi berhasil, data akan dikirim dan dapat diakses melalui website.

❗ Troubleshooting (Jika Perangkat Tidak Terdeteksi / Gagal Scan)

Jika perangkat tidak berhasil melakukan scan atau tidak terhubung dengan sistem, lakukan pengecekan berikut:

✅ Pastikan MQTT Server sedang berjalan.

✅ Pastikan seluruh perangkat berada dalam satu jaringan.

✅ Periksa kembali alamat IP MQTT Server pada program (sketch).

✅ Pastikan tidak ada kesalahan penulisan pada konfigurasi.

⚙️ Konfigurasi pada Sketch

Beberapa pengaturan yang dapat (dan wajib) disesuaikan pada file sketch antara lain:

📡 Pengaturan WiFi

SSID

Password WiFi

🖥️ Alamat MQTT Server

IP Address Server

Port MQTT (jika diperlukan)

Contoh (ilustrasi):

const char* ssid = "NAMA_WIFI";
const char* password = "PASSWORD_WIFI";
const char* mqtt_server = "192.168.1.10";

📌 Catatan Tambahan

Disarankan menggunakan jaringan lokal (LAN/WiFi yang sama) untuk menghindari masalah koneksi.

Pastikan broker MQTT (Mosquitto/Aedes/Mosca) berjalan sebelum perangkat dinyalakan.

## 📦 Instalasi Proyek

### 1. Persiapan instalasi 
Proyek ini disarankan menggunakan Php version 8.11 keatas dan Mysql untuk database 

### 2. Salin Source Code 

```bash
git clone https://github.com/bayuzzs/pandora.git
cd pandora
```

### 3. Instalasi Laravel

```bash
composer install
cp .env.example .env
php artisan key:generate
```

### 4. Setup Database

```bash
php artisan migrate --seed
```

Edit `.env` sesuai konfigurasi database kamu.

---

### 📦 Instalasi Frontend

Bagian ini hanya untuk antarmuka frontend berbasis Vite (Blade + Tailwind).

- Instalasi dependensi frontend:
  ```bash
  npm install
  ```

- Jalankan server pengembangan:
  ```bash
  npm run dev
  ```

- Build untuk produksi:
  ```bash
  npm run build
  ```

---

## ⚙️ Menjalankan Laravel dengan MQTT

Pandora menggunakan MQTT untuk komunikasi dengan perangkat seperti RFID reader. Untuk itu, Laravel dijalankan menggunakan perintah khusus berikut:

```bash
php artisan serve-mqtt
```

> Perintah ini akan menjalankan Laravel bersama subscriber MQTT untuk mendengarkan dan memproses data dari broker MQTT secara real-time.

---

## 🧠 Instalasi AI Python – Deteksi Domba

### 1. Gunakan Python Versi 3.10

Pastikan kamu menggunakan **Python 3.10.x** untuk kompatibilitas terbaik.

### 2. Siapkan Environment dan Upgrade pip

```bash
python -m venv venv
source venv/bin/activate  # Linux/macOS
venv\Scripts\activate   # Windows

python -m pip install --upgrade pip
```

### 3. Install Dependensi

```bash
pip install -r requirements.txt
pip install flask
pip install opencv-python
```

### 4. Jalankan AI – Versi Minimal

```bash
python detect.py --weights best.pt --source image.jpg --conf 0.25 --name minimal
```

> Cocok untuk proses cepat pada gambar/video, dapat diintegrasikan ke backend secara otomatis.

---

## 🙌 Tim TRPL 401 

Pandora dikembangkan untuk meningkatkan efisiensi peternakan Rahayu dengan memadukan teknologi **web modern (Laravel)** dan **kecerdasan buatan (Python AI)**.

---
