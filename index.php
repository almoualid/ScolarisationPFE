<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background: url(./images/bg_eleve.png) center top repeat-x #f7f2df;
        }

        .accueil-header, .accueil-body, .accueil-footer {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .accueil-header {
            text-align: center;
            height: 200px;
        }

        .accueil-body {
            text-align: center;
            margin-top: 20px;
        }

        .accueil-footer {
            background: #f9f6ea;
            border-top: 1px solid #d2d6de;
            padding: 12px;
            text-align: center;
            margin-top:110px;
        }

        .accueil-component {
            max-width: 500px;
            margin: 0 auto;
            display: block;
            margin-bottom: 20px;
        }

        .accueil-component:hover {
            box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 45px, rgba(0, 0, 0, 0.22) 0px 10px 18px;
            cursor: pointer;
        }
        .materiel-color-green {
            background: #47d147;
        }
        .materiel-color-blue {
            background: #1a75ff;
        }

        .accueil-component-icon {
            margin: 0 auto;
            border: 0px solid;
            width: 150px;
            border-radius: 50%;
        }

        .accueil-component-icon img {
            width: 100%;
            height: auto;
            border-radius: 50%;
            border: 4px solid #9da7dc;
            margin-top:10px;
        }

        .accueil-component-title {
            border: 0px solid;
            background: #eeeeee;
            width: 100%;
            margin-top: 15px;
        }

        .accueil-component-title p {
            font-size: 20px;
            font-weight: 700;
            text-align: center;
            margin-top: 15px;
        }

        .pull-right, .pull-left {
            display: inline-block;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="accueil-header">
        <img class="header-log img-fluid" id="logo-men" src="./images/LogoMenAr.png" style="max-width: 100%;">
    </div>
    <div class="accueil-body">
        <div class="row">
            <div class="col-md-6">
                <div class="accueil-component materiel-color-blue" onclick="redirectToLogin()">
                    <div class="accueil-component-icon">
                        <img src="./images/directeur general.jpg" class="img-fluid">
                    </div>
                    <div class="accueil-component-title">
                        <p >الفضاء الخاص بالمؤسسات</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="accueil-component materiel-color-green" onclick="redirectToAdminLogin()">
                    <div class="accueil-component-icon">
                        <img src="./images/directeur.png" class="img-fluid">
                    </div>
                    <div class="accueil-component-title">
                        <p >الفضاء الخاص بالمديرية</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="accueil-footer">
        <div class="row">
            <div class="col-md-6 text-md-start">
                <b>Version 1.0</b>
            </div>
            <div class="col-md-6 text-md-end">
                <strong>Copyright © 2024 </strong>
            </div>
        </div>
    </div>

    <script>
        function redirectToLogin() {
            window.location.href = 'login.php';
        }

        function redirectToAdminLogin() {
            window.location.href = 'loginAdmin.php';
        }
    </script>
</body>
</html>
