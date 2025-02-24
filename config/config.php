<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Memuat file .env
$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

// Ambil API Key dari .env
$apiKey = getenv('OPENAI_API_KEY') ?: 'Tidak ditemukan';

echo "API Key: " . $apiKey;
?>
