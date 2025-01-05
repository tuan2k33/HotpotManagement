<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="forgot_pass2.css">
        <title>Forgot password</title>
    </head>
    <?php 
        include "db/db_connect.php";
        // validation
        $password = "";
        $re_password = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $password = $_POST["password"];
            $re_password =  $_POST["pass_again"];
        }
        function isPass($str) {
            return preg_match('/^[a-zA-Z0-9\s]+$/', $str);
        }
        function isValidPass($pass){
            if (strlen($pass)<8 ){
                return "Mật khẩu cần có ít nhất 8 ký tự!";
            }
            else if (strlen($pass)>25){
                return "Mật khẩu không được vượt quá 25 ký tự!";
            }
            else if (!isPass($pass)){
                return "Mật khẩu của bạn chứa ký tự không hợp lệ";
            }
            else return "Valid password!";
        }
        function ValidPass($pass){
            if (strlen($pass)<8 || strlen($pass)>25 || !isPass($pass)){
                return FALSE;
            }
            else return TRUE;
        }
        if ($password == $re_password && ValidPass($password)){

            session_start();
            $name = $_SESSION["name_forgot"];
            $sql1 = "SELECT * FROM user
            WHERE '$name' = username";
            $result =  mysqli_query($con, $sql1);
            $row = mysqli_fetch_array($result);
            if ($row['password'] !== $password){
                $sql = "UPDATE user
                        SET `password` = '$password'
                        WHERE '$name' = username";
                mysqli_query($con, $sql);
                header("Location: index.php");
            }
            
        }
        

        
    ?>
    <body>
        <div class = "logo">
            <img src="HotPot.png" alt="HotPot">
        </div>
        <form class = "forgot_2" method = "post">
            <h1>Quên mật khẩu</h1>
            
            <p id="nothing"></p>
            
            <p id="nothing"></p>
            <p id="pass">Mật khẩu</p>
            <label for="password"><img src="password 1.png" alt="password"></label>
            <input type="password" value="<?= $password?>" id="password" name="password">
            <p style="height: 3%"><?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST") echo isValidPass($_POST["password"]); 
            ?></p>
            <p id="nothing"></p>
            <p id="passagain">Nhập lại mật khẩu</p>
            <label for="password"><img src="forgot 1.png" alt="password"></label>
            <input type="password" value="<?= $re_password?>" id="pass_again" name="pass_again">
            <p id="nothing"></p>
            <p style="height: 3%"><?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST") 
                {
                    if ($_POST["pass_again"] !== $_POST["password"]) echo "Mật khẩu bạn nhập lại không đúng";
                    else if ($password == $re_password && ValidPass($password)){
                        if ($row['password'] == $password) {
                            echo "Bạn đã nhập lại mật khẩu cũ, vui lòng nhập lại hoặc về trang chủ!";
                        }
                    }
                }
                
            ?></p>
            <button><a href="forgot_pass1.php">Quay lại</a></button>
            <input type="submit" value="Xác nhận">
        </div>
    </body>
</html>