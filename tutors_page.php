<?php
$pwd=file_get_contents('D:/PHP/file/S_T_ADMIN_SYS/src/pw.txt');
$db_host = 'localhost';
$db_user = 'root';
$db_pd= $pwd;
$db_name='Academic_Tutor_Management_System';
$conn=mysqli_connect($db_host,$db_user,$db_pd,$db_name) or die('Connected successfully');
echo"Connected successfully";

if(isset($_COOKIE['account'])) {
    $account = htmlspecialchars($_COOKIE['account']);
    echo "Welcome back, " . $account . "!";
} else {
    echo "Welcome, guest!";
}
echo $_COOKIE['copy_account'];
//为什么存入的COOKie只有一个数字，而不是账号
$sql="SELECT SNO,SNAME,SDEPT FROM S_CHOICE_T WHERE FRIST_TNO=".$_COOKIE['copy_account'];
$result=mysqli_query($conn,$sql);
//将学生的选择以表格形式输出
echo "<h2>第一选择为您的学生</h2><table border='1'>
<tr>
<th>学号</th>
<th>姓名</th>
<th>专业</th>
</tr>";
while($row=mysqli_fetch_assoc($result)){
    echo "<tr>";
    echo "<td>".$row['SNO']."</td>";
    echo "<td>".$row['SNAME']."</td>";
    echo "<td>".$row['SDEPT']."</td>";
    echo "</tr>";
}
echo "</table>";
$sql0="SELECT SNO,SNAME,SDEPT FROM S_CHOICE_T WHERE SECOND_TNO=".$_COOKIE['copy_account'];
$result0=mysqli_query($conn,$sql0);
//将学生的选择以表格形式输出
echo "<h2>第二选择为您的学生</h2><table border='1'>
<tr>
<th>学号</th>
<th>姓名</th>
<th>专业</th>
</tr>";
while($row=mysqli_fetch_assoc($result0)){
    echo "<tr>";
    echo "<td>".$row['SNO']."</td>";
    echo "<td>".$row['SNAME']."</td>";
    echo "<td>".$row['SDEPT']."</td>";
    echo "</tr>";
}
echo "</table>";
$sql1="SELECT SNO,SNAME,SDEPT FROM S_CHOICE_T WHERE THIRD_TNO=".$_COOKIE['copy_account'];
$result1=mysqli_query($conn,$sql1);
//将学生的选择以表格形式输出
echo "<h2>第三选择为您的学生</h2><table border='1'>
<tr>
<th>学号</th>
<th>姓名</th>
<th>专业</th>
</tr>";
while($row=mysqli_fetch_assoc($result1)){
    echo "<tr>";
    echo "<td>".$row['SNO']."</td>";
    echo "<td>".$row['SNAME']."</td>";
    echo "<td>".$row['SDEPT']."</td>";
    echo "</tr>";
}
echo "</table>";
if($result){
    echo "查询成功";
}else{
    echo "查询失败";
}
//if(mysqli_num_rows($result)>0){
//    while($row=mysqli_fetch_assoc($result)){
//        echo "SNO: ".$row['SNO']." SNAME: ".$row['SNAME']." SDEPT: ".$row['SDEPT']."<br>";
//    }
//}else{
//    echo "0 results";
//}

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
