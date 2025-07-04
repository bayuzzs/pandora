
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
