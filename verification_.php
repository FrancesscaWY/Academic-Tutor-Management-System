<?php
$pwd=file_get_contents('./src/pw.txt');
$db_host = 'localhost';
$db_user='root';
$db_name='Academic_Tutor_Management_System';
$conn=mysqli_connect($db_host,$db_user,$pwd,$db_name) or die('Database connection error');
echo 'Connected successfully<br>';
//表单登录验证
$account=$_POST['account'];
$password=$_POST['password'];
$sql="SELECT * FROM STUDENTS WHERE SNO = ? AND SNAME = ?";
$stmt_prepare=mysqli_prepare($conn,$sql);//预处理
mysqli_stmt_bind_param($stmt_prepare,'ss',$account,$password);//绑定参数
mysqli_stmt_execute($stmt_prepare);//执行
mysqli_stmt_store_result($stmt_prepare);//存储结果d
mysqli_stmt_bind_result($stmt_prepare,$account,$username,$password);//绑定结果
mysqli_stmt_fetch($stmt_prepare);//获取结果
if(mysqli_stmt_num_rows($stmt_prepare)>0){//如果查询到数据
    $status=1;
}else{
    $status=0;
}
echo $status;
mysqli_close($conn);
?>