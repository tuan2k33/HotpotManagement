<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="home_staff.css">
        <title>Home-Manager</title>
    </head>
    <body>
        <div class = "menu">
            <h1>Danh mục</h1>
            <img src="Polygon 1.png" alt="Polygon 1">
            <br>
            <img src="🦆 icon _home_.png" alt="bell">
            <button id="home" style="text-decoration: underline;">Trang chủ</button>
            <p></p>
            <img src="bell.png" alt="bell">
            <button id="menu">Đơn gọi món</button>
            <p></p>
            <img src="🦆 icon _book open check_.png" alt="bell">
            <button id="payment">Nhận bàn</button>
            <p></p>
            <img src="🦆 icon _dollar sign_.png" alt="bell">
            <button id="payment">Hóa đơn</button>
            <p></p>
            <img src="🦆 icon _calendar days_.png" alt="bell">
            <button id="response">Lịch làm</button>
            <p></p>
            <img src="🦆 icon _log out_.png" alt="bell">
            <button><a href="index.php">Đăng xuất</button>
        </div>
        <div class = back_ground>
        <h1>Chào mừng nhân viên <span><?php session_start(); echo $_SESSION['name']?></span></h1>
        </div>
        
    </body>
</html>