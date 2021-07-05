<?php

namespace app;

require_once dirname(__FILE__) . '/user.php';
require_once dirname(__FILE__) . '/validateForm.php';

if (isset($_GET['activecode'])) {

        //*Senitize the data
        $senitize=new validateForm();
        $code=$senitize->test_input($_GET['activecode']);

        //* Decode the data
        $code=base64_decode($code);
    
        

        $user = new user();
        if ($user->updatedata($code)) {
                echo "<h3>Your account is verified, you will start receiving our emails soon!</h3>";
        } else {
                echo "something went wrong";
        }
}
