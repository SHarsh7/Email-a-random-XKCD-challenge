<?php

namespace App\Models;

session_start();
require_once "user.php";
if (isset($_GET['user_id'])) {
        $user = new User();
        $code=$_GET['user_id'];
        var_dump($code);
        $delete_query = $user->db->prepare("DELETE FROM `auth` WHERE `activecode` = ? ");
        $delete_query->bind_param("s", $_GET['user_id']);
        var_dump($delete_query);
        if($delete_query->execute()){
                echo "successs";
                   $_SESSION['msg'] = "You have successfully unsubscribed";
        }
     
        echo "you are in";
} else {
        echo "a big fat error";
}
// echo "<script> location.href='index.php'; </script>";
die();
