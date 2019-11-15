<?
// session_start();
// // Do Something
// if($_SESSION['login_user'] == "")
// {
// 	header("Location: login.php");
// }
//require_once('inc/db.php');

$data = json_decode(file_get_contents("php://input"));
if(!empty($_FILES))  
{  
    $date = date('Y-m-d_H-i-s');
  
    $file_name = $date .'_'. $_FILES['file']['name'];
    $path = '../../file_upload/'.$file_name;
    echo $path;
    if(move_uploaded_file($_FILES['file']['tmp_name'], $path))  
    {  
        // $username = $_SESSION['login_user']->username;
        // $insertQuery = "INSERT INTO tb_file(path,file_name,news_date,created_date,created_by) 
        // VALUES ('$path','".$file_name."',CAST('". $data->news_date ."' AS DATE),now(),' $username')";
        // if ($conn->query($insertQuery) === TRUE) 
        // {
        //     $last_id = $conn->insert_id;
        //     echo $last_id;
        // }
        echo $date;
    }else {
        echo "Error: ";
    }
    
}  
else  
{  
     echo 'Upload file error';  
}  
?>