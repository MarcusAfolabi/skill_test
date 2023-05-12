<!DOCTYPE html>
<html>
<head>
  <title>SMS Platform</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }

    h1 {
      text-align: center;
    }

    .form-container {
      max-width: 400px;
      margin: 0 auto;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    .form-input {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .form-button {
      display: block;
      width: 100%;
      padding: 10px;
      font-size: 16px;
      font-weight: bold;
      text-align: center;
      border-radius: 5px;
      background-color: #4CAF50;
      color: #fff;
      cursor: pointer;
    }
    .character-count {
      margin-top: 5px;
      font-size: 12px;
      color: #888;
    }
  </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
  <h1>SMS Platform </h1>

  <div class="form-container">
    <form id="sms-form">
      <div class="form-group">
        <label class="form-label" for="sender-id">Sender ID:</label>
        <input class="form-input" type="text" id="sender-id" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="recipients">Recipients:</label>
        <textarea class="form-input" id="recipients" rows="4" required></textarea>
        <small>Enter a single number, comma-separated numbers, or numbers on new lines.</small>
      </div>

      <div class="form-group">
        <label class="form-label" for="message">Message:</label>
        <textarea class="form-input" id="message" rows="4" required></textarea>
        <div id="character-count" class="character-count"></div>

      </div>

      <button class="form-button" type="submit">Send SMS</button>
    </form>
  </div>
  <script>
    const pageOneCharLimit = 160;
    const pageTwoCharLimit = 154;

    $(document).ready(function() {
      const characterCountElement = $("#character-count");
      const messageInput = $("#message");

      messageInput.on("input", function() {
        const message = $(this).val();
        const messageLength = message.length;
        let remainingChars;

        if (messageLength <= pageOneCharLimit) {
          remainingChars = pageOneCharLimit - messageLength;
          characterCountElement.text(`${remainingChars} characters remaining for page 1`);
        } else {
          remainingChars = pageTwoCharLimit - (messageLength - pageOneCharLimit);
          characterCountElement.text(`${remainingChars} characters remaining for page 2`);
        }
      });
    });
  </script>
   

</body>
</html>
