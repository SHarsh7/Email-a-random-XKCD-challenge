<?php

namespace app;

session_start();
require_once dirname(__FILE__).'/user.php';
require_once dirname(__FILE__) . '/validateForm.php';

if (isset($_GET['user_id'])) {

            //*Senitize the data
        $senitize=new validateForm();
        $code=$senitize->test_input($_GET['user_id']);

        $user = new User();
        $delete_query = $user->db->prepare("DELETE FROM `auth` WHERE `activecode` = ? ");
        $delete_query->bind_param("s", $code);

        if($delete_query->execute()){
                   $_SESSION['msg'] = "You have successfully unsubscribed";
        }
     
} else {
        echo "Something went wrong!";
}
echo "<script> location.href='index.php'; </script>";
die();
