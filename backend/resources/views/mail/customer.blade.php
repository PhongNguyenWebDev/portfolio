<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Contacting Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: rgb(2, 185, 185);
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin: 10px 0;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }

        .footer a {
            color: rgb(95, 228, 228);
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h1>Hi {{ $name }},</h1>
        <p>Thank you for contacting us! We have received your message and will get back to you shortly.</p>

        <p>If you have any immediate questions, feel free to reach out to us anytime.</p>

        <div class="footer">
            <p>Best Regards,<br>Phong Nguyen</p>
            <p><a href="mailto:info@yourcompany.com">Contact Us</a> | <a href="https://phongnguyen.io.vn/">Visit Our
                    Website</a></p>
        </div>
    </div>
</body>

</html>
