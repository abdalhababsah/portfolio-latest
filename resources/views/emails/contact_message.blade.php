<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
    <style>
        /* Base styles */
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #252525;
            color: #d9d9d9;
        }
        
        /* Container */
        .container {
            max-width: 600px;
            margin: 40px auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        /* Header section */
        .header {
            background-color: #C19A6B;
            padding: 30px;
            text-align: center;
            color: #252525;
        }
        
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        
        /* Content section */
        .content {
            background-color: #333333;
            padding: 30px;
            position: relative;
        }
        
        /* Message metadata */
        .meta-item {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
        }
        
        .meta-label {
            font-weight: 600;
            width: 80px;
            min-width: 80px;
            font-size: 14px;
            text-transform: uppercase;
            color: #C19A6B;
            padding-top: 2px;
        }
        
        .meta-value {
            background-color: #3a3a3a;
            padding: 8px 15px;
            border-radius: 5px;
            flex-grow: 1;
        }
        
        /* Divider */
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #C19A6B, transparent);
            margin: 25px 0;
            border: none;
        }
        
        /* Message content */
        .message-container {
            background-color: #3a3a3a;
            border-radius: 10px;
            padding: 25px;
            margin-top: 20px;
            border-left: 3px solid #C19A6B;
            white-space: pre-wrap;
        }
        
        /* Footer */
        .footer {
            background-color: #252525;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        
        /* Decorative elements */
        .accent-corner {
            position: absolute;
            width: 50px;
            height: 50px;
            right: 0;
            top: 0;
            background: rgba(193, 154, 107, 0.1);
            border-bottom-left-radius: 100%;
        }
        
        .accent-corner:before {
            content: "";
            position: absolute;
            width: 25px;
            height: 25px;
            right: 0;
            top: 0;
            background: rgba(193, 154, 107, 0.2);
            border-bottom-left-radius: 100%;
        }
        
        /* Responsive */
        @media screen and (max-width: 600px) {
            .container {
                margin: 20px 10px;
            }
            
            .header {
                padding: 20px;
            }
            
            .content {
                padding: 20px;
            }
            
            .meta-item {
                flex-direction: column;
            }
            
            .meta-label {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Contact Message</h1>
        </div>
        
        <div class="content">
            <div class="accent-corner"></div>
            
            <div class="meta-item">
                <span class="meta-label">Name</span>
                <div class="meta-value">{{ $contact->name }}</div>
            </div>
            
            <div class="meta-item">
                <span class="meta-label">Email</span>
                <div class="meta-value">{{ $contact->email }}</div>
            </div>
            
            <div class="meta-item">
                <span class="meta-label">Subject</span>
                <div class="meta-value">{{ $contact->subject }}</div>
            </div>
            
            <div class="divider"></div>
            
            <div class="message-container">
                {!! nl2br(e($contact->message)) !!}
            </div>
        </div>
        
        <div class="footer">
            This message was sent from your portfolio contact form.
        </div>
    </div>
</body>
</html>