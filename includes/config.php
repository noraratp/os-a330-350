<!DOCTYPE html>
<?php
session_start();
switch ($_SERVER["SCRIPT_NAME"]) {
    case "/os-a330-350/import_excel.php":
        $CURRENT_PAGE = "Import";
        $PAGE_TITLE = "Import Emplooyee";
        // if($_SESSION['login_user']->type != "admin")
        // {
        // 	header("Location: index.php");
        // }
        break;
    case "/os-a330-350/employee_list.php":
        $CURRENT_PAGE = "EmployeeList";
        $PAGE_TITLE = "Employee List";
        // if($_SESSION['login_user']->type != "admin")
        // {
        // 	header("Location: index.php");
        // }
        break;
    default:
        $CURRENT_PAGE = "Index";
        $PAGE_TITLE = "Dashboard";
}