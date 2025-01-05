


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="forgot_pass1.css">
        <title>Forgot password</title>
    </head>
    <?php 
        include "db/db_connect.php";
        $code = "";
        
    ?>
    <body>
        <div class = "logo">
            <img src="HotPot.png" alt="HotPot">
        </div>
        <form class = "forgot_1" method = "post">
            <h1>Quên mật khẩu</h1>
            <p id="nothing"></p>
            <p id="confirm_code">Mã xác nhận</p>
            <label for="code"><img src="login 1.png" alt="username"></label>
            <input type="text" value="" id="code" name="code">
            <p style="height: 3%;"></p>
            <p style = "margin-left: 35%;">
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST"){
                        $code = $_POST['code'];
                        $sql = "SELECT * FROM user WHERE '$code' = otp";
                            $result = $result = mysqli_query($con, $sql);
                            if (mysqli_num_rows($result) == 0) {
                                echo "Mã OTP không đúng";
                                header("Location: ");
                            }
                            else header("Location: forgot_pass2.php");
                    }
                ?>
            </p>
            <p id="nothing"></p>
            <button><a href="forgot_pass.php">Quay lại</a></button>
            <input type="submit" value="Xác nhận">
            <p id="nothing"></p>
            <a href="#" id="resend">Gửi lại mã</a>
        </form>
    </body>
</html>