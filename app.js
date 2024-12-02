document.getElementById('send-button').addEventListener('click', function() {
    const inputField = document.getElementById('user-input');
    const userInput = inputField.value;

    // Clear the input field
    inputField.value = '';

    // Display user input in the chat output
    const chatOutput = document.getElementById('chat-output');
    chatOutput.innerHTML += `<p><strong>You:</strong> ${userInput}</p>`; // Use backticks here

    // Make the API request
    const API_URL = "https://api-inference.huggingface.co/models/HuggingFaceH4/zephyr-7b-beta";
    const headers = {
        "Authorization": "Bearer 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",
        "Content-Type": "application/json"
    };
    const data = {
        "inputs": userInput
    };

    fetch(API_URL, {
        method: 'POST',
        headers: headers,
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        const responseText = data[0].generated_text; // Assuming response is structured this way
        chatOutput.innerHTML += `<p><strong>AI:</strong> ${responseText}</p>`; // Use backticks here
    })
    .catch(error => {
        console.error('Error:', error);
        chatOutput.innerHTML += `<p><strong>AI:</strong> Sorry, something went wrong!</p>`; // Use backticks here
    });
});
