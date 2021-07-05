<?php

namespace app;

require_once dirname(__FILE__) . '/user.php';
require_once dirname(__FILE__) . '/encdec.php';

if (isset($_GET['activecode'])) {

        //*Decrypt the data
        $decryptData = new encdec();
        $code=$_GET['activecode'];
        echo $code;
        echo "<br/>";
        $code = $decryptData->decrypt($code);
        echo $code;
        

        $user = new user();
        var_dump($user->updatedata($code));
        if ($user->updatedata($code)) {
                echo "Your account is verified, you will start receiving our emails soon!";
        } else {
                echo "something went wrong";
        }
}
