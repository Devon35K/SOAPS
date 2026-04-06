<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Notifications - USeP OSAS Sports Unit</title>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800;900&family=Barlow:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
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
            border-radius: 0;
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
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(240,180,41,.3);
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
            color: rgba(255,255,255,.6);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 4px 0 0;
        }
        .content {
            padding: 40px;
        }
        .greeting {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: #1C1410;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .message {
            font-size: 15px;
            color: #3D2A2F;
            margin-bottom: 24px;
            line-height: 1.7;
        }
        .notification-count {
            background: #F0B429;
            color: #1C1410;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 18px;
            font-weight: 800;
            padding: 8px 16px;
            display: inline-block;
            margin-bottom: 20px;
            clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 8px, 100% 100%, 0 100%);
        }
        .notifications-box {
            background: #F5F3EE;
            border-left: 4px solid #F0B429;
            padding: 24px;
            margin: 24px 0;
        }
        .notification-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px 0;
            border-bottom: 1px solid rgba(122,20,40,.1);
        }
        .notification-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .notification-icon {
            width: 32px;
            height: 32px;
            background: rgba(122,20,40,.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .notification-icon::before {
            content: '';
            width: 8px;
            height: 8px;
            background: #7A1428;
            border-radius: 50%;
        }
        .notification-content {
            flex: 1;
        }
        .notification-message {
            font-size: 14px;
            color: #1C1410;
            font-weight: 500;
            margin-bottom: 4px;
        }
        .notification-time {
            font-size: 12px;
            color: #7A5C64;
        }
        .button-container {
            text-align: center;
            margin: 32px 0;
        }
        .btn {
            display: inline-block;
            padding: 16px 40px;
            background: #7A1428;
            color: #FFFFFF;
            text-decoration: none;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #9C1E35;
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
        .contact-link {
            color: #7A1428;
            text-decoration: none;
            font-weight: 600;
        }
        @media (max-width: 600px) {
            .container {
                margin: 20px;
            }
            .content {
                padding: 24px;
            }
            .header {
                padding: 24px;
            }
            .header-text h1 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <div class="logo-badge">
                    <img src="{{ asset('image/SportOffice.png') }}" alt="Sports Office">
                </div>
                <div class="header-text">
                    <h1>New Notifications</h1>
                    <p>USeP OSAS Sports Unit</p>
                </div>
            </div>
        </div>
        
        <div class="content">
            <p class="greeting">Dear {{ $fullName }},</p>
            <p class="message">
                You have new notifications from the USeP OSAS Sports Unit. Please log in to your account to view the complete details.
            </p>
            
            <div class="notification-count">{{ $unreadCount }} Unread Notification{{ $unreadCount > 1 ? 's' : '' }}</div>
            
            <div class="notifications-box">
                @foreach($notifications as $notification)
                    @if(!$notification['is_read'])
                    <div class="notification-item">
                        <div class="notification-icon"></div>
                        <div class="notification-content">
                            <p class="notification-message">{{ $notification['message'] }}</p>
                            <p class="notification-time">{{ date('M d, Y h:i A', strtotime($notification['timestamp'])) }}</p>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
            
            <div class="button-container">
                <a href="{{ url('/login') }}" class="btn">View All Notifications</a>
            </div>
        </div>
        
        <div class="footer">
            <p>Best regards,<br><span class="team">USeP OSAS Sports Unit Team</span></p>
            <p style="margin-top: 8px;">
                <a href="mailto:tagummabinisportoffice@gmail.com" class="contact-link">Contact Us</a>
            </p>
        </div>
    </div>
</body>
</html>
