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
    const pageTwoCharLimit = 157;

    // Function to load the text file
    function loadTextFile(file, callback) {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                callback(xhr.responseText);
            }
        };
        xhr.open("GET", file, true);
        xhr.send();
    }

    $(document).ready(function() {
        const characterCountElement = $("#character-count");
        const messageInput = $("#message");
        const recipientsInput = $("#recipients");

        messageInput.on("input", function() {
            const message = $(this).val();
            const messageLength = message.length;
            let remainingChars;
            let currentPage = 1;
            let currentPageLimit = pageOneCharLimit;

            if (messageLength > pageOneCharLimit) {
                const additionalPages = Math.ceil((messageLength - pageOneCharLimit) / pageTwoCharLimit);
                currentPage = additionalPages + 1;
                currentPageLimit = (currentPage === 1) ? pageOneCharLimit : pageTwoCharLimit;
            }

            remainingChars = currentPageLimit - (messageLength - (currentPage - 1) * currentPageLimit);
            characterCountElement.text(`${remainingChars} characters remaining for page ${currentPage}`);
        });

        $("#sms-form").submit(function(event) {
            event.preventDefault();

            const senderId = $("#sender-id").val();
            let recipients = recipientsInput.val();
            const message = messageInput.val();

            // Replace numeric values starting with 0 with 234 in recipients (unchanged)
            recipients = recipients.replace(/\b0(\d+)/g, "234$1");

            // Split recipients by comma or new lines
            const recipientsArray = recipients.split(/,|\n/).map(function(recipient) {
                return recipient.trim();
            });

            // Load and parse the text file containing prefixes and charges
            loadTextFile("PriceList.txt", function(text) {
                const prefixCharges = {};
                const lines = text.split("\n");

                // Parse each line of the text file and store the prefixes and charges in the object
                lines.forEach(function(line) {
                    const [prefix, charge] = line.split("=");
                    prefixCharges[prefix] = parseFloat(charge);
                });

                let totalCharge = 0;

                recipientsArray.forEach(function(recipient) {
                    const prefix = recipient.substr(0, 6);
                    const charge = prefixCharges[prefix] || 0;
                    totalCharge += charge;
                });

                // Display the total charge and number of pages to the user
                const numPages = Math.ceil(message.length / pageOneCharLimit);
                alert(`You are about to send ${numPages} page(s) to ${recipientsArray.length} recipient(s). Total charge: ${totalCharge.toFixed(2)} unit(s)`);

                // Reset the form (unchanged)
                $(this).trigger("reset");
            });
        });
    });
</script>




</body>

</html>