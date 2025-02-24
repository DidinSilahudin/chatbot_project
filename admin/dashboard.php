<?php
require_once '../config/database.php';

$result = $conn->query("SELECT * FROM chat_log ORDER BY created_at DESC");

echo "<h2>Riwayat Percakapan</h2>";
while ($row = $result->fetch_assoc()) {
    echo "<p><strong>" . $row['user_message'] . "</strong>: " . $row['bot_response'] . "</p>";
}
?>
