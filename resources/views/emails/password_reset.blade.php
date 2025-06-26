<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Token</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 10px;
        }
        .token-box {
            background-color: #e9ecef;
            border: 2px solid #28a745;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .token {
            font-size: 32px;
            font-weight: bold;
            color: #28a745;
            letter-spacing: 3px;
            font-family: 'Courier New', monospace;
        }
        .instructions {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin: 20px 0;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 4px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            font-size: 14px;
        }
        .username {
            font-weight: bold;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🌱 HydroponicGrow</div>
            <h2>Password Reset Request</h2>
        </div>
        <p>Hello, Higrowers!</span></p>
        
        <p>You have requested to reset your password for your HydroponicGrow account. Please use the following token to verify your identity and proceed with the password reset:</p>
        <div class="token-box">
            <div style="margin-bottom: 10px; font-size: 16px; color: #666;">Your Reset Token:</div>
            <div class="token">{{ $token }}</div>
        </div>
        <div class="instructions">
            <h4>📋 Instructions:</h4>
            <ol>
                <li>Copy the token above</li>
                <li>Go back to the password reset page</li>
                <li>Enter your email address</li>
                <li>Paste the token in the token field</li>
                <li>Click "Verify Token" to continue</li>
            </ol>
        </div>
        <div class="warning">
            <strong>⚠️ Important:</strong>
            <ul>
                <li>This token can only be used once and valid for 10 minutes</li>
                <li>If you didn't request this password reset, please ignore this email</li>
                <li>For security reasons, never share this token with anyone</li>
            </ul>
        </div>
        <p>If you're having trouble with the reset process, please contact our support team.</p>
        <div class="footer">
            <p>This email was sent from HydroponicGrow password reset system.</p>
            <p>© {{ date('Y') }} HydroponicGrow. All rights reserved.</p>
        </div>
    </div>
</body>
</html>