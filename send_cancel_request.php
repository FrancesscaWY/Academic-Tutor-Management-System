<?php
$pwd = file_get_contents('D:/PHP/file/S_T_ADMIN_SYS/src/pw.txt');
$db_host = 'localhost';
$db_user = 'root';
$db_password = $pwd;
$db_name = 'Academic_Tutor_Management_System';
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die('Database connection error');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tutor_no = $_POST['tutor_no'];
    $student_no = $_POST['student_no'];
    $request_message = $_POST['request_message'];

    // 获取当前学生和导师的姓名（假设这两个变量是可用的）
    $student_name = $_POST['student_name']; // 从cookie获取学生姓名
    $tutor_name = getTutorName($tutor_no); // 从数据库获取导师姓名的自定义函数

    $sql = "INSERT INTO CANCELLATION_REQUESTS (student_no, tutor_no, sname, tname, request_message, request_date, request_status)
            VALUES ('$student_no', '$tutor_no', '$student_name', '$tutor_name', '$request_message', NOW(), 'pending')";

    if (mysqli_query($conn, $sql)) {
        echo "退选请求已成功提交.";
    } else {
        echo "错误: " . mysqli_error($conn);
    }
}

mysqli_close($conn);

// 获取导师姓名的函数
function getTutorName($tutor_no) {
    global $conn;
    $query = "SELECT TNAME FROM TUTORS WHERE TNO = '$tutor_no'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['TNAME'] ?? '未知';
}
?>
