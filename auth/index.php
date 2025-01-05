<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="login.css">
        <title>Login</title>
    </head>
    <?php 
        include "db/db_connect.php";
        $tableName = "user";
        $sql1 = "SHOW TABLES LIKE '$tableName'";
        $result = $con->query($sql1);

        // Kiểm tra và tạo bảng
        if ($result->num_rows > 0) {
            
        } else {
            $sql = " CREATE TABLE user (
                id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                email varchar(255) UNIQUE NOT NULL,
                `username` varchar(50) UNIQUE NOT NULL,
                `password` varchar(25) NOT NULL,
                `level` enum('1', '2', '3') NOT NULL DEFAULT '1',
                `otp` INT(6),
                expiredOtpTime TIMESTAMP
                
            )";
            if ($con->query($sql)){
                
            }
            else {
                echo "create table failed";
            }
        }
    
        //validation
        $name = "";
        $password = "";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $name = $_POST["username"];
            $password = $_POST["password"];
            
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
        
        function check_account($name, $password){
            if (ValidName($name) && ValidPass($password)) {
                include "db/db_connect.php";
                // Kiem tra tai khoan
                $sql = "SELECT * FROM user WHERE '$name' = username";
                $result = $result = mysqli_query($con, $sql);
                if (mysqli_num_rows($result) == 0) {
                    echo "Tài khoản không tồn tại";
                    return "";
                }
                else {
                    $row = mysqli_fetch_array($result);
                    
                    if ($password === $row['password']){
                        
                        if ($row['level'] == 1) {
                            return "home_customer.php";
                            
                        }
                        else if ($row['level'] == 2){
                            return "home_staff.php";
                            
                        }
                        else {
                            return "home_manager.php";
                        }
                    }
                    else {
                        echo "Tài khoản hoặc mật khẩu không đúng";
                        return "";
                    }
                }
            }
            else echo "Tên hoặc mật khẩu không hợp lệ";
        }
        
    ?>
    <body>
        <div class = "logo">
            <img src="HotPot.png" alt="HotPot">
        </div>
        
        <form class = "login" method = "post">
            <h1>Đăng nhập</h1>
            <p id="name">Tên đăng nhập</p>
            <label for="username"><img src="login 1.png" alt="username"></label>
            <input type="text" value="<?= $name;?>" id="username" name="username">
            <p style="height: 3%"><?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    echo isValidName($_POST["username"]); 
                    session_start();
                    $_SESSION['name'] = $_POST["username"];
                }
            ?></p>
            <p id="pass">Mật khẩu</p>
            <label for="password"><img src="password 1.png" alt="password"></label>
            <input type="password" value="<?= $password;?>" id="password" name="password">
            <p style="height: 3%"><?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST") header ("Location: ".check_account($_POST['username'], $_POST['password'])); 
            ?></p>
            <p id="nothing"></p>
            <input type="submit" value = "Đăng nhập">
            
            <p id="nothing"></p>
            <a href="sign_in.php">Đăng ký</a>
            <a href="forgot_pass.php">Quên mật khẩu</a>
    </form>
    </body>
</html>