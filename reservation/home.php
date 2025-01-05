<?php
include('db_connect.php');

// Check if the delete button is clicked
if (isset($_POST['delete_date'], $_POST['delete_time'])) {
    $deleteDate = $_POST['delete_date'];
    $deleteTime = $_POST['delete_time'];

    // Perform the delete operation
    $deleteQuery = "DELETE FROM Reservation WHERE date = '$deleteDate' AND time = '$deleteTime'";
    $deleteResult = mysqli_query($con, $deleteQuery);

}
// Fetch data from the Reservation table
$query = "SELECT * FROM Reservation ORDER BY date, time";
$result = mysqli_query($con, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/style_rec.css" rel="stylesheet" >
    <link href="style/custom-styles.css" rel="stylesheet" />
    <title>TABLE BOOKING</title>
</head>
<body>
    <nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
            <ul class="nav">
                <li>
                    <a  href="reservation.php"><i class="fa fa-home"></i> Quay lại</a>
                 </li>    
			</ul>
        </div>
    </nav>
     <div class = "overlay-container">
    <img src="img/logo_hotpot.png" alt="hotpot's logo" id="logo">
    <hr>
    <?php

    if ($result) {
        // Check if there are rows in the result set
        if (mysqli_num_rows($result) > 0) {
            echo '<table class = "table" border="1">';
            echo '<tr>
                <th>Ngày</th>
                <th>thời gian</th>
                <th>Họ và tên</th>
                <th>Giới tính</th>
                <th>SĐT</th>
                <th>Email</th>
                <th>Số lượng chỗ ngồi</th>
                <th>Chi nhánh </th>
                <th> Xóa </th>
              </tr>';

            // Output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['date'] . '</td>';
                echo '<td>' . $row['time'] . '</td>';
                echo '<td>' . $row['fname'] . '</td>';
                echo '<td>' . $row['sex'] . '</td>';
                echo '<td>' . $row['phonenumber'] . '</td>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td>' . $row['amount'] . '</td>';
                echo '<td>' . $row['location'] . '</td>';
                echo '<td>
                            <form method="post">
                                <input type="hidden" name="delete_date" value="' . $row['date'] . '">
                                <input type="hidden" name="delete_time" value="' . $row['time'] . '">
                                <button type="submit">Delete</button>
                            </form>
                          </td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo 'No data found.';
        }
    } else {
        echo 'Error: ' . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);
    ?>
     </div>
</body>
</html>