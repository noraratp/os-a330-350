<?php
session_start();
require_once('inc/db.php');
$data = json_decode(file_get_contents("php://input"));
if(!empty($data->username) && !empty($data->password))
{
    $username = md5($data->username);
    $password = md5($data->password);
    $strSQL = "SELECT * FROM tb_user WHERE username = '$username' and password = '$password'";
    echo $strSQL;
    if ($result=mysqli_query($conn,$strSQL))
    {
        $object = new stdClass();
    // Fetch one and one row
        while ($row=mysqli_fetch_row($result))
        {  
            $object->username = $data->username;
            $object->firstname = $row[3];
            $object->lastname = $row[4];
            $object->nickname = $row[5];
            $object->type = $row[6];
            $object->email = $row[7];  

            #echo json_encode($object,JSON_UNESCAPED_UNICODE);
        }
        $_SESSION['login_user']= $object;
        if(!empty($object->username))
        {
            echo(http_response_code(200));
        }
        else
        {
            session_destroy();
            echo(http_response_code(404));
        }
    }
    else
    {
        session_destroy();
        echo(http_response_code(404));
    }
    
}
else
{
    session_destroy();
    echo(http_response_code(404));
}
mysqli_close($conn);
?>