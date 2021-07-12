<?php

namespace app;

session_start();
require_once dirname(__FILE__) . '/user.php';
require_once dirname(__FILE__) . '/validateForm.php';
require_once dirname(__FILE__) . '/encdec.php';

if (isset($_GET['user_id'])) {

        //*Senitize the data
        $senitize = new validateForm();
        $code = $senitize->test_input($_GET['user_id']);
        //* Decoding the data
        $code = hex2bin($code);
        $decode = new encdec();
        $code = $decode->dec($code);


        $user = new User();
        $delete_query = $user->db->prepare('DELETE FROM `auth` WHERE `activecode` = ? ');
        $delete_query->bind_param('s', $code);

        if ($delete_query->execute()) {
                $url = 'http' . ((isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ? 's' : '') . '://' . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . '/index';
                echo "You have successfully unsubscribed! You can join us again by clicking <a href='$url'>Here</a>";
        }
} else {
        echo 'Something went wrong!';
}
die();
