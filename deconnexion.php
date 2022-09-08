<?php 
    require_once(__DIR__.'/db.php');

    session_destroy();
    header("location:/admin.redac.ap");
    exit();
?>