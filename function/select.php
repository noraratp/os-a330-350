<?php
require_once('inc/db.php');
require_once('libs/helper.php');
//session_start();
// if($_SESSION['login_user'] == "")
// {
// 	header("Location: login.php");
// }

if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
    $params = $_GET['params'];
    switch ($action) {
        case 'get_employee_list': get_employee_list($params, $conn);
        break;
    }
}

function get_employee_list($params, $conn)
{
    $sql="SELECT * ,((timeoff_quota - timeoff_used)/timeoff_quota * 100) as timeoff_percent from tb_employee";
    echo mysqli_get_json_list($sql, $conn);
}
