<?php
// 获取数据库连接信息
$pwd = file_get_contents('./src/pw.txt');
$db_host = 'localhost';
$db_user = 'root';
$db_password = $pwd;
$db_name = 'Academic_Tutor_Management_System';
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die('Database connection error');

// 获取导师表中的所有数据
$sql = "SELECT * FROM TUTORS";
$result = mysqli_query($conn, $sql);
echo "<table border='1' id='chose_teacher'>
<tr>
<th>序号</th>
<th>教师编号</th>
<th>姓名</th>
<th>职称</th>
<th>性别</th>
<th>专业</th>
<th>研究方向</th>
</tr>";
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['T_ID'] . "</td>";
    echo "<td>" . $row['TNO'] . "</td>";
    echo "<td>" . $row['TNAME'] . "</td>";
    echo "<td>" . $row['PROFESSIONAL_TITLE'] . "</td>";
    echo "<td>" . $row['TSEX'] . "</td>";
    echo "<td>" . $row['MAJIOR'] . "</td>";
    echo "<td>" . $row['RESEARCH_FIELD'] . "</td>";
    echo "</tr>";
}
echo "</table>";
mysqli_free_result($result); // 释放结果集

// 获取学生信息
$sno = $_COOKIE['copy_account'];
$sql1 = "SELECT SNO, SNAME, SDEPT FROM STUDENTS WHERE SNO = ?";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param('s', $sno);
$stmt1->execute();
$result1 = $stmt1->get_result();
if ($row1 = $result1->fetch_assoc()) {
    $NAME = $row1['SNAME'];
    $DEPT = $row1['SDEPT'];
    $SNO = $row1['SNO'];
} else {
    die('Student not found.');
}
mysqli_free_result($result1); // 释放结果集

// 检查是否提交了导师申请
$sql2 = "SELECT * FROM S_CHOICE_T WHERE SNO = ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param('s', $sno);
$stmt2->execute();
$result2 = $stmt2->get_result();

$application = 0;
$re_choose = 0;
$first_tno = '';
$second_tno = '';
$third_tno = '';
$first_tname = '';
$second_tname = '';
$third_tname = '';
$matched_tno = '';
$matched_tname = '';
$cancel_status='';
if ($row2 = $result2->fetch_assoc()) {
    $application = 1; // 表示申请已提交
    $first_tno = $row2['FRIST_TNO'];
    $second_tno = $row2['SECOND_TNO'];
    $third_tno = $row2['THIRD_TNO'];

    // 获取导师的名字
    $sql_tutors = "SELECT TNO, TNAME FROM TUTORS WHERE TNO IN (?, ?, ?)";
    $stmt_tutors = $conn->prepare($sql_tutors);
    $stmt_tutors->bind_param('sss', $first_tno, $second_tno, $third_tno);
    $stmt_tutors->execute();
    $result_tutors = $stmt_tutors->get_result();
    while ($row_tutor = $result_tutors->fetch_assoc()) {
        if ($row_tutor['TNO'] == $first_tno) {
            $first_tname = $row_tutor['TNAME'];
        } elseif ($row_tutor['TNO'] == $second_tno) {
            $second_tname = $row_tutor['TNAME'];
        } elseif ($row_tutor['TNO'] == $third_tno) {
            $third_tname = $row_tutor['TNAME'];
        }
    }
    mysqli_free_result($result_tutors); // 释放结果集
}
mysqli_free_result($result2); // 释放结果集

// 检查导师是否选择了该学生
$sql3 = "SELECT * FROM T_CHOICE_S WHERE SNO = ?";
$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param('s', $sno);
$stmt3->execute();
$result3 = $stmt3->get_result();
if($row3 = $result3->fetch_assoc()) {
    $re_choose = 1; // 表示导师已选择该学生
    $matched_tno = $row3['TNO'];

    // 获取匹配导师的名字
    $sql_matched_tutor = "SELECT TNAME FROM TUTORS WHERE TNO = ?";
    $stmt_matched_tutor = $conn->prepare($sql_matched_tutor);
    $stmt_matched_tutor->bind_param('s', $matched_tno);
    $stmt_matched_tutor->execute();
    $result_matched_tutor = $stmt_matched_tutor->get_result();
    if ($row_matched_tutor = $result_matched_tutor->fetch_assoc()) {
        $matched_tname = $row_matched_tutor['TNAME'];
    }
    mysqli_free_result($result_matched_tutor); // 释放结果集
}
mysqli_free_result($result3); // 释放结果集
if (!$result3) {
    $re_choose = 0;
}

$sql4="SELECT * FROM CANCELLATION_REQUESTS WHERE STUDENT_NO = ?";
$stmt4 = $conn->prepare($sql4);
$stmt4->bind_param('s', $sno);
$stmt4->execute();
$result4 = $stmt4->get_result();
if($row4=$result4->fetch_assoc()){
    $cancel_status = $row4['REQUEST_STATUS'];
}
mysqli_free_result($result4); // 释放结果集
mysqli_close($conn); // 关闭数据库连接
?>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>学生页面</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .application {
            border: 1px solid black;
            margin: 10px;
            padding: 10px;
        }
    </style>
