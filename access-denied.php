<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied | Unauthorized Access</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #f5576c 75%, #4facfe 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="10" cy="10" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="30" cy="20" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="70" cy="15" r="2.5" fill="rgba(255,255,255,0.1)"/><circle cx="85" cy="40" r="1.8" fill="rgba(255,255,255,0.1)"/><circle cx="15" cy="70" r="2.2" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="85" r="1.7" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="80" r="2" fill="rgba(255,255,255,0.1)"/></svg>');
            opacity: 0.5;
            pointer-events: none;
        }

        .container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 600px;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
        }

        .icon {
            font-size: 80px;
            background: rgba(255, 255, 255, 0.2);
            width: 120px;
            height: 120px;
            line-height: 120px;
            border-radius: 60px;
            margin: 0 auto 20px;
        }

        h1 {
            color: white;
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
        }

        .content {
            padding: 40px 30px;
        }

        .ip-section {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            text-align: center;
        }

        .ip-label {
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #5a67d8;
            margin-bottom: 10px;
            display: block;
        }

        .ip-address {
            font-size: 28px;
            font-weight: 800;
            font-family: 'Courier New', monospace;
            background: white;
            display: inline-block;
            padding: 12px 24px;
            border-radius: 50px;
            color: #2d3748;
            border: 2px solid #667eea;
        }

        .warning-box {
            background: #fff5f5;
            border-left: 4px solid #f56565;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .allowed-ips {
            background: #f0fff4;
            border: 1px solid #c6f6d5;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .allowed-title {
            font-size: 14px;
            font-weight: 700;
            color: #38a169;
            margin-bottom: 15px;
        }

        .ip-badge {
            display: inline-block;
            background: #38a169;
            color: white;
            padding: 8px 16px;
            border-radius: 50px;
            font-family: monospace;
            font-size: 14px;
            font-weight: 600;
            margin: 5px;
        }

        .buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-bottom: 20px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #4a5568;
        }

        .btn-secondary:hover {
            background: #cbd5e0;
        }

        .footer {
            background: #f7fafc;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .footer-text {
            color: #718096;
            font-size: 12px;
        }

        @media (max-width: 640px) {
            .ip-address {
                font-size: 20px;
                padding: 8px 16px;
            }
            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <div class="icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h1>Access Denied</h1>
                <div class="subtitle">Unauthorized Access Attempt</div>
            </div>
            
            <div class="content">
                <div class="ip-section">
                    <span class="ip-label">
                        <i class="fas fa-map-marker-alt"></i> YOUR IP ADDRESS
                    </span>
                    <div class="ip-address">
                        <i class="fas fa-terminal"></i> 
                        <?php
                            $ip = $_SERVER['REMOTE_ADDR'];
                            echo htmlspecialchars($ip);
                        ?>
                    </div>
                </div>
                
                <div class="warning-box">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Access Restricted</strong>
                    <div class="warning-text" style="margin-top: 10px;">
                        Your IP address is not authorized to access phpMyAdmin.
                    </div>
                </div>
                
                <div class="allowed-ips">
                    <div class="allowed-title">
                        <i class="fas fa-check-circle"></i> AUTHORIZED IP ADDRESSES
                    </div>
                    <div>
                        <span class="ip-badge">
                            <i class="fas fa-server"></i> 43.231.78.203
                        </span>
                        <span class="ip-badge">
                            <i class="fas fa-laptop"></i> 127.0.0.1
                        </span>
                    </div>
                </div>
                
                <div class="buttons">
                    <button onclick="history.back()" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Go Back
                    </button>
                    <button onclick="window.location.reload()" class="btn btn-primary">
                        <i class="fas fa-sync-alt"></i> Try Again
                    </button>
                </div>
            </div>
            
            <div class="footer">
                <div class="footer-text">
                    <i class="fas fa-shield-virus"></i> Protected by IP Whitelist
                    <i class="fas fa-circle" style="font-size: 4px; vertical-align: middle;"></i>
                    <i class="far fa-clock"></i> <?php echo date('Y-m-d H:i:s'); ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
