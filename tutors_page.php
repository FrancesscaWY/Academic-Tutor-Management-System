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
echo $_COOKIE['account'];
//为什么存入的COOKie只有一个数字，而不是账号
$sql="SELECT SNO,SNAME,SDEPT FROM S_CHOICE_T WHERE FRIST_TNO=".$_COOKIE['account'];
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
    while($row=mysqli_fetch_assoc($result)){
        echo "SNO: ".$row['SNO']." SNAME: ".$row['SNAME']." SDEPT: ".$row['SDEPT']."<br>";
    }
}else{
    echo "0 results";
}
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
