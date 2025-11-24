<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #667eea;
            margin: 0;
            font-size: 28px;
        }

        .content {
            color: #333;
            line-height: 1.6;
        }

        .otp-box {
            background-color: #f9f9f9;
            border: 2px solid #667eea;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 30px 0;
        }

        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
            letter-spacing: 5px;
            margin: 0;
        }

        .note {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .note p {
            margin: 0;
            color: #856404;
            font-size: 14px;
        }

        .footer {
            border-top: 1px solid #eee;
            margin-top: 30px;
            padding-top: 20px;
            text-align: center;
            color: #999;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Alumni TPL</h1>
            <p style="color: #999; margin: 5px 0;">Web Alumni TPL</p>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $alumniName }}</strong>,</p>

            <p>Terima kasih telah mendaftar di Portal Alumni TPL. Berikut adalah kode OTP untuk memverifikasi akun Anda:
            </p>

            <div class="otp-box">
                <p class="otp-code">{{ $otpCode }}</p>
            </div>

            <div class="note">
                <p><strong>⏰ Perhatian:</strong> Kode OTP ini akan berlaku selama 10 menit. Jangan bagikan kode ini
                    kepada siapa pun.</p>
            </div>

            <p>Jika Anda tidak melakukan pendaftaran ini, abaikan email ini.</p>

            <p>Salam,<br><strong>Tim Alumni TPL</strong></p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Portal Alumni TPL IPB. Semua hak dilindungi.</p>
        </div>
    </div>
</body>

</html>
