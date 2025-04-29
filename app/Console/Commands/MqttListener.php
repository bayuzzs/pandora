<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use Illuminate\Support\Facades\DB;

class MqttListener extends Command
{
    protected $signature = 'mqtt:listen';
    protected $description = 'Mendengarkan topik dari broker MQTT';

    public function handle()
    {
        $server   = env('MQTT_BROKER_HOST', '127.0.0.1');
        $port     = env('MQTT_BROKER_PORT', 1883);
        $clientId = 'laravel-mqtt-listener';
        $topic    = env('MQTT_TOPIC', 'domba/scan');

        // Membuat instance MQTT client
        $mqtt = new MqttClient($server, $port, $clientId);
        $connectionSettings = (new ConnectionSettings())->setKeepAliveInterval(60);

        // Terhubung ke broker MQTT
        $mqtt->connect($connectionSettings, true);

        $this->info("Terhubung ke broker MQTT, menunggu pesan dari topik [$topic]...");

        // Subscribe ke topik yang diinginkan
        $mqtt->subscribe($topic, function (string $topic, string $message) {
            echo "Pesan diterima: $message\n";

            // Simpan pesan ke database
            DB::table('domba')->insertOrIgnore([
                'nomor_tag'     => $message,
                'jenis_kelamin' => 'Jantan',
                'berat'         => 0,
                'id_kandang'    => 1,
            ]);
        }, 0);

        // Loop untuk terus mendengarkan pesan
        $mqtt->loop(true); // listen terus-menerus
    }
}
