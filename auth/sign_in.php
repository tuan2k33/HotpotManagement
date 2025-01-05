<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="sign_in.css">
        <title>Sign in</title>
    </head>
    <?php 
        include "db/db_connect.php";
        // validation
        $email = "";
        $name = "";
        $password = "";
        $re_password = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $name = $_POST["username"];
            $password = $_POST["password"];
            $re_password =  $_POST["pass_again"];
        }
        function isValidEmail($email){
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                return "Invalid email!";
            } 
            else {
                return "Valid email!";
            } 
        }
        function containsSpecialCharacter($str) {
            // Biểu thức chính quy kiểm tra xem chuỗi có chứa ký tự đặc biệt hay không
            // Ký tự đặc biệt ở đây là bất kỳ ký tự không phải chữ cái, số hoặc dấu cách
            return preg_match('/[^\w\s]/', $str);
        }
        function isName($str) {
            if (!containsSpecialCharacter($str)){
                return TRUE;
            }
            else return FALSE;
            
        }
        function isValidName($name){
            if (strlen($name)<8 ){
                return "Tên tài khoản cần có ít nhất 8 ký tự!";
            }
            else if (strlen($name)>25){
                return "Tên tài khoản không được vượt quá 25 ký tự!";
            }
            else if (!isName($name)) {
                return "Tên tài khoản chứa ký tự đặc biệt!";
            }
            else return "Valid name!";
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
        function ValidEmail($email){
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                return FALSE;
            } 
            else {
                return TRUE;
            } 
        }
        function ValidName($name){
            if ((strlen($name)<8 || strlen($name)>25) || !isName($name)){
                return FALSE;
            }
            else return TRUE;
        }
        function ValidPass($pass){
            if (strlen($pass)<8 || strlen($pass)>25 || !isPass($pass)){
                return FALSE;
            }
            else return TRUE;
        }
        
        if (ValidEmail($email) && ValidName($name) && ValidPass($password) && ValidPass($re_password) && ($password == $re_password)) {
            //Cập nhật CSDL
            $id = "";
            $sql = "SELECT * FROM user
                    WHERE '$name' = username OR '$email' = email" ;
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) == 0){
                $mysql = " INSERT INTO user (id , email , `username` , `password`, `level`) 
                VALUES ('$id', '$email', '$name', '$password', 1)
                ";
                mysqli_query($con, $mysql);
                header("Location: index.php");
            }
            
            
            
        }
        else {
            header("Location: ");
        }
        // end validation 
    ?>
    <body>
        <div class = "logo">
            <img src="HotPot.png" alt="HotPot">
        </div>
        <form method = "post" class = "sign_up">
            <h1>Đăng ký</h1>
            <p id="mail">Email</p>
            <label for="email"><img src="mail.png" alt="email"></label>
            <input type="text" value="<?php echo $email;?>" id="email" name="email">
            <p style="height: 3%"><?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (ValidEmail($_POST["email"])) {
                        $sql = "SELECT * FROM user
                                WHERE '$email' = email";
                        $result = mysqli_query($con, $sql);
                        if (mysqli_num_rows($result) == 0){
                            echo isValidEmail($_POST["email"]); 
                        }
                        else {
                            echo "Email này đã được đăng ký!";
                        }
                    }
                    else echo isValidEmail($_POST["email"]);
                }
                
            ?></p>
            <p id="name">Tên tài khoản</p>
            <label for="username"><img src="login 1.png" alt="username"></label>
            <input type="text" value="<?php echo $name;?>" id="username" name="username">
            <p style="height: 3%"><?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $sql = "SELECT * FROM user
                            WHERE '$name' = username";
                    $result = mysqli_query($con, $sql);
                    if (mysqli_num_rows($result) == 0){
                        echo isValidName($_POST["username"]); 
                    }
                    else echo "Tên tài khoản này đã được đăng ký";
                }
            ?></p>
            <p id="pass">Mật khẩu</p>
            <label for="password"><img src="password 1.png" alt="password"></label>
            <input type="password" value="<?php echo $password;?>" id="password" name="password">
            <p style="height: 3%"><?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST") echo isValidPass($_POST["password"]); 
            ?></p>
            <p id="passagain">Nhập lại mật khẩu</p>
            <label for="password"><img src="forgot 1.png" alt="password"></label>
            <input type="password" value="<?php echo $re_password;?>" id="pass_again" name="pass_again">
            <p style="height: 3%"><?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST") 
                {
                    if ($_POST["pass_again"] !== $_POST["password"]) echo "Mật khẩu bạn nhập lại không đúng";
                    else {
                        echo "";
                    }
                }
                
            ?></p>
            <br>
            <button><a href= "index.php">Quay lại</a></button>
            <input type="submit"  value="Xác nhận">
        </div>
    </body>
</html>