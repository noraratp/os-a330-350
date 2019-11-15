<?
require_once('inc/db.php');
require_once('libs/helper.php');
//session_start();
// if($_SESSION['login_user'] == "")
// {
// 	header("Location: login.php");
// }

if(isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
    $params = $_GET['params'];
    switch($action) {
        case 'get_customer' : get_customer($params, $conn);
        break;
    }
}

function get_customer($params, $conn) {
    $sql="SELECT * FROM tb_vehicle";
    echo mysqli_get_json_list($sql, $conn);
}

?>