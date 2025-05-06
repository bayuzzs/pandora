<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ServerWithMqttSub extends Command
{
    // Nama dan deskripsi command
    protected $signature = 'serve-mqtt';
    protected $description = 'Run Laravel server and subscribe to MQTT for RFID data';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $this->info(" Menjalankan Laravel server di background...");

        // Menjalankan PHP Artisan Serve
        $serve = Process::fromShellCommandline('php artisan serve', base_path());
        $serve->start(); // menjalankan server di background

        //  Menghubungkan dan berlangganan ke Broker MQTT
        $this->info("🔌 Menyambungkan ke broker MQTT dan menunggu pesan RFID...");

        // Setup MQTT client
        $server = env("IP_BrokerServer"); 
        $port = env('PortBroker'); 
        $clientId = env('ClientName'). uniqid();
        $topic = env('TopicSubs');
        $mqttClient = new MqttClient($server, $port, $clientId);

        // Menghubungkan ke MQTT Broker
        $settings = (new ConnectionSettings())
            ->setKeepAliveInterval(60);  
        $mqttClient->connect($settings, true);  

        // Berlangganan ke topik 'rfid/uid'
        $mqttClient->subscribe($topic, function (string $topic, string $message) {
            $uid = trim($message);
            $this->info(" Log Received UID: " . $uid);

            // Simpan UID di cache untuk sementara waktu (1 menit)
            Cache::put('rfid_uid', $uid, 60);

            $this->info(" Kartu Tag Berhasil DiScan.");
        }, 0);

     
        $mqttClient->loop(true);  
    }
}
