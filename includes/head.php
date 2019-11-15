<!-- <?php
session_start();

if ($_SESSION['login_user'] == "") {?>
<meta http-equiv="Refresh" content="0; url=login.php">
<?php } ?>
<title><?php print $PAGE_TITLE;?></title>

<?php if ($CURRENT_PAGE == "Index") { ?>
<meta name="description" content="" />
<meta name="keywords" content="" />
<?php } ?> -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="x-ua-compatible" content="ie=edge">

<title><?php print $PAGE_TITLE;?></title>

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="includes/plugins/fontawesome-free/css/all.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="includes/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="includes/dist/css/adminlte.css">
<link rel="stylesheet" href="includes/dist/css/site.css">