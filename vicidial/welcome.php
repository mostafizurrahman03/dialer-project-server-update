<?php
# welcome.php - VICIDIAL welcome page
# 
# Copyright (C) 2023  Matt Florell <vicidial@gmail.com>    LICENSE: AGPLv2
#

header ("Content-type: text/html; charset=utf-8");

require_once("dbconnect_mysqli.php");
require("functions.php");

# if options file exists, use the override values for the above variables
#   see the options-example.php file for more information
if (file_exists('options.php'))
	{
	require('options.php');
	}

#############################################
##### START SYSTEM_SETTINGS LOOKUP #####
$stmt = "SELECT use_non_latin,enable_languages,language_method,default_language,agent_screen_colors,admin_web_directory,agent_script,allow_web_debug,hopper_hold_inserts FROM system_settings;";
$rslt=mysql_to_mysqli($stmt, $link);
$qm_conf_ct = mysqli_num_rows($rslt);
if ($qm_conf_ct > 0)
	{
	$row=mysqli_fetch_row($rslt);
	$non_latin =				$row[0];
	$SSenable_languages =		$row[1];
	$SSlanguage_method =		$row[2];
	$default_language =			$row[3];
	$agent_screen_colors =		$row[4];
	$admin_web_directory =		$row[5];
	$SSagent_script =			$row[6];
	$SSallow_web_debug =		$row[7];
	$SShopper_hold_inserts =	$row[8];
	}
if ($SSallow_web_debug < 1) {$DB=0;}
##### END SETTINGS LOOKUP #####
###########################################

##### BEGIN Define colors and logo #####
$SSmenu_background='015B91';
$SSframe_background='D9E6FE';
$SSstd_row1_background='9BB9FB';
$SSstd_row2_background='B9CBFD';
$SSstd_row3_background='8EBCFD';
$SSstd_row4_background='B6D3FC';
$SSstd_row5_background='A3C3D6';
$SSalt_row1_background='BDFFBD';
$SSalt_row2_background='99FF99';
$SSalt_row3_background='CCFFCC';

$selected_logo = "images/vicidial_logo.png"; // Default logo path

if ($agent_screen_colors != 'default')
	{
	$stmt = "SELECT menu_background,frame_background,std_row1_background,std_row2_background,std_row3_background,std_row4_background,std_row5_background,alt_row1_background,alt_row2_background,alt_row3_background,web_logo FROM vicidial_screen_colors where colors_id='$agent_screen_colors';";
	$rslt=mysql_to_mysqli($stmt, $link);
	$qm_conf_ct = mysqli_num_rows($rslt);
	if ($qm_conf_ct > 0)
		{
		$row=mysqli_fetch_row($rslt);
		$SSmenu_background =		$row[0];
		$SSframe_background =		$row[1];
		$SSstd_row1_background =	$row[2];
		$SSstd_row2_background =	$row[3];
		$SSstd_row3_background =	$row[4];
		$SSstd_row4_background =	$row[5];
		$SSstd_row5_background =	$row[6];
		$SSalt_row1_background =	$row[7];
		$SSalt_row2_background =	$row[8];
		$SSalt_row3_background =	$row[9];
		
		// Fix for SSweb_logo variable
		if (isset($row[10]) && !empty($row[10])) {
			$SSweb_logo = $row[10];
		} else {
			$SSweb_logo = 'default_new';
		}
		}
	}

// Set default if SSweb_logo is not set
if (!isset($SSweb_logo)) {
    $SSweb_logo = 'default_new';
}

$Mhead_color =	$SSstd_row5_background;
$Mmain_bgcolor = $SSmenu_background;

// Logo path determination with proper error checking
$selected_logo = "images/vicidial_admin_web_logo.png"; // Default

// Check if admin_web_directory is set
if (!isset($admin_web_directory) || empty($admin_web_directory)) {
    $admin_web_directory = 'vicidial';
}

// Logo selection logic
if ($SSweb_logo == 'default_new') {
    $logo_path = "images/vicidial_admin_web_logo.png";
    if (file_exists($logo_path)) {
        $selected_logo = $logo_path;
    } else {
        // Try alternative paths
        $alt_paths = [
            "./images/vicidial_admin_web_logo.png",
            "../$admin_web_directory/images/vicidial_admin_web_logo.png",
            "vicidial_admin_web_logo.gif",
            "help.gif"
        ];
        
        foreach ($alt_paths as $path) {
            if (file_exists($path)) {
                $selected_logo = $path;
                break;
            }
        }
    }
}
elseif ($SSweb_logo == 'default_old') {
    if (file_exists("vicidial_admin_web_logo.gif")) {
        $selected_logo = "vicidial_admin_web_logo.gif";
    }
}
else {
    // Custom logo
    $custom_logo_path = "../$admin_web_directory/images/vicidial_admin_web_logo$SSweb_logo";
    if (file_exists($custom_logo_path)) {
        $selected_logo = $custom_logo_path;
    }
}

