<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\Rfid;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MqttServices
{
    protected $mqttClient;

    public function __construct()
    {
        // Set server MQTT dan portnya
        $server = '127.0.0.1';  // IP broker
        $port = 1883;           // Default MQTT port

        // Setup MQTT Client
        $clientId = 'laravel-mqtt-client-' . uniqid();
        $this->mqttClient = new MqttClient($server, $port, $clientId);
    }

    public function connect()
    {
        // Menghubungkan ke broker MQTT
        $settings = (new ConnectionSettings())
            ->setUsername(null) // Jika perlu username
            ->setPassword(null) // Jika perlu password
            ->setKeepAliveInterval(60);
        
        $this->mqttClient->connect($settings, true);
    }

    public function subscribe($topic)
    {
        // Berlangganan ke topik MQTT
        $this->mqttClient->subscribe($topic, function (string $topic, string $message) {
            $this->handleMessage($topic, $message); 
        }, 0);
    }

    public function handleMessage($topic, $message)
    {
        // Menangani pesan yang diterima
        Log::info("Pesan diterima dari topik: {$topic}, Isi pesan: {$message}");

        // Proses penyimpanan data UID ke cache
        $uid = trim($message);

        // Simpan UID ke cache untuk digunakan di form create
        Cache::put('rfid_uid', $uid, 60); // Cache UID selama 60 detik

        Log::info("UID disimpan di cache: {$uid}");
    }

    public function loop()
    {
        // Memulai loop agar subscriber terus menerima pesan
        $this->mqttClient->loop(true);
    }
}
