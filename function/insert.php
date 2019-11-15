<?
require_once('inc/db.php');
require_once('libs/helper.php');
//session_start();
// if($_SESSION['login_user'] == "")
// {
// 	header("Location: login.php");
// }
$data = json_decode(file_get_contents("php://input"));
$action = $data->action;
if(isset($action) && !empty($action)) {
    $params = $data->post_data;
    switch($action) {
        case 'save_customer' : save_customer($params, $conn);
        break;
        case 'update_customer' : update_customer($params, $conn);
        break;
        default: echo json_response(500, "Not found methods");
    }
}

function save_customer($params, $conn) {
    $sql = "INSERT INTO tb_customers (code,firstname,lastname,nickname,contact_name,email,tel,status,created_date,updated_date,created_by,updated_by,picture) 
    VALUES ('xxx','$params->firstname','$params->lastname','','','','','',now(),now(),'admin','admin','$params->picture')";
    $result = mysqli_execute_db($sql, $conn);
    echo $result;
}
function update_customer($params, $conn) {
    $sql = "UPDATE tb_customers SET firstname='$params->firstname',picture='$params->picture',updated_date=now() WHERE id = $params->id";
    $result = mysqli_execute_db($sql, $conn , $_FILES);
    echo $result;
}
?>

