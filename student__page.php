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
$cancel_status = '';
$request_time1= NULL;
$request_time2= NULL;
$re_choose_time=NULL;
if ($row2 = $result2->fetch_assoc()) {
    $application = 1; // 表示申请已提交
    $first_tno = $first_tno = $row2['FRIST_TNO'];
    $second_tno = $row2['SECOND_TNO'];
    $third_tno = $row2['THIRD_TNO'];
    $request_time1=$row2['APP_DATE'];
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
if ($row3 = $result3->fetch_assoc()) {
    $re_choose = 1; // 表示导师已选择该学生
    $matched_tno = $row3['TNO'];
    $re_choose_time=$row3['CHOOSE_DATE'];
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

// 检查退选申请状态
$sql4 = "SELECT * FROM CANCELLATION_REQUESTS WHERE STUDENT_NO = ?";
$stmt4 = $conn->prepare($sql4);
$stmt4->bind_param('s', $sno);
$stmt4->execute();
$result4 = $stmt4->get_result();
if ($row4 = $result4->fetch_assoc()) {
    $cancel_status = $row4['REQUEST_STATUS'];
    $request_time2 = $row4['REQUEST_DATE'];
}
mysqli_free_result($result4); // 释放结果集
mysqli_close($conn); // 关闭数据库连接
?>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>学生页面</title>
    <link type="text/css" rel="stylesheet" href="./src/student_page.css">
    <style>
        /* 添加基础布局样式 */
        body {
            display: flex;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        #sidebar {
            width: 200px;
            background-color: #f4f4f4;
            padding: 15px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        #sidebar a {
            display: block;
            color: #333;
            padding: 10px;
            text-decoration: none;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        #sidebar a:hover {
            background-color: #ddd;
        }

        #main-content {
            flex-grow: 1;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        #cancel_request_div, #app_status, #review_status, #result_status, #cancel_status {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<!-- 左侧导航栏 -->
<div id="sidebar">
    <h2>学生页面导航栏</h2>
    <a href="#" onclick="showSection('home')">首页</a>
    <a href="#" onclick="showSection('view_tutors')">查看导师信息</a>
    <a href="#" onclick="showSection('apply_tutor')">申请导师</a>
    <a href="#" onclick="showSection('cancel_tutor')">退选导师</a>
    <a href="#" onclick="showSection('application_record')">申请记录</a>
    <a href="#" onclick="showSection('cancellation_record')">退选记录</a>
</div>

<!-- 右侧内容展示区域 -->
<div id="main-content">
    <div id="home" class="content-section">
        <h1>你好，<?php echo $NAME ?>同学！</h1>
        <h3>欢迎使用学业导师管理系统！
            <br>我们的系统旨在为学生提供便捷的导师管理功能，确保每位学生都能找到最合适的导师来指导他们的学术研究和职业发展。<br>
            以下是我们的主要功能介绍：
        </h3>
        <ul>
            <li>选择导师</li>
            <p>
                学生可以通过系统浏览导师的详细信息，包括导师的研究领域、学术成就和联系方式等。系统提供智能推荐功能，根据学生的学术兴趣和需求，推荐最匹配的导师。学生可以根据自己的意愿，方便地在线提交导师选择申请。</p>
            <li>退选导师</li>
            <p>
                如果学生在指导过程中发现当前导师不符合自己的需求，系统允许学生在线申请退选导师。退选申请将会在导师和相关管理部门审核后生效，确保学生能够及时调整自己的指导安排。</p>
            <li>查询操作记录</li>
            <p>
                系统记录所有的操作日志，学生和导师都可以查询到相关的操作记录，包括导师选择、退选以及其他重要操作。这些记录有助于保障操作的透明性和公正性，确保每一位学生和导师的权益得到有效保护。</p>
        </ul>
        <h3> 我们的目标是通过这一系统，为学生提供一个高效、透明、灵活的导师管理平台，助力每一位学生在学术道路上取得优异的成绩。
            <br>欢迎使用学业导师管理系统，开启您的学业新篇章！</h3>
    </div>
    <div id="view_tutors" class="content-section" style="display:none;">
        <h1>导师信息</h1>
        <?php
        // 显示导师信息的表格
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
        ?>
    </div>
    <div id="apply_tutor" class="content-section" style="display:none;">
        <h1>申请导师</h1>
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
    </div>
    <div id="cancel_tutor" class="content-section" style="display:none;">
        <h1>退选导师</h1>
        <div id="cancel_request_div" style="display: none;">
            <form id="cancel_request_form" method="post" action="send_cancel_request.php">
                <input type="hidden" name="tutor_no" value="<?php echo $matched_tno; ?>">
                <input type="hidden" name="student_no" value="<?php echo $sno; ?>">
                <input type="hidden" name="student_name" value="<?php echo $NAME ?>">
                <textarea name="request_message" placeholder="请填写退选原因" required></textarea><br>
                <button type="submit">发送退选请求</button>
            </form>
        </div>
    </div>
    <div id="application_record" class="content-section" style="display:none;">
        <h1>申请记录</h1>
        <div class="application" id="app_status"></div>
        <div class="application" id="application_details"></div>
        <div class="application" id="result_status"></div>
        <div class="application" id="review_status"></div>
    </div>
    <div id="cancellation_record" class="content-section" style="display:none;">
        <h1>退选记录</h1>
        <div id="cancel_status"></div>
    </div>
</div>
</body>


<script>
    // JavaScript 用于切换显示内容
    function showSection(sectionId) {
        // 隐藏所有内容区域
        const sections = document.getElementsByClassName('content-section');
        for (let i = 0; i < sections.length; i++) {
            sections[i].style.display = 'none';
        }
        // 显示选中的内容区域
        document.getElementById(sectionId).style.display = 'block';
    }

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
    let request_time1 = "<?php echo $request_time1; ?>";
    let request_time2 = "<?php echo $request_time2; ?>";
    let re_choose_time = "<?php echo $re_choose_time; ?>";
    console.log(cancel_status);

    // 初始化页面内容
    showSection('home');

    // 检查申请状态
    if (application === 0 && re_choose === 0) {
        // 情况1: 学生尚未提交申请
        document.getElementById('app_status').innerHTML = '<h3>您尚未提交导师申请</h3>';
        document.getElementById('review_status').innerHTML = '<h3>请填写申请表并提交。</h3>';
    }
    if (application === 1 && re_choose === 0) {
        // 情况2: 学生已提交申请
        document.getElementById('app_status').innerHTML = '<h3>您的导师申请已提交</h3>'+'<p>申请提交时间:'+request_time1+'</p>';
        document.getElementById('application_details').innerHTML = `
            <h3>您申请的导师信息：</h3>
            <p>第一志愿导师：编号 - ${first_tno}，姓名 - ${first_tname}</p>
            <p>第二志愿导师：编号 - ${second_tno}，姓名 - ${second_tname}</p>
            <p>第三志愿导师：编号 - ${third_tno}，姓名 - ${third_tname}</p>
        `;
    }


    // 检查导师选择状态
    if (re_choose === 0 && application === 1) {
        // 情况3: 学生已提交申请，但导师尚未选择
        document.getElementById('app_status').innerHTML = '<h3>您的导师申请已提交</h3>'+'<p>申请提交时间:'+request_time1+'</p>';
        document.getElementById('review_status').innerHTML = '<h3>导师正在查看您的申请，请耐心等待......</h3>';
        document.getElementById('result_status').innerHTML = '<h3>您目前还没有被导师选择。</h3>';
    } else if (re_choose === 1) {
        document.getElementById('application_details').style.display = 'none';
        //不显示申请详情
        document.getElementById('app_status').innerHTML = '<h3>您的导师申请已提交</h3>';
        document.getElementById('review_status').innerHTML = `
            <h3>导师选择信息：</h3>
            <p>您已被导师选择：</p>
            <p>导师编号 - ${matched_tno}，姓名 - ${matched_tname}</p>
        `;
        document.getElementById('result_status').innerHTML = '<h3>恭喜！您已被导师选择。</h3>'+'<p>导师选择时间:'+re_choose_time+'</p>';
        document.getElementById('cancel_request_div').style.display = 'block'; // 显示退选表单
    }

    // 退选申请状态检查
    if (cancel_status === 'PENDING') {
        document.getElementById('cancel_status').innerHTML = '<h3>您已提交退选申请，请耐心等待导师处理。</h3>'+ '<p>退选申请时间:'+request_time2+'</p>';
    } else if (cancel_status === 'APPROVED') {
        document.getElementById('cancel_status').innerHTML = '<h3>您的退选申请已被导师批准。</h3>'+ '<p>退选申请时间:'+request_time2+'</p>'+"<button id='re_choose_t'>重新选择导师</button>";
    } else if (cancel_status === 'REJECTED') {
        document.getElementById('cancel_status').innerHTML = '<h3>您的退选申请已被导师拒绝。</h3>'+ '<p>退选申请时间:'+request_time2+'</p>';
    } else if (cancel_status === '') {
        document.getElementById('cancel_status').innerHTML = '<h3>您尚未提交退选申请。</h3>';
    }

    // 调试信息输出
    console.log("application: " + application);
    console.log("re_choose: " + re_choose);

    // 初始化显示首页内容
    showSection('home');
    // 重新选择导师
    document.getElementById('re_choose_t').onclick = function () {
        showSection('apply_tutor');
    }
</script>

</html>
