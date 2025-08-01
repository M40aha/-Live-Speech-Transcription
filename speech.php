<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Live Speech Transcription</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg-light: #e0f7fa;
      --bg-dark: #1e1e2f;
      --text-light: #333;
      --text-dark: #f5f5f5;
      --card-light: #ffffff;
      --card-dark: #2c2c3e;
      --shadow: rgba(0, 0, 0, 0.1);
    }

    body {
      font-family: 'Roboto', sans-serif;
      background: var(--bg-light);
      color: var(--text-light);
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 20px;
    }

    .dark-mode {
      background: var(--bg-dark);
      color: var(--text-dark);
    }

    .container {
      background: var(--card-light);
      padding: 30px 40px;
      border-radius: 16px;
      box-shadow: 0 15px 25px var(--shadow);
      max-width: 600px;
      width: 100%;
      text-align: center;
      transition: all 0.3s ease;
    }

    .dark-mode .container {
      background: var(--card-dark);
    }

    h1 {
      font-size: 28px;
      color: #ff8517;
      margin-bottom: 20px;
    }

    .button {
      background-color: #ff8517;
      border: none;
      border-radius: 50px;
      color: #fff;
      font-size: 18px;
      font-weight: bold;
      padding: 12px 24px;
      margin: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .button:hover {
      background-color: #e5770f;
    }

    #action {
      margin-top: 10px;
      font-size: 16px;
    }

    #output {
      background: #f1f1f1;
      border-radius: 10px;
      padding: 20px;
      margin-top: 20px;
      font-size: 18px;
      white-space: pre-wrap;
      display: none;
      text-align: left;
      transition: background 0.3s ease;
    }

    .dark-mode #output {
      background: #444;
      color: #f5f5f5;
    }

    .toggle-dark {
      background: transparent;
      color: #ff8517;
      border: 2px solid #ff8517;
      margin-top: 15px;
    }

    .toggle-dark:hover {
      background: #ff8517;
      color: #fff;
    }

    @media (max-width: 600px) {
      .container {
        padding: 25px 20px;
      }
      .button {
        width: 100%;
        font-size: 18px;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>🧠 Live Speech Transcription</h1>
    <button class="button" onclick="startListening()">🎙️ Start</button>
    <button class="button" onclick="stopListening()">🛑 Stop</button>
    <button class="button toggle-dark" onclick="toggleDarkMode()">🌓 Toggle Dark Mode</button>
    <p id="action"></p>
    <div id="output"></div>
  </div>

  <script>
    let recognition;
    let isListening = false;
    let transcriptLog = "";

    function startListening() {
      if (isListening) return;

      const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
      recognition = new SpeechRecognition();
      recognition.continuous = true;
      recognition.interimResults = false;
      recognition.lang = "en-US";

      const action = document.getElementById("action");
      const output = document.getElementById("output");

      recognition.onstart = function () {
        isListening = true;
        action.textContent = "🎤 Listening... Speak freely.";
        output.style.display = "block";
      };

      recognition.onresult = function (event) {
        for (let i = event.resultIndex; i < event.results.length; ++i) {
          if (event.results[i].isFinal) {
            const spokenText = event.results[i][0].transcript.trim();
            transcriptLog += spokenText + ". ";
            output.textContent = transcriptLog;
          }
        }
      };

      recognition.onerror = function (event) {
        action.textContent = "⚠️ Error: " + event.error;
      };

      recognition.onend = function () {
        if (isListening) {
          recognition.start(); // auto-restart unless stopped manually
        }
      };

      recognition.start();
    }

    function stopListening() {
      if (recognition && isListening) {
        recognition.stop();
        document.getElementById("action").textContent = "🛑 Stopped listening.";
        isListening = false;
      }
    }

    function toggleDarkMode() {
      document.body.classList.toggle("dark-mode");
    }
  </script>

</body>
</html>


