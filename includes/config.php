<!DOCTYPE html>
<?php
session_start();
switch ($_SERVER["SCRIPT_NAME"]) {
    default:
        $CURRENT_PAGE = "Index";
        $PAGE_TITLE = "Dashboard";
}
