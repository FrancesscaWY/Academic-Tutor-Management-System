<?php
$pwd = file_get_contents('D:/PHP/file/S_T_ADMIN_SYS/src/pw.txt');
$db_host = 'localhost';
$db_user = 'root';
$db_password = $pwd;
$db_name = 'Academic_Tutor_Management_System';
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die('Database connection error');

$request_id = intval($_POST['request_id']);
$action = $_POST['action'];

// 根据导师的操作，更新请求状态并删除学生与导师的关联
if ($action == 'approve') {
    // 获取退选请求的详细信息
    $sql_request = "SELECT student_no, tutor_no FROM CANCELLATION_REQUESTS WHERE request_id = $request_id";
    $result_request = mysqli_query($conn, $sql_request);
    $request_info = mysqli_fetch_assoc($result_request);

    if ($request_info) {
        $student_no = $request_info['student_no'];
        $tutor_no = $request_info['tutor_no'];

        // 删除 T_CHOICE_S 表中的对应元组
        $sql_delete = "DELETE FROM T_CHOICE_S WHERE SNO = '$student_no' AND TNO = '$tutor_no'";
        if (mysqli_query($conn, $sql_delete)) {
            // 更新退选请求状态为已同意
            $sql_update_request = "UPDATE CANCELLATION_REQUESTS SET request_status = 'approved' WHERE request_id = $request_id";
            mysqli_query($conn, $sql_update_request);
            echo "退选请求已同意";
        } else {
            echo "删除导师选择失败: " . mysqli_error($conn);
        }
    } else {
        echo "找不到退选请求";
    }
} elseif ($action == 'reject') {
    // 更新退选请求状态为已拒绝
    $sql_update_request = "UPDATE CANCELLATION_REQUESTS SET request_status = 'rejected' WHERE request_id = $request_id";
    if (mysqli_query($conn, $sql_update_request)) {
        echo "退选请求已拒绝";
    } else {
        echo "更新请求状态失败: " . mysqli_error($conn);
    }
} else {
    echo "无效的操作";
}

mysqli_close($conn);

