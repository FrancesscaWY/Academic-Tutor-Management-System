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

if($first_tno==$second_tno||$first_tno==$third_tno||$second_tno==$third_tno){
    echo '导师选择重复';
    exit();
}
if($first_tno==0||$second_tno==0||$third_tno==0){
    echo '导师选择不能为空';
    exit();
}
//判断选择导师是否存在数据库中

$tno[0]=$first_tno;
$tno[1]=$second_tno;
$tno[2]=$third_tno;
for($i=0;$i<3;$i++){
    $sql = "SELECT TNO FROM TUTORS WHERE TNO=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $tno[$i]);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        echo '第'.$i.'志愿导师编号不存在,请重新提交申请。';
         exit();
    }
    $stmt->close();
}

//date_default_timezone_set('China/Beijing');
$insert_time=date('Y-m-d H:i:s');//插入时间
echo $insert_time;
// 准备SQL语句
$stmt = $conn->prepare("INSERT INTO S_CHOICE_T(SNO, SNAME, SDEPT,FRIST_TNO, SECOND_TNO, THIRD_TNO,APP_DATE) VALUES (?,?, ?, ?,?, ?, ?)");

// 绑定参数
$stmt->bind_param("sssiiis", $sno, $sname,$sdept, $first_tno, $second_tno, $third_tno,$insert_time);

// 执行SQL语句
if ($stmt->execute()) {
    echo 'Insert data successfully';
} else {
    echo 'Insert data failed: ' . $stmt->error;
}

// 关闭数据库连接
$stmt->close();
$conn->close();
echo '3秒后返回上一页面';
?>
<script>
    console.log('store_student_choice.php');
    //3秒后跳转
    setTimeout(function(){
        window.location.href='student__page.php';
    },3000);
</script>