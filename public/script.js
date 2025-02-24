document.getElementById("user-input").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        sendMessage();
    }
});

function sendMessage() {
    let userInput = document.getElementById("user-input").value;
    if (userInput.trim() === "") return;
    
    let chatBox = document.getElementById("chat-box");
    chatBox.innerHTML += `<div class='user-message'>${userInput}</div>`;

    fetch("../api/chatbot.php", {
        method: "POST",
        body: JSON.stringify({ message: userInput }),
        headers: { "Content-Type": "application/json" }
    })
    .then(response => response.json())
    .then(data => {
        let botMessage = data.choices[0].message.content;
        chatBox.innerHTML += `<div class='bot-message'>${botMessage}</div>`;
    });

    document.getElementById("user-input").value = "";
}