</head>
<body>
<h1>选择导师</h1>
<form action="store_std_choice.php" method="POST">
    <label for="sno">学号:</label>
    <input type="text" name="sno" id="sno" readonly><br>
    <label for="sname">姓名:</label>
    <input type="text" name="sname" id="sname" readonly><br>
    <label for="sdept">专业:</label>
    <input type="text" name="sdept" id="sdept" readonly><br>
    <label for="first_tno">第一志愿教师编号:</label>
    <input type="text" name="first_tno" id="first_tno"><br>
    <label for="second_tno">第二志愿教师编号:</label>
    <input type="text" name="second_tno" id="second_tno"><br>
    <label for="third_tno">第三志愿教师编号:</label>
    <input type="text" name="third_tno" id="third_tno"><br>
    <input type="submit" value="提交">
</form>
<div>
    <h2>导师申请进度</h2>
    <div class="application" id="app_status"></div>
    <div class="application" id="application_details"></div>
    <div class="application" id="result_status"></div>
    <div class="application" id="review_status"></div>
</div>
<div id="cancel_request_div" style="display: none;">
    <h2>退选申请</h2>
    <form id="cancel_request_form" method="post" action="send_cancel_request.php">
        <input type="hidden" name="tutor_no" value="<?php echo $matched_tno; ?>">
        <input type="hidden" name="student_no" value="<?php echo $sno; ?>">
        <input type="hidden" name="student_name" value="<?php echo$NAME ?>">
        <textarea name="request_message" placeholder="请填写退选原因" required></textarea><br>
        <button type="submit">发送退选请求</button>
    </form>
</div>
<h2>退选进度</h2>
<div id="cancel_status"></div>
</body>
<script>
    // 自动填写学生信息
    document.getElementById('sno').value = "<?php echo $SNO; ?>";
    document.getElementById('sname').value = "<?php echo $NAME; ?>";
    document.getElementById('sdept').value = "<?php echo $DEPT; ?>";

    // 设置申请状态和选择状态
    let application = <?php echo $application; ?>;
    let re_choose = <?php echo $re_choose; ?>;
    let first_tno = "<?php echo $first_tno; ?>";
    let second_tno = "<?php echo $second_tno; ?>";
    let third_tno = "<?php echo $third_tno; ?>";
    let first_tname = "<?php echo $first_tname; ?>";
    let second_tname = "<?php echo $second_tname; ?>";
    let third_tname = "<?php echo $third_tname; ?>";
    let matched_tno = "<?php echo $matched_tno; ?>";
    let matched_tname = "<?php echo $matched_tname; ?>";
    let cancel_status = "<?php echo $cancel_status; ?>";
    console.log(cancel_status);
    // 检查申请状态
    if (application == 0 && re_choose == 0) {
        // 情况1: 学生尚未提交申请
        document.getElementById('app_status').innerHTML = '<h3>您尚未提交导师申请</h3>';
        document.getElementById('review_status').innerHTML = '<h3>请填写申请表并提交。</h3>';

    } else {
        // 情况2: 学生已提交申请
        document.getElementById('app_status').innerHTML = '<h3>您的导师申请已提交</h3>';
        document.getElementById('application_details').innerHTML = `
            <h3>您申请的导师信息：</h3>
            <p>第一志愿导师：编号 - ${first_tno}，姓名 - ${first_tname}</p>
            <p>第二志愿导师：编号 - ${second_tno}，姓名 - ${second_tname}</p>
            <p>第三志愿导师：编号 - ${third_tno}，姓名 - ${third_tname}</p>
        `;
    }

    // 检查导师选择状态
    if (re_choose == 0 && application == 1) {
        // 情况3: 学生已提交申请，但导师尚未选择
        document.getElementById('review_status').innerHTML = '<h3>导师正在查看您的申请，请耐心等待......</h3>';
        document.getElementById('result_status').innerHTML = '<h3>您目前还没有被导师选择。</h3>';
    } else if (re_choose == 1) {
        // 情况4: 学生被导师选择
        document.getElementById('review_status').innerHTML = `
            <h3>导师选择信息：</h3>
            <p>您已被导师选择：</p>
            <p>导师编号 - ${matched_tno}，姓名 - ${matched_tname}</p>
        `;
        document.getElementById('result_status').innerHTML = '<h3>恭喜！您已被导师选择。</h3>';
        document.getElementById('cancel_request_div').style.display = 'block'; // 显示退选表单
    }

    if(cancel_status==='PENDING'){
        document.getElementById('cancel_status').innerHTML = '<h3>您已提交退选申请，请耐心等待导师处理。</h3>';
    }else if(cancel_status==='APPROVED'){
        document.getElementById('cancel_status').innerHTML = '<h3>您的退选申请已被导师批准。</h3>';
    }else if(cancel_status==='REJECTED') {
        document.getElementById('cancel_status').innerHTML = '<h3>您的退选申请已被导师拒绝。</h3>';
    }else if(cancel_status===''){
        document.getElementById('cancel_status').innerHTML = '<h3>您尚未提交退选申请。</h3>';
    }
    // 调试信息
    console.log("application: " + application);
    console.log("re_choose: " + re_choose);

</script>
</html>
