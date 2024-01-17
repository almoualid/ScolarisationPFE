<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
            100% { transform: translateX(0); }
        }

        h2 {
            animation: shake 1s ease-in-out infinite;
        }

        .logo {
            
            max-width: 100%;
            height: 300px;
        }

        .button-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <img class="logo" src="./Men_2021-removebg.png" alt="">
    <h2>
    مرحبا بكم في مسك أرشيف الشهادات المدرسية
    </h2>
    
    <div class="button-container">
        
        <a href="login.php" class="btn btn-primary">خاص بالمؤسسات</a>
        <a href="loginAdmin.php" class="btn btn-success">خاص بالمديرية</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
