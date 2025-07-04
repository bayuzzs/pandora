
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

## 📦 Instalasi Proyek

### 1. Clone Repositori

```bash
git clone https://github.com/bayuzzs/pandora.git
cd pandora
```

### 2. Instalasi Laravel

```bash
composer install
npm install && npm run dev
cp .env.example .env
php artisan key:generate
```

### 3. Setup Database

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

## 🧠 Instalasi AI Python – Deteksi Kambing

### 1. Siapkan Environment Python

```bash
python -m venv venv
source venv/bin/activate  # Linux/macOS
venv\Scripts\activate   # Windows
```

### 2. Install Library Python

```bash
pip install -r requirements.txt
```

### 3. Jalankan Deteksi AI (YOLOv7 misalnya)

```bash
python detect.py --source 0 --weights best.pt --name kambing_detect
```

> Gunakan kamera atau video untuk mendeteksi domba dan kambing secara otomatis.

---

## 🙌 Tim TRPL 401 

Pandora dikembangkan untuk meningkatkan efisiensi peternakan Rahayu dengan memadukan teknologi **web modern (Laravel)** dan **kecerdasan buatan (Python AI)**.

---
