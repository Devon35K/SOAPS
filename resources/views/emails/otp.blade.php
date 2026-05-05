<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset OTP - USeP OSAS Sports Unit</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800;900&family=Barlow:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Barlow', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #F5F3EE;
            color: #3D2A2F;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #FFFFFF;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 20px, 100% 100%, 0 100%);
        }

        .header {
            background: #7A1428;
            padding: 32px 40px;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #F0B429 0%, #C48F10 60%, transparent 100%);
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            z-index: 1;
        }

        .logo-badge {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, .1);
            border: 1px solid rgba(240, 180, 41, .3);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-badge img {
            width: 36px;
            height: 36px;
            object-fit: contain;
        }

        .header-text h1 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 24px;
            font-weight: 800;
            color: #FFFFFF;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }

        .header-text p {
            font-size: 12px;
            color: rgba(255, 255, 255, .6);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 4px 0 0;
        }

        .content {
            padding: 40px;
        }

        .content h3 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: #7A1428;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .content p {
            font-size: 15px;
            color: #3D2A2F;
            margin-bottom: 24px;
            line-height: 1.7;
        }

        .otp-box {
            background: #F5F3EE;
            border-left: 4px solid #F0B429;
            padding: 32px;
            margin: 32px 0;
            text-align: center;
        }

        .otp-code {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 36px;
            font-weight: 800;
            color: #7A1428;
            letter-spacing: 12px;
            margin: 0;
        }

        .footer {
            background: #F5F3EE;
            padding: 24px 40px;
            text-align: center;
        }

        .footer p {
            font-size: 13px;
            color: #7A5C64;
            margin: 0;
        }

        .footer .team {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 600;
            color: #7A1428;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @media (max-width: 600px) {
            .container {
                margin: 20px;
            }

            .header {
                padding: 24px;
            }

            .content {
                padding: 32px 24px;
            }

            .header-text h1 {
                font-size: 18px;
            }

            .otp-code {
                font-size: 28px;
                letter-spacing: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="header-content">

                <div class="header-text">
                    <h1>Password Reset</h1>
                    <p>USeP OSAS Sports Unit</p>
                </div>
            </div>
        </div>
        <div class="content">
            <h3>Verification Code</h3>
            <p>You have requested to reset your password. Please use the following OTP code to verify your identity.
                This code will expire in 15 minutes.</p>
            <div class="otp-box">
                <p class="otp-code">{{ $otp }}</p>
            </div>
            <p>If you did not request this password reset, you can safely ignore this email.</p>
        </div>
        <div class="footer">
            <p>Best regards,<br><span class="team">USeP OSAS Sports Unit Team</span></p>
            <p style="margin-top: 12px;">&copy; {{ date('Y') }} USeP OSAS. All rights reserved.</p>
        </div>
    </div>
</body>

</html>