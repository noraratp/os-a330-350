<?php
require_once('inc/db.php');
require_once('libs/helper.php');
//session_start();
// if($_SESSION['login_user'] == "")
// {
// 	header("Location: login.php");
// }
$data = json_decode(file_get_contents("php://input"));
$action = $data->action;
if (isset($action) && !empty($action)) {
    $params = $data->post_data;
    switch ($action) {
        case 'save_customer': save_customer($params, $conn);
        break;
        case 'update_customer': update_customer($params, $conn);
        break;
        case 'insert_employee': insert_employee($data, $conn);
        break;
        case 'insert_leave': insert_leave($data, $conn);
        break;
        default: echo json_response(500, "Not found methods");
    }
}

function save_customer($params, $conn)
{
    $sql = "INSERT INTO tb_customers (code,firstname,lastname,nickname,contact_name,email,tel,status,created_date,updated_date,created_by,updated_by,picture) 
    VALUES ('xxx','$params->firstname','$params->lastname','','','','','',now(),now(),'admin','admin','$params->picture')";
    $result = mysqli_execute_db($sql, $conn);
    echo $result;
}
function update_customer($params, $conn)
{
    $sql = "UPDATE tb_customers SET firstname='$params->firstname',picture='$params->picture',updated_date=now() WHERE id = $params->id";
    $result = mysqli_execute_db($sql, $conn, $_FILES);
    echo $result;
}

function insert_employee($params, $conn)
{
    foreach ($params->post_data as $row) {
        $sql = " INSERT INTO tb_employee (pers,rank,name_en,surname_en,f_surname_en
        ,mobile,nickname,name_th,surname_th,gothaimail,created_by,created_date,status)
        VALUES (
        $row->pers,
        '$row->rank',
        '$row->name_en',
        '$row->surname_en',
        '$row->f_surname_en',
        '$row->mobile',
        '$row->nickname',
        '$row->name_th',
        '$row->surname_th',
        '$row->gothaimail',
        'test',now(),1) ";

        $result = mysqli_execute_db($sql, $conn);
    }


    echo $result;
}

function insert_leave($params, $conn)
{
    $row = $params->post_data;
    $sql = " INSERT INTO tb_timeoff (employee_id,start_date,end_date,days,note
    ,medical_cert,created_by,created_date)
    VALUES (
    $row->id,
    '$row->start_date',
    '$row->end_date',
    $row->leave_days,
    '$row->note',
    '$row->medical_cert',
    'test',now()) ";

    $result = mysqli_execute_db($sql, $conn);

    $sql = "UPDATE tb_employee SET timeoff_used=(timeoff_used+$row->leave_days) ,updated_date=now(),updated_by='test' WHERE id = $row->id";
    $result = mysqli_execute_db($sql, $conn, $_FILES);

    echo $result;
}