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
        echo $code;
        echo "<br/>";
        

        $user = new user();
        var_dump($user->updatedata($code));
        if ($user->updatedata($code)) {
                echo "Your account is verified, you will start receiving our emails soon!";
        } else {
                echo "something went wrong";
        }
}
