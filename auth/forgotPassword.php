<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Đường dẫn tới autoload.php của PHPMailer

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once("../../config/Database.php");

$json = file_get_contents("php://input"); //Không dùng $_POST được vì nó không nhận được chuỗi JSON
$data = json_decode($json);

//Kiểm tra sự tồn tại
if (!isset($data->email)) {
	exit('Vui lòng nhập email mà bạn đã đăng ký để lấy lại mật khẩu');
}

$email = trim($data->email);

//Kiểm tra rỗng
if (empty($email)) {
	exit('Vui lòng nhập email mà bạn đã đăng ký để lấy lại mật khẩu');
}

// Check sự hợp lệ

// Email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	exit('Email không hợp lệ!');
}


// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT user_id FROM user WHERE email = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$stmt->store_result();
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
				$mail->Username   = 'viettuandn19@gmail.com'; // Thay bằng email SMTP của bạn
				$mail->Password   = 'ekel qozt ysam nkey';   // Thay bằng mật khẩu SMTP của bạn
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
				$mail->Port       = 587; // Cổng SMTP của bạn

				$mail->setFrom('viettuandn19@gmail.com', 'Tứ Quý Plant Store');
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
		echo 'Email này chưa được đăng ký';
	}
	$stmt->close();
} else {
	// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
	echo 'Could not prepare statement!';
}

$con->close();
