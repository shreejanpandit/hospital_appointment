<!DOCTYPE html>
<html lang="en">

<head>

    <title>Appointment Mail</title>
</head>

<body>
    <h1>{{ $mailData['title'] }}</h1>
    <p>{{ $mailData['body'] }}</p>

    <p>Hello Dr {{ $mailData['doctor_name'] }}, your an appointment booked by {{ $mailData['patient_name'] }}. Please
        remebber your schedule.
    </p>

    <p>Thank you</p>
</body>

</html>
