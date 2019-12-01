<?php
require_once('inc/db.php');
require_once('libs/helper.php');
session_start();
if($_SESSION['login_user'] == "")
{
	header("Location: login.php");
}

if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
    $params = $_GET['params'];
    $id = $_GET['id'];
    switch ($action) {
        case 'get_employee_list': get_employee_list($id, $params, $conn);
        break;
        case 'get_employee_by_id': get_employee_by_id($id, $params, $conn);
        break;
        case 'get_timeoff_list': get_timeoff_list($id, $params, $conn);
        break;
        case 'get_behavior_list': get_behavior_list($id, $params, $conn);
        break;
    }
    
}

function get_employee_list($id, $params, $conn)
{
    $sql="SELECT * ,((timeoff_quota - timeoff_used)/timeoff_quota * 100) as timeoff_percent from tb_employee";
    echo mysqli_get_json_list($sql, $conn);
}
function get_employee_by_id($id, $params, $conn)
{
    $sql="SELECT * ,((timeoff_quota - timeoff_used)/timeoff_quota * 100) as timeoff_percent from tb_employee WHERE id='$id'";
    echo mysqli_get_json_object($sql, $conn);
}
function get_timeoff_list($id, $params, $conn)
{
    $sql="SELECT t1.*, CONCAT(t2.rank , ' ' , t2.name_en , ' ' , t2.f_surname_en) as employee_display  ,t2.timeoff_used ,t2.timeoff_quota,t2.picture,
    ((t2.timeoff_quota - t2.timeoff_used)/t2.timeoff_quota * 100) as timeoff_percent ,t2.gothaimail,t2.mobile,t2.name_en,t2.surname_en
    FROM tb_timeoff t1 LEFT JOIN tb_employee t2 on t2.id = t1.employee_id ";
    if($params->created_date) {
        $sql .= " WHERE t1.created_date = '$params->created_date'";
    }
    if($id) {
        $sql .= " WHERE t1.employee_id = '$id'";
    }
    $sql .= " ORDER BY t1.created_date desc";

    echo mysqli_get_json_list($sql, $conn);
    
}
function get_behavior_list($id, $params, $conn)
{
    $sql="SELECT t1.*, CONCAT(t2.rank , ' ' , t2.name_en , ' ' , t2.f_surname_en) as employee_display  ,t2.timeoff_used ,t2.timeoff_quota,t2.picture,
    ((t2.timeoff_quota - t2.timeoff_used)/t2.timeoff_quota * 100) as timeoff_percent ,t2.gothaimail,t2.mobile,t2.name_en,t2.surname_en
    , (CASE WHEN t1.type = 'good' THEN 'ประพฤติกระทำความดี' WHEN t1.type = 'bad' THEN 'ประพฤติกระทำความผิด' END) as type_display
    FROM tb_behavior t1 LEFT JOIN tb_employee t2 on t2.id = t1.employee_id ";
    if($params->created_date) {
        $sql .= " WHERE t1.created_date = '$params->created_date'";
    }
    if($id) {
        $sql .= " WHERE t1.employee_id = '$id'";
    }
    $sql .= " ORDER BY t1.created_date desc";
    
    echo mysqli_get_json_list($sql, $conn);
    
}
