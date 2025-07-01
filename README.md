
# 🐑 Pandora – Sistem Pencatatan Domba dengan Deteksi AI

**Pandora** adalah aplikasi web berbasis Laravel yang dirancang khusus untuk membantu pencatatan data domba di peternakan **Rahayu Agro Makmur**. Sistem ini juga dilengkapi dengan teknologi **AI berbasis Python** yang mampu mendeteksi **kambing di antara domba** secara otomatis menggunakan kamera.

> 🎯 Tujuan: Digitalisasi peternakan untuk pencatatan rapi & deteksi cerdas di lapangan.

---

## 🚀 Fitur Utama

- ✅ CRUD data domba (nama, UID RFID, jenis kelamin, ras, bobot, status kesehatan)
- 📅 Catat kelahiran, bobot, dan riwayat kesehatan
- 📸 **AI Deteksi Visual**: mengenali kambing di antara domba dengan kamera dan model deteksi objek
- 🔐 Autentikasi pengguna (admin & petugas)
- ⚙️ MQTT & IoT-ready (untuk ekspansi masa depan)

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

> AI ini mampu membedakan **kambing dari domba secara visual**, digunakan untuk validasi di kandang melalui kamera.

---

## 💡 Integrasi Laravel + Python

Laravel memanggil AI Python dengan `shell_exec()` untuk menjalankan deteksi, contohnya:

```php
$output = shell_exec("python3 detect.py --source image.jpg");
```

---

## 🧪 Contoh Hasil Deteksi

AI akan mendeteksi dan menandai kambing dalam gambar/video:

```
✅ 2 kambing terdeteksi dari total 10 hewan
```

Hasil ini bisa disimpan ke database Laravel untuk pelaporan atau alert.

---

## 🗂 Struktur Folder

```
pandora/
├── app/                  # Controller, Models
├── public/               # Asset publik
├── resources/views/      # Blade templates
├── routes/web.php        # Route Laravel
├── detect.py             # Skrip deteksi AI
├── best.pt               # Model YOLO terlatih
└── database/             # Migrations & seeder
```

---

## 📄 Lisensi

MIT License © 2025 – [Bayu ZS](https://github.com/bayuzzs)

---

## 🙌 Tim Pengembang

Pandora dikembangkan untuk meningkatkan efisiensi peternakan Rahayu dengan memadukan teknologi **web modern (Laravel)** dan **kecerdasan buatan (Python AI)**.

---

