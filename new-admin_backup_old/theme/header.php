<?php
$base = '/admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADMIN PORTAL</title>

    <link rel="stylesheet" href="<?php echo $base; ?>/theme/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $base; ?>/theme/adminlte/dist/css/adminlte.min.css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            min-height: 100vh;
            font-size: 14px;
            overflow-x: hidden;
            background: #f4f6f9;
        }

        /* =========================
           FLEX LAYOUT FIX
        ========================= */
        .wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* =========================
           SIDEBAR
        ========================= */
        .main-sidebar {
            width: 250px !important;
            min-width: 250px !important;
            max-width: 250px !important;
            box-shadow: none !important;
        }

        .main-sidebar .brand-link {
            display: block;
            width: 250px !important;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,.08) !important;
            font-size: 14px;
            font-weight: 600;
            padding: 14px 10px;
        }

        .main-sidebar .sidebar {
            width: 250px !important;
        }

        .nav-sidebar .nav-link {
            display: flex !important;
            align-items: center;
            padding: .7rem 1rem;
            border-radius: 4px;
            margin: 2px 6px;
            width: calc(100% - 12px);
        }

        .nav-sidebar .nav-icon {
            width: 1.6rem !important;
            margin-right: .5rem !important;
            text-align: center;
        }

        .nav-sidebar .nav-link.active {
            background-color: #007bff !important;
            color: #fff !important;
        }

        body.sidebar-collapse .main-sidebar {
            margin-left: -250px !important;
        }

        /* =========================
           HEADER + CONTENT
        ========================= */
        .main-header,
        .content-wrapper,
        .main-footer {
            margin-left: 250px !important;
        }

        body.sidebar-collapse .main-header,
        body.sidebar-collapse .content-wrapper,
        body.sidebar-collapse .main-footer {
            margin-left: 0 !important;
        }

        .navbar {
            box-shadow: none !important;
            border-bottom: 1px solid #dee2e6 !important;
        }

        .content-wrapper {
            flex: 1 0 auto;
            min-height: auto !important;
            background-color: #f4f6f9 !important;
            padding: 8px 12px !important;
        }

        .container-fluid {
            padding-left: 6px !important;
            padding-right: 6px !important;
        }

        /* =========================
           CARD CLEAN UI
        ========================= */
        .content .card {
            box-shadow: none !important;
            border: none !important;
            border-radius: 6px !important;
        }

        .content .card-header {
            display: none !important;
        }

        .content .card-body {
            padding: 10px 12px !important;
        }

        /* =========================
           TABLE MODERN LOOK
        ========================= */
        table {
            font-size: 13px !important;
        }

        table th {
            background: #343a40 !important;
            color: #fff !important;
            padding: 6px !important;
        }

        table td {
            padding: 6px !important;
        }

        table tr:hover td {
            background: #f1f3f5 !important;
        }

        /* =========================
           FOOTER FIX
        ========================= */
        .main-footer {
            display: block !important;
            background: #fff !important;
            border-top: 1px solid #dee2e6 !important;
            padding: 10px 15px !important;
            font-size: 13px !important;
            margin-left: 250px !important;
            flex-shrink: 0;
        }

        body.sidebar-collapse .main-footer {
            margin-left: 0 !important;
        }

        /* =========================
           SMALL UI HELPERS
        ========================= */
        .btn-sm {
            border-radius: 4px !important;
            padding: .3rem .65rem !important;
            font-size: 12px !important;
        }
		.legacy-card-body {
    padding: 12px !important;
    overflow-x: auto;
}

.legacy-card-body table {
    max-width: 100%;
}

.legacy-card-body img {
    max-width: 100%;
    height: auto;
}
    </style>

    <!-- =============================
         VICIDIAL REQUIRED JS
    ============================== -->
    <script>
    function user_submit()
    {
        var user_field = document.getElementById("user");
        if (user_field) user_field.disabled = false;
        if (document.userform) document.userform.submit();
    }

    var weak = new Image();
    weak.src = "images/weak.png";
    var medium = new Image();
    medium.src = "images/medium.png";
    var strong = new Image();
    strong.src = "images/strong.png";

    function pwdChanged(pwd_field_str, pwd_img_str, pwd_len_field, pwd_len_min)
    {
        var pwd_field = document.getElementById(pwd_field_str);
        var pwd_img = document.getElementById(pwd_img_str);

        if (!pwd_field || !pwd_img) return false;

        var val = pwd_field.value;
        var len = val.length;

        var strong_regex = /^(?=.{20,})(?=.*[a-zA-Z])(?=.*[0-9])/;
        var medium_regex = /^(?=.{10,})(?=.*[a-zA-Z])(?=.*[0-9])/;

        if (len < parseInt(pwd_len_min || 0)) {
            pwd_img.src = "images/weak.png";
        } else if (strong_regex.test(val)) {
            pwd_img.src = "images/strong.png";
        } else if (medium_regex.test(val)) {
            pwd_img.src = "images/medium.png";
        } else {
            pwd_img.src = "images/weak.png";
        }

        return true;
    }
    </script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">