<?php
$pwd = file_get_contents('D:/PHP/file/S_T_ADMIN_SYS/src/pw.txt');
$db_host = 'localhost';
$db_user = 'root';
$db_password = $pwd;
$db_name = 'Academic_Tutor_Management_System';
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die('Database connection error');

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

//插入学生信息以及时间到T_CHOICE_S表
$insertion_time = date('Y-m-d H:i:s');
//为什么获得的时间有误
//echo $insertion_time;
//// 插入学生选择信息到 T_CHOICE_S 表
$sql1 = "INSERT INTO T_CHOICE_S (TNO, TNAME, MAJIOR, SNO, SNAME, SDEPT,CHOOSE_DATE) VALUES (?,?, ?, ?, ?, ?, ?)";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param('issssss', $tno, $tname, $major, $sno, $sname, $sdept, $insertion_time);

if ($stmt1->execute()) {
//    echo 'Insert data successfully<br>';
    $status++;

    // 插入成功后，从 S_CHOICE_T 表中删除相应的记录
    $sql_delete = "DELETE FROM S_CHOICE_T WHERE SNO=? AND (FRIST_TNO=? OR SECOND_TNO=? OR THIRD_TNO=?)";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param('ssss', $sno, $tno, $tno, $tno);
    $stmt_delete->execute();
//    if () {
//        echo 'Del ete data from S_CHOICE_T successfully<br>';
//    } else {
//        echo 'Delete data from S_CHOICE_T failed: ' . $stmt_delete->error;
//    }
    $stmt_delete->close();
} else {
    echo 'Insert data failed: ' . $stmt1->error;
}
echo $status;
$stmt1->close();
$conn->close();
// 将状态返回给 tutor_page.php

?>