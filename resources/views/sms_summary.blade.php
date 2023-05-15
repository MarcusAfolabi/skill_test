<!DOCTYPE html>
<html>
<head>
    <title>SMS Summary</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div>
        <h2>SMS Summary</h2>
        <p>You are about to send {{$numPages}} page(s) to {{$numRecipients}} recipient(s).</p>
        <p>Total charge: {{$totalChargeFormatted}} unit(s).</p>
        <button id="confirmButton">Confirm</button>
    </div>

    <script>
        $(document).ready(function() {
            $('#confirmButton').on('click', function() {
                // Send the SMS
                // ...

                // Show success message
                alert('SMS sent successfully!');
            });
        });
    </script>
</body>
</html>
