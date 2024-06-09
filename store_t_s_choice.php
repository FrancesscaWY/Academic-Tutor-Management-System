<?php
$pwd=file_get_contents('D:/PHP/file/S_T_ADMIN_SYS/src/pw.txt');
$db_host='localhost';
$db_user='root';
$db_password=$pwd;
$db_name='Academic_Tutor_Management_System';
$conn=mysqli_connect($db_host,$db_user,$db_password,$db_name) or die('Database connection error');
echo'Connected successfully<br>';

$sname = $_POST['sname'];
$sno = $_POST['sno'];
$sdept = $_POST['sdept'];
$status = 0;

$sql = "SELECT TNAME, TNO, MAJIOR FROM TUTORS WHERE TNO=?";
$stmt = $conn->prepare($sql);
$tno = $_COOKIE['copy_account'];
$stmt->bind_param('s', $tno);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$tname = $row['TNAME'];
$major = $row['MAJIOR'];

// 插入学生选择信息到 T_CHOICE_S 表
$sql1 = "INSERT INTO T_CHOICE_S (TNO, TNAME, MAJIOR, SNO, SNAME, SDEPT) VALUES (?, ?, ?, ?, ?, ?)";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param('isssss', $tno, $tname, $major, $sno, $sname, $sdept);

if ($stmt1->execute()) {
    echo 'Insert data successfully<br>';
    $status++;

    // 插入成功后，从 S_CHOICE_T 表中删除相应的记录
    $sql_delete = "DELETE FROM S_CHOICE_T WHERE SNO=? AND (FRIST_TNO=? OR SECOND_TNO=? OR THIRD_TNO=?)";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param('ssss', $sno, $tno, $tno, $tno);
    if ($stmt_delete->execute()) {
        echo 'Del ete data from S_CHOICE_T successfully<br>';
    } else {
        echo 'Delete data from S_CHOICE_T failed: ' . $stmt_delete->error;
    }
    $stmt_delete->close();
} else {
    echo 'Insert data failed: ' . $stmt1->error;
}
echo $status;
$stmt1->close();
$conn->close();

// 将状态返回给 tutor_page.php

?>
$stmt->close();
$conn->close();
?>
<html>
<head>
    <title>store_t_s_choice</title>
</head>
<body>
    <h1>store_t_s_choice</h1>
</body>
<script>
    let status=<?php echo $status;?>;
    if(status==1){
        alert('选择成功');
    }
    if(status>1){
        alert('重复选择');
    }
    if(status<1){
        alert('选择失败');
    }
</script>

</html>
