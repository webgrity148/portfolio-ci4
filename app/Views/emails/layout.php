<!DOCTYPE html>
<html>
<head>
    <title>Email Layout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .email-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .email-header {
            background-color: #007BFF;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        .email-body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Your Website</h1>
        </div>
        <div class="email-body">
            <p>Dear {name},</p>
            <p>Thank you for registering with us. We're excited to have you on board!</p>
            <p>Best regards,<br> The Team</p>
        </div>
    </div>
</body>
</html>
