<?php

namespace app;


require_once dirname(__FILE__) . '/user.php';
require_once dirname(__FILE__) . '/validateForm.php';
require_once dirname(__FILE__) . '/encdec.php';


if (isset($_GET['activecode'])) {

        //*Senitize the data
        $senitize = new validateForm();
        $code = $senitize->test_input($_GET['activecode']);
        $code = $_GET['activecode'];
        $code = hex2bin($code);

        //* Decode the data
        $decode = new encdec();
        $code = $decode->dec($code);



        $user = new user();
        if ($user->updatedata($code)) {
                echo "<h3>Your account is verified, you will start receiving our emails soon!</h3>
                <p><b>Note:</b>As we are sending emails in a batch, it may take up to 5-6 minutes to receive the first email, so please be patient & please do check spam and promotions tab if you haven't received any emails in 5-6 minutes & thank you very much for joining us.</p>";
        } else {
                echo 'something went wrong';
        }
}
