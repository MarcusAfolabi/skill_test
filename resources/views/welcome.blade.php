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

        // $(document).ready(function() {
        //     // Prefixes and corresponding unit charges per page
        //     const prefixCharges = {
        //         "234705": 2.2,
        //         "234805": 2.2,
        //         "234807": 2.2,
        //         "234815": 2.2,
        //         "234811": 2.2,
        //         "234905": 2.2,
        //         "234803": 1.9,
        //         "234706": 1.9,
        //         "234703": 1.9,
        //         "234810": 1.9,
        //         "234806": 1.9,
        //         "234813": 1.9,
        //         "234816": 1.9,
        //         "234814": 1.9,
        //         "234903": 1.9,
        //         "234906": 1.9,
        //         "234708": 1.9,
        //         "234802": 1.9,
        //         "234808": 1.9,
        //         "234812": 1.9,
        //         "234701": 1.9,
        //         "234902": 1.9,
        //         "234907": 1.9,
        //         "234809": 1.9,
        //         "234817": 1.9,
        //         "234818": 1.9,
        //         "234909": 1.9,
        //         "234908": 1.9,
        //         "234709": 5,
        //         "2347027": 5,
        //         "2347028": 4,
        //         "2347029": 4,
        //         "234819": 4,
        //         "2347026": 4,
        //         "2347025": 4,
        //         "234704": 4,
        //         "234707": 4,
        //         "234804": 5
        //     };

        //     const characterCountElement = $("#character-count");
        //     const messageInput = $("#message");
        //     const recipientsInput = $("#recipients");

        //     messageInput.on("input", function() {
        //         const message = $(this).val();
        //         const messageLength = message.length;
        //         let remainingChars;

        //         if (messageLength <= pageOneCharLimit) {
        //             remainingChars = pageOneCharLimit - messageLength;
        //             characterCountElement.text(`${remainingChars} characters remaining for page 1`);
        //         } else {
        //             remainingChars = pageTwoCharLimit - (messageLength - pageOneCharLimit);
        //             characterCountElement.text(`${remainingChars} characters remaining for page 2`);
        //         }
        //     });
        // });

        // $("#sms-form").submit(function(event) {
        //     event.preventDefault();

        //     const senderId = $("#sender-id").val();
        //     let recipients = recipientsInput.val();
        //     const message = messageInput.val();

        //     // Replace numeric values starting with 0 with 234 in recipients (unchanged)
        //     recipients = recipients.replace(/\b0(\d+)/g, "234$1");

        //     // Split recipients by comma or new lines
        //     const recipientsArray = recipients.split(/,|\n/).map(function(recipient) {
        //         return recipient.trim();
        //     });

        //     let totalCharge = 0;

        //     recipientsArray.forEach(function(recipient) {
        //         const prefix = recipient.substr(0, 6);
        //         const charge = prefixCharges[prefix] || 0;
        //         totalCharge += charge;
        //     });

        //     // Display the total charge to the user
        //     alert(`Total charge: ${totalCharge} unit(s)`);

        //     // Reset the form (unchanged)
        //     $(this).trigger("reset");
        // });
        $(document).ready(function() {
            const prefixCharges = {
                "234705": 2.2,
                "234805": 2.2,
                "234807": 2.2,
                "234815": 2.2,
                "234811": 2.2,
                "234905": 2.2,
                "234803": 1.9,
                "234706": 1.9,
                "234703": 1.9,
                "234810": 1.9,
                "234806": 1.9,
                "234813": 1.9,
                "234816": 1.9,
                "234814": 1.9,
                "234903": 1.9,
                "234906": 1.9,
                "234708": 1.9,
                "234802": 1.9,
                "234808": 1.9,
                "234812": 1.9,
                "234701": 1.9,
                "234902": 1.9,
                "234907": 1.9,
                "234809": 1.9,
                "234817": 1.9,
                "234818": 1.9,
                "234909": 1.9,
                "234908": 1.9,
                "234709": 5,
                "2347027": 5,
                "2347028": 4,
                "2347029": 4,
                "234819": 4,
                "2347026": 4,
                "2347025": 4,
                "234704": 4,
                "234707": 4,
                "234804": 5
            };

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
                    currentPageLimit = pageTwoCharLimit;
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

                let totalPages = 0;
                let totalCharge = 0;

                recipientsArray.forEach(function(recipient) {
                    const prefix = recipient.substr(0, 6);
                    const charge = prefixCharges[prefix] || 0;

                    // Calculate the number of pages based on the message length
                    const messageLength = message.length;
                    const numPages = Math.ceil(messageLength / 160);

                    // Calculate the charge per page for the current recipient
                    const recipientCharge = charge * numPages;

                    // Add the recipient's charge and number of pages to the total
                    totalCharge += recipientCharge;
                    totalPages += numPages;
                });

                // Display the number of pages and total charge to the user
                alert(`You are about to send to ${recipientsArray.length} recipient(s). Total charge: ${totalCharge.toFixed(2)} unit(s)`);
                // alert(`You are about to send ${totalPages} page(s) to ${recipientsArray.length} recipient(s). Total charge: ${totalCharge.toFixed(2)} unit(s)`);

                // Reset the form (unchanged)
                $(this).trigger("reset");
            });
        });
    </script>



</body>

</html>