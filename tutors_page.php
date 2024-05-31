<?php
$pwd=file_get_contents('D:/PHP/file/S_T_ADMIN_SYS/src/pw.txt');
$db_host = 'localhost';
$db_user = 'root';
$db_pd= $pwd;
$db_name='Academic_Tutor_Management_System';
$conn=mysqli_connect($db_host,$db_user,$db_pd,$db_name) or die('Connected successfully');
echo"Connected successfully";
//创建视图
//$sql="CREATE VIEW S_C_VIEW IF NOT EXIST AS SELECT SNO,SNAME,FRIST_TNO,SECOND_TNO,THIRD_TNO FROM S_CHOICE_T";
//if(mysqli_query($conn,$sql)){
//    echo 'Create view successfully';
//}else{
//    echo 'Create view failed: '.mysqli_error($conn);
//}
// 将创建的视图显示在页面上
//读取登录页面时候存取的cookie
if(isset($_COOKIE['account'])) {
    $account = htmlspecialchars($_COOKIE['account']);
    echo "Welcome back, " . $account . "!";
} else {
    echo "Welcome, guest!";
}
//从视图中获第一选择是cookie中教师编号的学生信息
$sql1="SELECT * FROM S_C_VIEW WHERE FRIST_TNO=".$_COOKIE['account'];
$sql2="SELECT * FROM S_C_VIEW WHERE SECOND_TNO=".$_COOKIE['account'];
$sql3="SELECT * FROM S_C_VIEW WHERE THIRD_TNO=".$_COOKIE['account'];
$result1=mysqli_query($conn,$sql1);
$result2=mysqli_query($conn,$sql2);
$result3=mysqli_query($conn,$sql3);
echo "<table border='1'>
<tr>
<th>SNO</th>
<th>SNAME</th>
<th>FRIST_TNO</th>
<th>SECOND_TNO</th>
<th>THIRD_TNO</th>
</tr>";
while($row1=mysqli_fetch_assoc($result1)){
    echo "<tr>";
    echo "<td>".$row1['SNO']."</td>";
    echo "<td>".$row1['SNAME']."</td>";
    echo "<td>".$row1['FRIST_TNO']."</td>";
    echo "<td>".$row1['SECOND_TNO']."</td>";
    echo "<td>".$row1['THIRD_TNO']."</td>";
    echo "</tr>";
}
while($row2=mysqli_fetch_assoc($result2)){
    echo "<tr>";
    echo "<td>".$row2['SNO']."</td>";
    echo "<td>".$row2['SNAME']."</td>";
    echo "<td>".$row2['FRIST_TNO']."</td>";
    echo "<td>".$row2['SECOND_TNO']."</td>";
    echo "<td>".$row2['THIRD_TNO']."</td>";
    echo "</tr>";
}
while($row3=mysqli_fetch_assoc($result3)){
    echo "<tr>";
    echo "<td>".$row3['SNO']."</td>";
    echo "<td>".$row3['SNAME']."</td>";
    echo "<td>".$row3['FRIST_TNO']."</td>";
    echo "<td>".$row3['SECOND_TNO']."</td>";
    echo "<td>".$row3['THIRD_TNO']."</td>";
    echo "</tr>";
}
echo "</table>";
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
</head>
<body>


</body>
</html>
