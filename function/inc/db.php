<?

$dbhost     = "5.7-mysql";
$dbuser     = "root";
$dbpass     = "xxxx";
$dbname     = "xxxx";

$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
date_default_timezone_set("Asia/Bangkok");
mysqli_query($conn,"SET CHARACTER SET 'utf8'");
mysqli_query($conn,"SET SESSION collation_connection ='utf8_unicode_ci'");

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  return;
  }

?>