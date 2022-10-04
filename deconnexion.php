<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . '/ged/db.php');

    session_destroy();
    header("location:/ged");
    exit();
?>