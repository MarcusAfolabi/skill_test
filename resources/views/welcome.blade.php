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
    @php
    $numPages = Session::get('numPages');
    $numRecipients = Session::get('numRecipients');
    $totalCharge = Session::get('totalCharge');
    @endphp
    <p>You are about to send {{ $numPages }} page(s) to {{ $numRecipients }} recipient(s).</p>
    <p>Total charge: {{ $totalCharge }} unit(s)</p>

    <div class="form-container">
        <form id="sms-form" method="POST" action="{{ route('sms.send') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="sender-id">Sender ID:</label>
                <input class="form-input" name="sender_id" type="text" id="sender-id" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="recipients">Recipients:</label>
                <textarea class="form-input" name="recipients" id="recipients" rows="4" required></textarea>
                <small>Enter a single number, comma-separated numbers, or numbers on new lines.</small>
            </div>

            <div class="form-group">
                <label class="form-label" for="message">Message:</label>
                <textarea class="form-input" name="message" id="message" rows="4" required></textarea>
                <div id="character-count" class="character-count"></div>
            </div>

            <button class="form-button" type="submit">Send SMS</button>
        </form>
    </div>

    <!-- <script>
    const pageOneCharLimit = 160;
    const pageTwoCharLimit = 154;

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
            let currentPage = 1;
            let remainingChars;

            if (messageLength <= 160) {
                remainingChars = 160 - messageLength;
            } else {
                currentPage = Math.ceil((messageLength - 160) / 154) + 1;
                remainingChars = 154 - ((messageLength - 160) % 154 || 154);
            }

            characterCountElement.text(`${remainingChars} characters remaining for page ${currentPage}`);
        });


        $("#sms-form").submit(function(event) {
            event.preventDefault();

            const message = messageInput.val();
            let recipients = recipientsInput.val();

            // Replace numeric values starting with 0 with 234 in recipients
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
                    const numPages = Math.ceil(message.length / 160);
                    totalCharge += charge * numPages;
                });

                // Display the total charge and number of pages to the user
                const numPages = Math.ceil(message.length / 160);
                alert(`You are about to send ${numPages} page(s) to ${recipientsArray.length} recipient(s). Total charge: ${totalCharge.toFixed(2)} unit(s)`);

                // Reset the form (optional)
                $(this).trigger("reset");
            });
        });
    });
</script> -->




</body>

</html>