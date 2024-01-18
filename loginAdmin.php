<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>صفحة الإدارة</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .card {
            
            width: 50%;
            margin: auto;
            margin-top: 2%;
        }

        .image-container {
            text-align: center;
            margin-bottom: 1.5rem; 
        }

        .img-fluid {
            width: 395px;
            height: 90px;

        }
    </style>
</head>
<body>
    <div class="image-container">
        <img src="./images/LogoMenAr.png" alt="Ministère de l'Éducation Nationale" class="img-fluid">
    </div>

    <div class="card text-right">
        <div class="card-body">
            <h2 class="card-title text-center">تسجيل الدخول إلى صفحة المديرية</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="user" class="col-form-label">اسم المستخدم:</label>
                    <input type="text" class="form-control" name="user" >
                </div>
                <div class="form-group">
                    <label for="motDePasse" class="col-form-label">كلمة المرور:</label>
                    <input type="password" class="form-control" name="mdp">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">تسجيل الدخول</button>
                </div>
            </form>
        </div>
    </div>
