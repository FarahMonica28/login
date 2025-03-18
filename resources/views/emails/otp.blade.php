<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sending OTP in Email Using Laravel 10 - Techsolutionstuff</title>
</head>
<body>
    {{-- <p>Dear {{ name }}</p> --}}
    
    <p>Kode OTP kamu adalah: <strong>{{ $otp }}</strong></p>

    {{-- <p>Please use this OTP to complete your authentication process.</p> --}}
    <p>This code will expire in 5 minutes.</p>
    {{-- <p>{{ $otp['expired'] }}</p> --}}

    <p>Terimakasih,</p>
    <p>Your Application Team</p>
</body>
</html>