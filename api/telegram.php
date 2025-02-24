<?php
$token = "YOUR_TELEGRAM_BOT_TOKEN";
$update = json_decode(file_get_contents("php://input"), true);
$chat_id = $update["message"]["chat"]["id"];
$text = $update["message"]["text"];

$response = file_get_contents("https://api.openai.com/v1/chat/completions", false, stream_context_create([
    "http" => [
        "method" => "POST",
        "header" => "Authorization: Bearer YOUR_OPENAI_API_KEY\r\nContent-Type: application/json\r\n",
        "content" => json_encode([
            "model" => "gpt-3.5-turbo",
            "messages" => [["role" => "user", "content" => $text]]
        ])
    ]
]));

$reply = json_decode($response, true)['choices'][0]['message']['content'];

$url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($reply);
file_get_contents($url);
?>
