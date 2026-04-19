<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; }
        .header { background: #667eea; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .footer { background: #f8f9fa; padding: 10px; text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Thank You for Contacting GBASE</h2>
        </div>
        <div class="content">
            <p>Dear {{ $submission->name }},</p>
            <p>We have received your message and thank you for getting in touch with GBASE Technologies.</p>
            <p><strong>Your Submission Details:</strong></p>
            <ul>
                <li><strong>Name:</strong> {{ $submission->name }}</li>
                <li><strong>Email:</strong> {{ $submission->email }}</li>
                <li><strong>Phone:</strong> {{ $submission->phone ?? 'Not provided' }}</li>
                <li><strong>Subject:</strong> {{ $submission->subject ?? 'General Inquiry' }}</li>
            </ul>
            <p>Our team will review your message and get back to you soon.</p>
            <p>Best regards,<br>GBASE Technologies Team</p>
        </div>
        <div class="footer">
            <p>&copy; 2026 GBASE Technologies. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
