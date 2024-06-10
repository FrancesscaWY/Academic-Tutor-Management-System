<?php
$pwd = file_get_contents('./src/pw.txt');
$db_host = 'localhost';
$db_user = 'root';
$db_name = 'Academic_Tutor_Management_System';
$conn = mysqli_connect($db_host, $db_user, $pwd, $db_name) or die('Database connection error');
//echo 'Connected successfully<br>';
//表单登录验证
$account = $_POST['account'];
$password = $_POST['password'];
$user_type = $_POST['user_type'];
$copy_account = $_POST['account'];
//$account后面的被处理函数处理过后值会改变，所以要在这里保存一下，以便后面存入cookie时使用使用

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
    //flag
    $status = 1;
    if ($status == 1) {
        setcookie("copy_account", $copy_account, time() + (86400 * 30), "/"); // 86400 = 1 day
        echo "Cookie 'copy_account' set with value: $copy_account";
        header("refresh:3;url=../student__page.php");//跳转到学生页面
        echo "账户为" . $account;
        echo '登录成功，3秒后跳转到学生页面';
    } else {
        echo '登录失败';
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

    if ($status == 1) {
         setcookie('copy_account', $copy_account, time() + 3600, '/');//设置cookie
        //如何读取整个account中的值，而不是只有一个数字
        header("refresh:3;url=../tutor__.php");//跳转到教师页面
        echo '登录成功，3秒后跳转到教师页面';
    } else {
        echo '登录失败';
    }
}

echo $_COOKIE['copy_account'];
mysqli_close($conn);
?>