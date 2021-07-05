<?php

namespace app;

include dirname(__FILE__).'/validateForm.php';
require_once dirname(__FILE__).'/user.php';
require_once dirname(__FILE__).'/encdec.php';

if (isset($_GET['activecode'])) {
        $senitize=new validateForm();
        //* sanitizing incoming data
        $code=$senitize->test_input($_GET['activecode']);
        var_dump($code);
        //*Decrypt the data
        $decryptData=new encdec();
        $code=$decryptData->decrypt($code);
        var_dump($code);
        
        $user = new user();
        var_dump($user->updatedata($code));
        if($user->updatedata($code)){
                echo "Your account is verified, you will start receiving our emails soon!";
        }
        else{
                echo "something went wrong";
        }
       
}
