<?php

namespace app;


//TODO: sanitize the incomming data
include dirname(__FILE__).'/validateForm.php';
require_once dirname(__FILE__).'/user.php';
include dirname(__FILE__).'/encdec.php';

if (isset($_GET['activecode'])) {
        $senitize=new validateForm();
        //* sanitizing incoming data
        $code=$senitize->test_input($_GET['activecode']);

        //*Decrypt the data
        $decryptData=new encdec();
        $code=$decryptData->decrypt($code);
        
        $user = new user();
        if($user->updatedata($code)){
                echo "Your account is verified, you will start receiving our emails soon!";
        }
        else{
                echo "something went wrong";
        }
       
}
