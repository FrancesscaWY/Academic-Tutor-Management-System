<script>
    console.log('begin');
</script>
<?php
// 从文件中读取数据库密码
$pwd = file_get_contents('D:/PHP/file/S_T_ADMIN_SYS/src/pw.txt');

// 数据库连接参数
$db_host = 'localhost';
$db_user = 'root';
$db_password = $pwd;
$db_name = 'Academic_Tutor_Management_System';

// 创建数据库连接
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die('Database connection error');

// 获取学生选课信息
$sno = $_POST['sno'];
$sname = $_POST['sname'];
$sdept= $_POST['sdept'];
$first_tno = $_POST['first_tno'];
$second_tno = $_POST['second_tno'];
$third_tno = $_POST['third_tno'];
echo $sno.$sname.$first_tno.$second_tno.$third_tno;

// 准备SQL语句
$stmt = $conn->prepare("INSERT INTO S_CHOICE_T(SNO, SNAME, SDEPT,FRIST_TNO, SECOND_TNO, THIRD_TNO) VALUES (?,?, ?, ?, ?, ?)");

// 绑定参数
$stmt->bind_param("sssiii", $sno, $sname,$sdept, $first_tno, $second_tno, $third_tno);

// 执行SQL语句
if ($stmt->execute()) {
    echo 'Insert data successfully';
} else {
    echo 'Insert data failed: ' . $stmt->error;
}

// 关闭数据库连接
$stmt->close();
$conn->close();
?>
<script>
    console.log('store_student_choice.php');
</script>