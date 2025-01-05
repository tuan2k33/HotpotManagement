<?php
include('db_connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/bootstrap.css" rel="stylesheet" >
    <link href="style/custom-styles.css" rel="stylesheet" />
    <title>RESERVATION HOTPOT RESTAURANT</title>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav">
                    <li>
                        <a  href="index.php"><i class="fa fa-home"></i> Trang chủ </a>
                    </li>    
				</ul>
            </div>
        </nav>
        <div id="page-wrapper" >
            <div id="page-inner">
			 <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            RESERVATION <small></small>
                        </h1>
                    </div>
                </div> 
                                
            <div class="row">
                <div class="col-md-5 col-sm-5">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Thông tin cá nhân
                        </div>
                        <div class="panel-body">
						<form name="form" method="post">
							  <div class="form-group">
                                            <label>Họ và tên*</label>
                                            <input name="fullname" class="form-control" required>        
                               </div>
                               	<div class="form-group">
                                            <label>Giới tính</label>
                                            <select name="sex" class="form-control"required>
												<option value selected ></option>
                                                <option value="male">Nam</option>
                                                <option value="female">Nữ</option>  
                                            </select>    
                               </div>
							   <div class="form-group">
                                            <label>Email</label>
                                            <input name="email" type="email" class="form-control" required>
                               </div>
								<div class="form-group">
                                            <label>Số điện thoại</label>
                                            <input name="phone" type ="text" class="form-control" required>
                               </div>
                        </div>
                    </div>
                </div>
                  
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Thông tin đặt bàn
                        </div>
                        <div class="panel-body">
								<div class="form-group">
                                            <label for = "amount">Số lượng khách hàng*</label>
                                            <input name="amount" type="text"  class="form-control" id="amount" placeholder="0" min="0"> 
                                </div>
							 
							  <div class="form-group">
                                            <label>địa điểm chi nhánh* </label>
                                            <select name="location" class="form-control"required>
												<option value selected ></option>
                                                <option value="location1">Chi nhánh 1</option>
                                                <option value="location2">Chi nhánh 2</option>
												<option value="location3">Chi nhánh 3</option>
                                            </select>
                              </div>
                              <div class="form-group">
                                            <label>Giờ đặt bàn* </label>
                                            <input name="time" type ="time" class="form-control">
                               </div>
							   <div class="form-group">
                                            <label>Ngày đặt bàn* </label>
                                            <input name="date" type ="date" class="form-control">
                               </div>

                       </div>
                        
                    </div>
                </div>
				
				
                <div class="col-md-12 col-sm-12">
                    <div class="well">
                        <h3>XÁC THỰC</h3>
                        <p>MÃ: <?php $Random_code=rand(); echo$Random_code; ?> </p><br />
						<p>NHẬP MÃ<br /></p>
							<input  type="text" name="code1" title="random code" />
							<input type="hidden" name="code" value="<?php echo $Random_code; ?>" />
						<input type="submit" name="submit" class="btn btn-primary">
						<?php
							if(isset($_POST['submit']))
							{
							$code1=$_POST['code1'];
							$code=$_POST['code']; 
							if($code1!="$code")
							{
							$msg="Sai mã !";
                                echo "<script type='text/javascript'> alert('Nhập sai mã !')</script>";
							}
							else
							{
                            $name =$_POST['fullname'];
                            $sex =$_POST['sex'];
                            $email =$_POST['email'];
                            $phone =$_POST['phone'];
                            $amount = $_POST['amount'];
                            $location =$_POST['location'];
                            $time =$_POST['time'];
                            $date = $_POST['date'];
                            $query = "INSERT INTO RESERVATION (fname, sex, phonenumber, email, amount, location, time, date) VALUES ('$name', '$sex', '$phone', '$email', $amount, '$location', '$time', '$date')";
                                // Execute the query
                            $result = mysqli_query($con, $query);

                                // Check for success
                            if ($result) {
                                    echo "<script type='text/javascript'> alert('Đơn đặt bàn của bạn đã được gửi đi !')</script>";
                            } else {
                                    echo "<script type='text/javascript'> alert('Lỗi dữ liệu !')</script>";
                                }
                                // Close the database connection
                            mysqli_close($con);
							$msg="Nhập mã đúng !";
							}
							}
							?>
						</form>		
                    </div>
                </div>
            </div>    
                </div>
					</div>
            </div>
        </div>
        <img src="img/logo_hotpot.png" alt="hotpot's logo" id="logo">
</body>
</html>