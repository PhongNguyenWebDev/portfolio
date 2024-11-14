<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Contacting Us!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .highlight {
            color: #2d9cdb;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .button {
            display: inline-block;
            padding: 12px 20px;
            background-color: #2d9cdb;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #1a7fb7;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h1>Thank You for Contacting Us, {{ $details['name'] }}!</h1>
        <p>We’ve received your message and will get back to you as soon as possible. Here’s a summary of your
            submission:</p>

        <p><span class="highlight">Name:</span> {{ $details['name'] }}</p>
        <p><span class="highlight">Email:</span> {{ $details['email'] }}</p>
        <p><span class="highlight">Message:</span> {{ $details['message'] }}</p>
    </div>
</body>

</html>
