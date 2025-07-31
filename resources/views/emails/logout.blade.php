<!DOCTYPE html>
<html>
<head>
    <title>Logout Alert</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 600px; margin: 0 auto; }
        .header { background-color: #f8f9fa; padding: 20px; border-radius: 5px; }
        .content { padding: 20px; }
        .footer { text-align: center; padding: 20px; color: #6c757d; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Logout Alert</h1>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>User <strong>{{ $user->name }}</strong> has logged out of the system.</p>
            <p>Logout time: {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>
        <div class="footer">
            <p>This is an automated notification from your blog application.</p>
        </div>
    </div>
</body>
</html>