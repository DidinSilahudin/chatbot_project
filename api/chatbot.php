<?php
require_once '../config/database.php';

$apiKey = "YOUR_OPENAI_API_KEY";
$data = json_decode(file_get_contents("php://input"), true);
$userMessage = $data['message'];

$url = "https://api.openai.com/v1/chat/completions";
$headers = [
    "Authorization: Bearer $apiKey",
    "Content-Type: application/json"
];

$body = json_encode([
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "system", "content" => "Anda adalah chatbot yang membantu pengguna."],
        ["role" => "user", "content" => $userMessage]
    ]
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>
