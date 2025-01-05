<?php

use function PHPSTORM_META\type;

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
if (!isset($data->otp)) {
	exit('Vui lòng nhập mã OTP');
}

$email = trim($data->email);
$otp = trim($data->otp);

//Kiểm tra rỗng
if (empty($email)) {
	exit('Vui lòng nhập email mà bạn đã đăng ký để lấy lại mật khẩu');
}
if (empty($otp)) {
	exit('Vui lòng nhập mã OTP');
}

// Check sự hợp lệ
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	exit('Email không hợp lệ!');
}
if (!is_numeric($otp)){
    exit('Mã OTP không đúng định dạng');
}

$currentTime = time();
// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT user_id FROM user WHERE email = ? AND otp = ? AND expiredOtpTime > FROM_UNIXTIME(?)')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('sii', $email,$otp,$currentTime);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.
	if ($stmt->num_rows > 0) {
        http_response_code(204);
	} else {
		// TODO
        http_response_code(404);
		echo "OTP không đúng hoặc đã hết hạn";
	}
	$stmt->close();
} else {
	// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
    http_response_code(500);
	echo 'BE: Không thể thực hiện lệnh prepare statement!';
}

$con->close();
