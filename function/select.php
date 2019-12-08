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
        case 'get_summary_sick_by_month': get_summary_sick_by_month($params, $conn);
        break;
        case 'get_summary_sick_by_year': get_summary_sick_by_year($params, $conn);
        break;
        case 'get_dashboard_summary': get_dashboard_summary($params, $conn);
        break;
        case 'get_timeoff_sum_by_emp': get_timeoff_sum_by_emp($params, $conn);
        break;
    }
    
}

function get_employee_list($id, $params, $conn)
{
    $sql="SELECT * ,((timeoff_quota - timeoff_used)/timeoff_quota * 100) as timeoff_percent,
    SUBSTRING(rank,1,2) as sub_rank
    from tb_employee WHERE status = 1";
    echo mysqli_get_json_list($sql, $conn);
}
function get_employee_by_id($id, $params, $conn)
{
    $sql="SELECT * ,((timeoff_quota - timeoff_used)/timeoff_quota * 100) as timeoff_percent ,
    SUBSTRING(rank,1,2) as sub_rank
    from tb_employee
    WHERE id='$id' and status = 1";
    echo mysqli_get_json_object($sql, $conn);
}
function get_timeoff_list($id, $params, $conn)
{
    $sql="SELECT t1.*, CONCAT(t2.rank , ' ' , t2.name_en , ' ' , t2.f_surname_en) as employee_display  ,t2.timeoff_used ,t2.timeoff_quota,t2.picture,
    ((t2.timeoff_quota - t2.timeoff_used)/t2.timeoff_quota * 100) as timeoff_percent ,t2.gothaimail,t2.mobile,t2.name_en,t2.surname_en
    FROM tb_timeoff t1 LEFT JOIN tb_employee t2 on t2.id = t1.employee_id WHERE 0=0 and t2.status =1 ";
    if($params->created_date) {
        $sql .= " and t1.created_date = '$params->created_date'";
    }
    if($id) {
        $sql .= " and t1.employee_id = '$id'";
    }
    $sql .= " and t1.is_deleted = 0";
    $sql .= " ORDER BY t1.created_date desc";

    echo mysqli_get_json_list($sql, $conn);
    
}
function get_timeoff_sum_by_emp($params, $conn)
{
    $sql="select count(t1.id) as count_sick ,  CONCAT(t2.rank , ' ' , t2.name_en , ' ' , t2.f_surname_en) as employee_display 
    ,t2.gothaimail,t2.mobile,t2.name_en,t2.surname_en ,t2.id
    from tb_employee t2
    LEFT JOIN tb_timeoff t1 on t2.id = t1.employee_id and t1.is_deleted=0 
    WHERE 0=0 and t2.status = 1";
    if($params->year) {
        $sql .= " and YEAR(t1.start_date) = '$params->year'";
    }
    if($params->month) {
        $sql .= " and MONTH(t1.start_date) = '$params->month'";
    }
    $sql .= " GROUP BY t2.id";

    echo mysqli_get_json_list($sql, $conn);
    
}
function get_behavior_list($id, $params, $conn)
{
    $sql="SELECT t1.*, CONCAT(t2.rank , ' ' , t2.name_en , ' ' , t2.f_surname_en) as employee_display  ,t2.timeoff_used ,t2.timeoff_quota,t2.picture,
    ((t2.timeoff_quota - t2.timeoff_used)/t2.timeoff_quota * 100) as timeoff_percent ,t2.gothaimail,t2.mobile,t2.name_en,t2.surname_en
    , (CASE WHEN t1.type = 'good' THEN 'ประพฤติกระทำความดี' WHEN t1.type = 'bad' THEN 'ประพฤติกระทำความผิด' END) as type_display
    FROM tb_behavior t1 LEFT JOIN tb_employee t2 on t2.id = t1.employee_id WHERE 0=0 and t1.is_deleted=0 and t2.status = 1 ";
    if($params->created_date) {
        $sql .= " and t1.created_date = '$params->created_date'";
    }
    if($id) {
        $sql .= " and t1.employee_id = '$id'";
    }
    $sql .= " ORDER BY t1.created_date desc";
    
    echo mysqli_get_json_list($sql, $conn);
    
}
function get_summary_sick_by_month($params, $conn)
{
    $sql = "select 
    IFNULL(SUM(t1.days),0) as Monday, 
    IFNULL(SUM(t2.days),0) as Tuesday,
    IFNULL(SUM(t3.days),0) as Wednesday,
    IFNULL(SUM(t4.days),0) as Thursday,
    IFNULL(SUM(t5.days),0) as Friday,
    IFNULL(SUM(t6.days),0) as Saturday,
    IFNULL(SUM(t7.days),0) as Sunday,
    SUBSTRING(e.rank,1,2) as rank,
    IFNULL(SUM(tb.days),0) as sumall
    from tb_timeoff tb
    LEFT JOIN tb_timeoff t1 on t1.id = tb.id and DAYNAME(t1.start_date) = 'Monday'
    LEFT JOIN tb_timeoff t2 on t2.id = tb.id and DAYNAME(t2.start_date) = 'Tuesday'
    LEFT JOIN tb_timeoff t3 on t3.id = tb.id and DAYNAME(t3.start_date) = 'Wednesday'
    LEFT JOIN tb_timeoff t4 on t4.id = tb.id and DAYNAME(t4.start_date) = 'Thursday'
    LEFT JOIN tb_timeoff t5 on t5.id = tb.id and DAYNAME(t5.start_date) = 'Friday'
    LEFT JOIN tb_timeoff t6 on t6.id = tb.id and DAYNAME(t6.start_date) = 'Saturday'
    LEFT JOIN tb_timeoff t7 on t7.id = tb.id and DAYNAME(t7.start_date) = 'Sunday'
    LEFT JOIN tb_employee e on e.id = tb.employee_id
    
    GROUP BY SUBSTRING(e.rank,1,2)";
    if ($params == "") {
        $sql .= " WHERE YEAR(tb.start_date) =  YEAR(CURDATE())";
    }
    else {
        $sql .= " WHERE YEAR(tb.start_date) = '$params'";
    }
    
    $sql .= " GROUP BY SUBSTRING(e.rank,1,2)";
    echo mysqli_get_json_list($sql, $conn);
}
function get_summary_sick_by_year($params, $conn)
{
    $sql = "select 
    IFNULL(SUM(t1.days),0) as January, 
    IFNULL(SUM(t2.days),0) as February,
    IFNULL(SUM(t3.days),0) as March,
    IFNULL(SUM(t4.days),0) as Apirl,
    IFNULL(SUM(t5.days),0) as May,
    IFNULL(SUM(t6.days),0) as June,
    IFNULL(SUM(t7.days),0) as July,
    IFNULL(SUM(t8.days),0) as August,
    IFNULL(SUM(t9.days),0) as September,
    IFNULL(SUM(t10.days),0) as October,
    IFNULL(SUM(t11.days),0) as November,
    IFNULL(SUM(t12.days),0) as December,
    SUBSTRING(e.rank,1,2) as rank,
    IFNULL(SUM(tb.days),0) as sumall
    from tb_timeoff tb
    LEFT JOIN tb_timeoff t1 on t1.id = tb.id and MONTH(t1.start_date) = 1 and t1.is_deleted = 0
    LEFT JOIN tb_timeoff t2 on t2.id = tb.id and MONTH(t2.start_date) = 2 and t2.is_deleted = 0
    LEFT JOIN tb_timeoff t3 on t3.id = tb.id and MONTH(t3.start_date) = 3 and t3.is_deleted = 0
    LEFT JOIN tb_timeoff t4 on t4.id = tb.id and MONTH(t4.start_date) = 4 and t4.is_deleted = 0
    LEFT JOIN tb_timeoff t5 on t5.id = tb.id and MONTH(t5.start_date) = 5 and t5.is_deleted = 0
    LEFT JOIN tb_timeoff t6 on t6.id = tb.id and MONTH(t6.start_date) = 6 and t6.is_deleted = 0
    LEFT JOIN tb_timeoff t7 on t7.id = tb.id and MONTH(t7.start_date) = 7 and t7.is_deleted = 0
    LEFT JOIN tb_timeoff t8 on t8.id = tb.id and MONTH(t8.start_date) = 8 and t8.is_deleted = 0
    LEFT JOIN tb_timeoff t9 on t9.id = tb.id and MONTH(t9.start_date) = 9 and t9.is_deleted = 0
    LEFT JOIN tb_timeoff t10 on t10.id = tb.id and MONTH(t10.start_date) = 10 and t10.is_deleted = 0
    LEFT JOIN tb_timeoff t11 on t11.id = tb.id and MONTH(t11.start_date) = 11 and t11.is_deleted = 0
    LEFT JOIN tb_timeoff t12 on t12.id = tb.id and MONTH(t12.start_date) = 12 and t12.is_deleted = 0
    LEFT JOIN tb_employee e on e.id = tb.employee_id and e.status = 1
    WHERE 0=0 and tb.is_deleted = 0";
    if ($params == "") {
        $sql .= " and YEAR(tb.start_date) =  YEAR(CURDATE())";
    }
    else {
        $sql .= " and YEAR(tb.start_date) = '$params'";
    }
    
    $sql .= " GROUP BY SUBSTRING(e.rank,1,2)";
    echo mysqli_get_json_list($sql, $conn);
}
function get_dashboard_summary($params, $conn)
{
    $sql = "SELECT count(tf.id) as leave_today
    , (select count(id) from tb_employee where SUBSTRING(rank,1,2) = 'FC' and status=1) as all_cap
    , (select count(id) from tb_employee where SUBSTRING(rank,1,2) = 'FP' and status=1) as all_co
    FROM
    tb_timeoff tf
    WHERE date(tf.start_date) = date(now()) and tf.is_deleted = 0";
    echo mysqli_get_json_object($sql, $conn);
}