<?php
$pwd = file_get_contents('./src/pw.txt');
$db_host = 'localhost';
$db_user = 'root';
$db_name = 'Academic_Tutor_Management_System';
$conn = mysqli_connect($db_host, $db_user, $pwd, $db_name) or die('Database connection error');
echo 'Connected successfully<br>';
//表单登录验证
$account = $_POST['account'];
$password = $_POST['password'];
$user_type = $_POST['user_type'];
//$sql="SELECT * FROM STD_ACCOUNT WHERE STD_ACC = ? AND STD_PD = ?";
//$stmt_prepare=mysqli_prepare($conn,$sql);//预处理
//mysqli_stmt_bind_param($stmt_prepare,'ss',$account,$password);//绑定参数
//mysqli_stmt_execute($stmt_prepare);//执行
//mysqli_stmt_store_result($stmt_prepare);//存储结果d
//mysqli_stmt_bind_result($stmt_prepare,$account,$username,$password);//绑定结果
//mysqli_stmt_fetch($stmt_prepare);//获取结果
//if(mysqli_stmt_num_rows($stmt_prepare)>0){//如果查询到数据
//    $status=1;
//}else{
//    $status=0;
//}
//echo $status;
//如果登录成功，判断用户类型，跳转到不同页面
//echo $user_type;
if ($user_type == 'student') {
    $sql = "SELECT * FROM STD_ACCOUNT WHERE STD_ACC = ? AND STD_PD = ?";
    $stmt_prepare = mysqli_prepare($conn, $sql);//预处理
    mysqli_stmt_bind_param($stmt_prepare, 'ss', $account, $password);//绑定参数
    mysqli_stmt_execute($stmt_prepare);//执行
    mysqli_stmt_store_result($stmt_prepare);//存储结果d
    mysqli_stmt_bind_result($stmt_prepare, $account, $username, $password);//绑定结果
    mysqli_stmt_fetch($stmt_prepare);//获取结果
    if (mysqli_stmt_num_rows($stmt_prepare) > 0) {//如果查询到数据
        $status = 1;
    } else {
        $status = 0;
    }
    echo $status;
    if ($status == 1) {
        setcookie('account', $account, time() + 3600, '/');
        header("refresh:3;url=../student_page.php");//跳转到学生页面
        echo '登录成功，3秒后跳转到学生页面';
    }
}
if ($user_type == 'tutor') {
    $sql = "SELECT * FROM T_ACCOUNT WHERE T_ACC = ? AND T_PWD = ?";
    $stmt_prepare = mysqli_prepare($conn, $sql);//预处理
    mysqli_stmt_bind_param($stmt_prepare, 'ss', $account, $password);//绑定参数
    mysqli_stmt_execute($stmt_prepare);//执行
    mysqli_stmt_store_result($stmt_prepare);//存储结果d
    mysqli_stmt_bind_result($stmt_prepare, $account, $username, $password);//绑定结果
    mysqli_stmt_fetch($stmt_prepare);//获取结果
    if (mysqli_stmt_num_rows($stmt_prepare) > 0) {//如果查询到数据
        $status = 1;
    } else {
        $status = 0;
    }
    echo $status;
    if ($status == 1) {
        setcookie('account', $account, time() + 3600, '/');
        header("refresh:3;url=../tutors_page.php");//跳转到教师页面
        echo '登录成功，3秒后跳转到教师页面';
    }
}
mysqli_close($conn);
?>