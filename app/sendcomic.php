<?php

namespace app;

use mysqli;


require_once "XKCDapi.php";
require_once "sandGridApi.php";


class sendComic
{
        public $db;

        public function __construct()
        {
                $this->db = new mysqli(getenv('DB_SERVER'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_DATABASE'));

                if (mysqli_connect_errno()) {
                        echo "Error: Could not connect to database.";
                        exit;
                }
        }
        public function fetchdata()
        {
                echo "in fetch data";
                $fetch_query = "SELECT `email`,`activecode`FROM `auth` WHERE `userstatus`='subscribed' ";
                $result = $this->db->query($fetch_query);
                $numRow = $result->num_rows;

                $row = $result->fetch_all();
                for ($i = 0; $i < $numRow; $i++) {
                        $to = $row[$i][0];
                        $code = $row[$i][1];
                        $this->Email($to, $code);
                }
                sleep(300); //* 5 min delay 

                // * calling function recursively
                $subscriber = new sendComic();
                $subscriber->fetchdata();
        }
        public function Email($reciever, $code)
        {

                echo "in email";
                $comic = new XKCDapi();
                $data = $comic->fetchComic();



                $subject = "your comic here";
                $baseUrl = "https://php-xkcd-mailer.herokuapp.com/unsubscribeUser";
                $txt = "<html>
                                <head>
                                        <meta name='viewport' content='width=device-width'>
                                        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
                                </head>
                                <body bgcolor='#FFFFFF' topmargin='0' leftmargin='0' marginheight='0' marginwidth='0' style='height:100%;width:100% !important;'>
                                        <table style='width:100%;'>
                                        <tr>
                                                <td ></td>
                                                <td bgcolor='#FFFFFF' style='display:block !important;max-width:600px !important;margin:0 auto !important;clear:both !important;'>
                                                <div style='padding:15px;max-width:600px;margin:0 auto;display:block;'>
                                                        <table style='width:100%;'>
                                                                <tr>
                                                                        <td>
                                                                                <h1 >$data[1]</h1>
                                                                                <p style='margin-bottom:10px;font-weight:normal;font-size:14px;line-height:1.6;'><a href='$data[0]' download><img src='$data[0]' style='max-width:100%;'/></p>
                                                                                <p style='margin-bottom:10px;font-weight:normal;font-size:14px;line-height:1.6;font-size:17px;'>$data[2]</p>
                                                                        </td>
                                                                </tr>
                                                        </table>
                                                </div>
                                                <div style='padding:15px;max-width:600px;margin:0 auto;display:block;'>
                                                        <table bgcolor='' style='width:100%;'>
                                                                <tr>
                                                                        <td >
                                                                                <p style='margin-bottom:10px;font-weight:normal;font-size:14px;line-height:1.6;padding:15px;background-color:#ecf8ff;margin-bottom:15px;'>Tired of receiving our emails &#128557; <a href='$baseUrl/$code' style='font-weight:bold;color:#2ba6cb;'>Unsubscribe</a></p>
                                                                        </td>
                                                                </tr>
                                                        </table>
                                                </div>
                                                </td>
                                                <td ></td>
                                        </tr>
                                        </table>
                                </body>
                         </html>";
                $file = basename($data[0]);
                file_put_contents($file, file_get_contents($data[0]));

                $senduser = new sendGridApi();
                $senduser->comicSender($reciever, $txt, $subject, $file);
        }
}
sleep(40); //* initial delay
$subscriber = new sendComic();
$subscriber->fetchdata();
