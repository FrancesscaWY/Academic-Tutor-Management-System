<?php
$pwd = file_get_contents('D:/PHP/file/S_T_ADMIN_SYS/src/pw.txt');
$db_host = 'localhost';
$db_user = 'root';
$db_password = $pwd;
$db_name = 'Academic_Tutor_Management_System';

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die('Database connection error');
echo 'Connected successfully<br>';

// 检查记录是否已经存在的函数
function record_exists($conn, $tno) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM TUTORS WHERE TNO = ?");
    $stmt->bind_param("s", $tno);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count > 0;
}

// 要插入的数据
$data = [
    ['8090006', '张华', '男', '副教授', '1978-06-06', '计算机科学与技术', '计算机视觉'],
    ['8090007', '李凯', '男', '副教授', '1979-07-07', '计算机科学与技术', '计算机组成原理'],
    ['8090008', '王华', '男', '副教授', '1980-08-08', '计算机科学与技术', '计算机组成原理'],
    ['8131201', '李里', '女', '教授',   '1900-12-12', '软件工程', '人工智能'],
    ['8131202', '王明', '男', '教授',   '1901-01-01', '软件工程', '人工智能'],
    ['8131203', '张明', '男', '教授',   '1902-02-02', '软件工程', '人工智能'],
];

// 插入数据
foreach ($data as $row) {
    list($tno, $tname, $tsex, $professional_title, $tbirthdate, $majior, $research_field) = $row;
    if (!record_exists($conn, $tno)) {
        $stmt = $conn->prepare("INSERT INTO TUTORS (TNO, TNAME, TSEX, PROFESSIONAL_TITLE, TBIRTHDATE, MAJIOR, RESEARCH_FIELD) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $tno, $tname, $tsex, $professional_title, $tbirthdate, $majior, $research_field);
        if ($stmt->execute()) {
            echo 'New record created successfully for ' . $tname . '<br>';
        } else {
            echo 'Error: ' . $stmt->error . '<br>';
        }
        $stmt->close();
    } else {
        echo 'Record for ' . $tname . ' already exists<br>';
    }
}

$conn->close();
?>