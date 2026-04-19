<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; }
        .header { background: #667eea; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .message-box { background: #f8f9fa; padding: 15px; border-left: 4px solid #667eea; margin: 15px 0; }
        .footer { background: #f8f9fa; padding: 10px; text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Re: {{ $submission->subject ?? 'Your Inquiry' }}</h2>
        </div>
        <div class="content">
            <p>Dear {{ $submission->name }},</p>
            <p>Thank you for your message. Here is our response:</p>
            <div class="message-box">
                {!! nl2br($reply->message) !!}
            </div>
            <p>If you have any further questions, please don't hesitate to reach out.</p>
            <p>Best regards,<br>GBASE Technologies Team</p>
        </div>
        <div class="footer">
            <p>&copy; 2026 GBASE Technologies. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
