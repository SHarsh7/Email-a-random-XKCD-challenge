<?php

namespace app;

use mysqli;


require_once dirname(__FILE__) . '/XKCDapi.php';
require_once dirname(__FILE__) . '/sendGridApi.php';


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
                if ($fetch_query = $this->db->prepare("SELECT `email`,`activecode`FROM `auth` WHERE `userstatus`=? ")) {
                        $status = "subscribed";
                        $fetch_query->bind_param("s", $status);
                        $fetch_query->execute();
                        $fetch_result = $fetch_query->get_result();
                        $row = $fetch_result->fetch_all();
                        $num=count($row);
                        for($i=0;$i<$num;$i++){
                                $to=$row[$i][0];
                                $code=$row[$i][1];
                                 $this->Email($to, $code);
                        }
                       
                }
                sleep(300); //* 5 min delay 

                // * calling function recursively
                $subscriber = new sendComic();
                $subscriber->fetchdata();
        }
        public function Email($reciever, $code)
        {

                $comic = new XKCDapi();
                $data = $comic->fetchComic();

                //*removing special chars & title text
                $start = strpos($data[1], '{');
                $end = strlen($data[1]);
                $data[1] = trim($data[1], substr($data[1], $start, $end));
                $data[1] = str_replace(array('[', ']', '{', '}'), '', $data[1]);

                //*Encoding the code
                $code = base64_encode($code);
                $subject = "XKCD comic";
                $baseUrl=getenv('SERVER_PORT')."://".getenv('HTTP_HOST')."/unsubscribeUser" ;
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
                                                                                <h2>$data[2]</h2>
                                                                                <p style='margin-bottom:10px;'><a href='$data[0]' download><img src='$data[0]' style='max-width:100%;'/></p>
                                                                                <p style='margin-bottom:10px'><pre><h4>$data[1]</h4></pre></p>
                                                                                <p style='margin-bottom:10px'><h3>$data[3]</h3></p>
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
$subscriber = new sendComic();
$subscriber->fetchdata();
