
<?php
// $dbhost     = "localhost";
// $dbuser     = "greanman_honda";
// $dbpass     = "159874236";
// $dbname     = "greanman_honda";

$dbhost     = "5.7-mysql";
$dbuser     = "root";
$dbpass     = "P@ssw0rd";
$dbname     = "os-a330-3650x";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

date_default_timezone_set("Asia/Bangkok");
mysqli_query($conn, "SET CHARACTER SET 'utf8'");
mysqli_query($conn, "SET SESSION collation_connection ='utf8_unicode_ci'");

if (mysqli_connect_errno()) {
    header_remove();
    // set the actual code
    http_response_code(500);
    // set the header to make sure cache is forced
    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
    // treat this as json
    header('Content-Type: application/json');
    // ok, validation error, or failure
    header('Status: 500');
    // return the encoded json
    echo json_encode(array(
        'status' => false, // success or not?
        'message' => "Failed to connect to MySQL: " . mysqli_connect_error()
        ));
    return;
}

?>