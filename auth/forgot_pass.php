<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="forgot_pass.css">
        <title>Forgot password</title>
    </head>
    <?php
        include "db/db_connect.php";
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        require 'vendor/autoload.php'; // Đường dẫn tới autoload.php của PHPMailer
        
        
        
        $email = "";
        $name = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $name = $_POST["username"];
        }
        
        function isValidEmail($email){
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                return "Invalid email!";
            } 
            else return "";
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
            else return "";
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
        


        // We need to check if the account with that username exists.
        if ( ValidEmail($email)) {
            // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
            $sql = "SELECT * FROM user WHERE email = '$email'";
            $stmt = mysqli_query($con, $sql);
            // Store the result so we can check if the account exists in the database.
            if ($stmt->num_rows > 0) {
                // Username already exists

                $otp = rand(100000, 999999);

                // Lưu mã OTP vào cơ sở dữ liệu
                $expiredTime = time() + 60 * 3;
                $sql_update = "UPDATE user SET otp = '$otp', expiredOtpTime = FROM_UNIXTIME($expiredTime) WHERE email = '$email'";
                if ($con->query($sql_update) === TRUE) {
                    // Gửi mã OTP đến email của người dùng
                    $mail = new PHPMailer(true);

                    try {
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com'; // Thay bằng thông tin SMTP của bạn
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'nguyen.vu1692003@hcmut.edu.vn'; // Thay bằng email SMTP của bạn
				        $mail->Password   = 'spez hmta wypi llvk';   // Thay bằng mật khẩu SMTP của bạn
				        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
				        $mail->Port       = 587; // Cổng SMTP của bạn

				        $mail->setFrom('nguyen.vu1692003@hcmut.edu.vn', 'Hotpot');
				        $mail->addAddress($email);
                        $mail->addAddress($email);

                        $mail->CharSet = 'UTF-8';
                        $mail->Encoding = 'base64'; // Hoặc 'quoted-printable'
                        $mail->isHTML(true);
                        $mail->Subject = 'Mã OTP để đặt lại mật khẩu';
                        $mail->Body    = 'Mã OTP của bạn là: ' . $otp;
                        $mail->send();
                        http_response_code(200);
                        
                    } catch (Exception $e) {
                        http_response_code(500);
                        echo "Gửi email thất bại: {$mail->ErrorInfo}";
                    }
                } else {
                    http_response_code(500);
                    echo "Lỗi khi cập nhật mã OTP: " . $con->error;
                }
            } else {
                // TODO
                http_response_code(404);
                echo 'Email'. $email. 'chưa được đăng ký';
            }
            $stmt->close();
        } else {
            // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
           
        }

        

        
        
        
        
    ?>
    <body>
        <div class = "logo">
            <img src="HotPot.png" alt="HotPot">
        </div>
        <form class = "forgot_1" method = 'post'>
            <h1>Quên mật khẩu</h1>
            <p id="mail">Email</p>
            <label for="email"><img src="mail.png" alt="email"></label>
            <input type="text" value="<?php echo $email;?>" id="email" name="email">
            <p style="height: 3%"><?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST") echo isValidEmail($_POST["email"]); 
            ?></p>
            <p id="name">Tên tài khoản</p>
            <label for="username"><img src="login 1.png" alt="username"></label>
            <input type="text" value="<?= $name; ?>" id="username" name="username">
            <p style="height: 3%"><?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST") echo isValidName($_POST["username"]); 
            ?></p>
            <p id="nothing" style="margin-left: 25%;">
                <?php
                    if (ValidEmail($email) && ValidName($name)) {
                        // tìm kiếm trong CSDL
                            $sql = "SELECT * FROM user
                                    WHERE '$name' = username AND '$email' = email";
                            $result = mysqli_query($con, $sql);
                            if (mysqli_num_rows($result) == 0){
                                echo "Tên tài khoản hoặc email chưa đã được đăng ký"; 
                            }
                            else {
                                // xử lý
                                session_start();
                                $_SESSION["name_forgot"] = $name;
                                header("Location: forgot_pass1.php");
                            }
            
                            
                    }
                ?>
            </p>
            
            <button><a href="index.php">Quay lại</a></button>
            <input type="submit" value = "Xác nhận">
        </div>
    </body>
</html>