// Final fallback - if no logo found, use a data URI with text
if (!file_exists($selected_logo)) {
    // Create a simple text-based logo
    $selected_logo = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='60' viewBox='0 0 200 60'%3E%3Crect width='200' height='60' fill='%23" . $SSmenu_background . "'/%3E%3Ctext x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' fill='white' font-family='Arial' font-size='24'%3EVICIDIAL%3C/text%3E%3C/svg%3E";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VICIDIAL Welcome Screen</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #133870 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .welcome-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 480px;
            overflow: hidden;
            position: relative;
        }
        
        .header-section {
            background: linear-gradient(135deg, #<?php echo $SSmenu_background; ?> 0%, #2c3e50 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .header-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #00dbde, #fc00ff);
        }
        
        .logo-container {
            margin-bottom: 20px;
            min-height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo-container img {
            max-width: 200px;
            max-height: 80px;
            width: auto;
            height: auto;
            object-fit: contain;
        }
        
        .welcome-title {
            color: white;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }
        
        .welcome-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            font-weight: 400;
        }
        
        .links-section {
            padding: 40px 30px;
            background: #f8fafc;
        }
        
        .links-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .login-card {
            background: white;
            border-radius: 16px;
            padding: 28px;
            display: flex;
            align-items: center;
            gap: 20px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
        }
        
        .login-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: #<?php echo $SSmenu_background; ?>;
            transition: width 0.3s ease;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            border-color: #<?php echo $SSmenu_background; ?>;
        }
        
        .login-card:hover::before {
            width: 8px;
        }
        
        .icon-container {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 24px;
            color: white;
        }
        
        .agent-icon {
            background: linear-gradient(135deg, #00b09b, #96c93d);
        }
        
        .admin-icon {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }
        
        .timeclock-icon {
            background: linear-gradient(135deg, #f093fb, #f5576c);
        }
        
        .hci-icon {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
        }
        
        .link-content {
            flex-grow: 1;
        }
        
        .link-title {
            font-size: 18px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .link-desc {
            font-size: 14px;
            color: #718096;
            line-height: 1.5;
        }
        
        .arrow-icon {
            color: #a0aec0;
            transition: transform 0.3s ease;
        }
        
        .login-card:hover .arrow-icon {
            transform: translateX(5px);
            color: #<?php echo $SSmenu_background; ?>;
        }
        
        .footer-section {
            padding: 25px 30px;
            text-align: center;
            background: white;
            border-top: 1px solid #e2e8f0;
        }
        
        .footer-text {
            color: #718096;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .vicidial-brand {
            color: #<?php echo $SSmenu_background; ?>;
            font-weight: 600;
        }
        
        .pulse-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #48bb78;
            border-radius: 50%;
            margin-left: 10px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { opacity: 0.6; }
            50% { opacity: 1; }
            100% { opacity: 0.6; }
        }
        
        .server-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: #48bb78;
            background: #f0fff4;
            padding: 4px 10px;
            border-radius: 20px;
            margin-top: 10px;
        }
        
        @media (max-width: 480px) {
            .welcome-container {
                border-radius: 20px;
            }
            
            .header-section {
                padding: 30px 20px;
            }
            
            .links-section {
                padding: 30px 20px;
            }
            
            .login-card {
                padding: 20px;
            }
            
            .icon-container {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
            
            .welcome-title {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="header-section">
            <div class="logo-container">
                <img src="<?php echo $selected_logo; ?>" alt="VICIDIAL Logo" onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'200\' height=\'60\' viewBox=\'0 0 200 60\'%3E%3Crect width=\'200\' height=\'60\' fill=\'%23<?php echo $SSmenu_background; ?>\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' fill=\'white\' font-family=\'Arial\' font-size=\'24\'%3EVICIDIAL%3C/text%3E%3C/svg%3E';">
            </div>
            <h1 class="welcome-title">Welcome to VICIDIAL</h1>
            <p class="welcome-subtitle">Choose your login portal below</p>
            
            <div class="server-status">
                <i class="fas fa-server"></i>
                <span>System Online</span>
                <span class="pulse-dot"></span>
            </div>
        </div>
        
        <div class="links-section">
            <div class="links-grid">
                <!-- Agent Login Card -->
                <a href="../agc/<?php echo $SSagent_script; ?>" class="login-card">
                    <div class="icon-container agent-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="link-content">
                        <div class="link-title">
                            Agent Login
                            <i class="fas fa-arrow-right arrow-icon"></i>
                        </div>
                        <p class="link-desc">
                            Access the agent interface to handle calls and customer interactions
                        </p>
                    </div>
                </a>
                
                <!-- Administration Login Card -->
                <a href="../<?php echo $admin_web_directory; ?>/admin.php" class="login-card">
                    <div class="icon-container admin-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="link-content">
                        <div class="link-title">
                            Administration
                            <i class="fas fa-arrow-right arrow-icon"></i>
                        </div>
                        <p class="link-desc">
                            Manage system settings, users, campaigns and reports
                        </p>
                    </div>
                </a>
                
                <!-- Timeclock Login Card -->
                <a href="../agc/timeclock.php?referrer=welcome" class="login-card">
                    <div class="icon-container timeclock-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="link-content">
                        <div class="link-title">
                            Timeclock
                            <i class="fas fa-arrow-right arrow-icon"></i>
                        </div>
                        <p class="link-desc">
                            Clock in/out and track your working hours
                        </p>
                    </div>
                </a>
                
                <!-- HCI Screen Card -->
                <?php if (isset($SShopper_hold_inserts) && $SShopper_hold_inserts > 0): ?>
                <a href="../<?php echo $admin_web_directory; ?>/hci_screen.php" class="login-card">
                    <div class="icon-container hci-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="link-content">
                        <div class="link-title">
                            HCI Screen
                            <i class="fas fa-arrow-right arrow-icon"></i>
                        </div>
                        <p class="link-desc">
                            Hopper Control Interface for managing call lists
                        </p>
                    </div>
                </a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="footer-section">
            <p class="footer-text">
                <i class="fas fa-shield-alt"></i>
                Secure Access Portal   
                <span class="vicidial-brand">VICIDIAL</span>
                Call Center Solution
            </p>
        </div>
    </div>
    
    <script>
        // Add subtle hover effects
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.login-card');
            
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
            
            // Add page load animation
            const container = document.querySelector('.welcome-container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                container.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>
<?php
exit;
?>