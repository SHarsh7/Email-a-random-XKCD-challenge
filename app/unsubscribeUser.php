<?php

namespace app;

session_start();
require_once dirname(__FILE__).'/user.php';
require_once dirname(__FILE__) . '/validateForm.php';

if (isset($_GET['user_id'])) {

            //*Senitize the data
        $senitize=new validateForm();
        $code=$senitize->test_input($_GET['user_id']);
        //* Decoding the data
        $code=base64_decode($code);
        $user = new User();
        $delete_query = $user->db->prepare("DELETE FROM `auth` WHERE `activecode` = ? ");
        $delete_query->bind_param("s", $code);

        if($delete_query->execute()){
                echo "You have successfully unsubscribed! You can join us again by clicking <a href='https://xkcdmailer.herokuapp.com/index'>Here</a>";
        }
     
} else {
        echo "Something went wrong!";
}
die();
