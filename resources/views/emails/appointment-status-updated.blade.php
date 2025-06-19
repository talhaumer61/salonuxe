<!DOCTYPE html>
<html>
<head>
    <title>Appointment Status Updated</title>
</head>
<body>
    <h2>Hello {{ $appointment->client_name }},</h2>

    <p>Your appointment status has been updated to:</p>
    <p><strong>{{ ($appointment->status==1?"Accepted":"Rejected") }}</strong></p>

    <p>Thank you for choosing us.</p>
</body>
</html>
