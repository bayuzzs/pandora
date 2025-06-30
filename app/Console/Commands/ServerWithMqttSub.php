<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log; // Pastikan ini di-import untuk logging

/**
 * Class ServerWithMqttSub
 * @package App\Console\Commands
 *
 * Command Console Laravel untuk menjalankan server dan berlangganan ke broker MQTT
 * untuk menerima data RFID.
 */
class ServerWithMqttSub extends Command
{
    // Nama command yang akan digunakan di Artisan (misalnya, `php artisan serve-mqtt`)
    protected $signature = 'serve-mqtt';

    // Deskripsi command yang akan ditampilkan saat menjalankan `php artisan list`
    protected $description = 'Run Laravel server and subscribe to MQTT for RFID data';

    /**
     * Konstruktor kelas command.
     * Menginisialisasi kelas induk.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Metode utama yang dijalankan saat command dipanggil.
     * Berisi logika untuk memulai server Laravel dan koneksi MQTT.
     */
    public function handle()
    {
        // Memberikan informasi ke konsol bahwa server Laravel akan dimulai
        $this->info("🚀 Menjalankan Laravel server di background...");

        // Menjalankan PHP Artisan Serve sebagai proses terpisah di background.
        // PENTING: Untuk debugging, output TIDAK DIALIHKAN ke /dev/null sementara.
        // Jika server berhasil berjalan, Anda akan melihat output 'Laravel development server started' di sini.
        // Jika ada error, Anda akan melihat error tersebut.
        $serveProcessCommand = 'php artisan serve'; // Hapus `nohup` dan `> /dev/null 2>&1 &` untuk melihat output
        $serve = Process::fromShellCommandline($serveProcessCommand, base_path());
        
        try {
            // Memulai proses server Laravel.
            // Menggunakan `start()` akan membuat proses berjalan di background.
            $serve->start(); 
            
            // Memberikan waktu singkat agar proses dapat memulai dan menghasilkan output
            sleep(2); 

            if ($serve->isRunning()) {
                $this->info("✅ Server Laravel berhasil dijalankan di background (PID: " . $serve->getPid() . ").");
                $this->info("Output server Laravel (jika ada):");
                $this->info($serve->getOutput() . $serve->getErrorOutput());
            } else {
                $this->error("❌ Server Laravel gagal memulai atau segera berhenti.");
                $this->error("Output: " . $serve->getOutput());
                $this->error("Error Output: " . $serve->getErrorOutput());
                Log::error("Laravel server process failed to start or stopped immediately.", [
                    'output' => $serve->getOutput(),
                    'error_output' => $serve->getErrorOutput(),
                ]);
                return 1; // Keluar dengan kode error
            }

        } catch (\Exception $e) {
            // Menangani kesalahan jika proses server Laravel gagal dimulai
            $this->error("❌ Gagal menjalankan server Laravel: " . $e->getMessage());
            // Mencatat detail error ke log Laravel
            Log::error("Failed to start Laravel server process: " . $e->getMessage());
            return 1; // Keluar dari command dengan kode error
        }
        
        // Memberikan informasi ke konsol tentang upaya koneksi MQTT
        $this->info("🔌 Menyambungkan ke broker MQTT dan menunggu pesan RFID...");

        // Setup klien MQTT dengan mengambil nilai dari variabel lingkungan (.env).
        // Menggunakan operator null coalescing (??) untuk menyediakan nilai default
        // jika variabel lingkungan tidak ditemukan atau null, sehingga mencegah error.
        $server = env('IP_BrokerServer', '127.0.0.1'); // Alamat IP atau nama host broker MQTT
        $port = (int) env('PortBroker', 1883);      // Port broker MQTT (dikonversi ke integer)
        $clientId = env('ClientName', 'LaravelMqttClient') . '_' . uniqid(); // ID unik untuk klien MQTT
        $topic = env('TopicSubs', 'rfid/uid');      // Topik MQTT yang akan dilanggan

        // Mencatat detail koneksi yang akan digunakan ke log Laravel untuk debugging
        Log::info("Attempting to connect to MQTT broker with settings:", [
            'server' => $server,
            'port' => $port,
            'clientId' => $clientId,
            'topic' => $topic,
        ]);

        try {
            // Inisialisasi objek klien MQTT dengan server, port, dan client ID
            $mqttClient = new MqttClient($server, $port, $clientId);

            // Membuat objek pengaturan koneksi MQTT
            $settings = (new ConnectionSettings())
                ->setKeepAliveInterval(60) // Interval keep-alive dalam detik (untuk menjaga koneksi tetap hidup)
                ->setConnectTimeout(5);    // Timeout koneksi dalam detik

            // Menghubungkan ke broker MQTT.
            // Parameter kedua 'true' mengindikasikan "clean session" (sesi baru setiap kali terhubung).
            $mqttClient->connect($settings, true); 

            $this->info("✅ Berhasil tersambung ke broker MQTT.");

            // Berlangganan ke topik MQTT yang ditentukan dari .env.
            // Sebuah fungsi callback akan dijalankan setiap kali pesan diterima pada topik ini.
            $mqttClient->subscribe($topic, function (string $topic, string $message) {
                $uid = trim($message); // Menghapus spasi putih di awal/akhir pesan
                $this->info("🟢 Log Received UID: " . $uid); // Menampilkan UID di konsol
                Log::info("Received RFID UID: " . $uid); // Mencatat UID yang diterima ke log Laravel

                // Menyimpan UID yang diterima ke cache Laravel selama 1 menit (60 detik)
                Cache::put('rfid_uid', $uid, 60);

                $this->info("✅ Kartu Tag Berhasil DiScan. UID disimpan di cache.");
            }, 0); // QoS (Quality of Service) diatur ke 0 (At most once delivery)

            // Memulai loop tak terbatas untuk menjaga koneksi MQTT tetap aktif
            // dan terus memproses pesan yang masuk serta menjaga koneksi keep-alive.
            $this->info("👂 Menunggu pesan pada topik '{$topic}'...");
            $mqttClient->loop(true); // Parameter 'true' berarti loop akan berjalan tanpa henti

        } catch (\Exception $e) {
            // Menangani pengecualian (error) yang mungkin terjadi selama koneksi atau loop MQTT.
            $this->error("❌ Terjadi kesalahan pada koneksi atau loop MQTT: " . $e->getMessage());
            // Mencatat detail error ke log Laravel, termasuk trace stack untuk debugging yang lebih mendalam.
            Log::error("MQTT Error: " . $e->getMessage(), [
                'server' => $server,
                'port' => $port,
                'clientId' => $clientId,
                'topic' => $topic,
                'trace' => $e->getTraceAsString(),
            ]);
            // Memastikan koneksi MQTT ditutup jika terjadi error dan koneksi masih aktif
            if (isset($mqttClient) && $mqttClient->isConnected()) {
                $mqttClient->disconnect();
            }
            return 1; // Keluar dari command dengan kode error
        }
    }
}
