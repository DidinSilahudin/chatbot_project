<?php
$verify_token = "YOUR_VERIFY_TOKEN";
$access_token = "YOUR_ACCESS_TOKEN";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['hub_verify_token'] === $verify_token) {
        echo $_GET['hub_challenge'];
        exit;
    }
}

$data = json_decode(file_get_contents("php://input"), true);
$phone = $data['entry'][0]['changes'][0]['value']['messages'][0]['from'];
$text = $data['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];

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

$url = "https://graph.facebook.com/v17.0/YOUR_PHONE_NUMBER_ID/messages";
$body = json_encode([
    "messaging_product" => "whatsapp",
    "to" => $phone,
    "text" => ["body" => $reply]
]);

$options = [
    "http" => [
        "header" => "Authorization: Bearer $access_token\r\nContent-Type: application/json\r\n",
        "method" => "POST",
        "content" => $body
    ]
];

file_get_contents($url, false, stream_context_create($options));
?>
