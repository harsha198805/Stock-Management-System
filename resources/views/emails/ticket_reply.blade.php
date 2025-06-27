<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Ticket Response</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            background-color: #f6f6f6;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .email-header {
            text-align: center;
            background-color: #4CAF50;
            color: white;
            padding: 20px 0;
            border-radius: 8px 8px 0 0;
            border-bottom: 2px solid #3e8e41;
        }

        .email-header h1 {
            font-size: 24px;
            margin: 0;
        }

        .email-body {
            padding: 20px;
            line-height: 1.6;
            color: #555;
        }

        .email-body h2 {
            font-size: 20px;
            color: #333;
        }

        .email-body p {
            margin: 10px 0;
        }

        .info {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 4px;
            background-color: #f9f9f9;
        }

        .info strong {
            color: #000;
            font-weight: 600;
        }

        .email-footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #888;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        @media only screen and (max-width: 600px) {
            .email-wrapper {
                width: 100%;
                padding: 10px;
            }

            .email-header h1 {
                font-size: 20px;
            }

            .email-body h2 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-header">
            <h1>Response to Ticket #{{ $reply->ticket->reference }}</h1>
        </div>

        <div class="email-body">
            <p><strong>Customer Name:</strong> {{ $reply->ticket->customer_name }}</p>
            <p><strong>Your Question:</strong> {{ $reply->ticket->description }}</p>

            <p><strong>Agent Response:</strong></p>
            <div class="info">
                <p>{{ $reply->reply }}</p>
            </div>

            <p>Thank you,<br><strong>Support Team</strong></p>
        </div>

        <div class="email-footer">
            <p>This is an automated message. Please do not reply directly to this email.</p>
        </div>
    </div>
</body>
</html>
