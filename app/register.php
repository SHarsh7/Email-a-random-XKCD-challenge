<?php
namespace app;
session_start();


require_once dirname(__FILE__).'/user.php';
include dirname(__FILE__).'/validateForm.php';
require_once dirname(__FILE__).'/sendGridApi.php';
require_once dirname(__FILE__).'/encdec.php';

 


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['email'])) {
                $validate = new validateForm();
                if ($validate->validateEmail($_POST['email'])) {
                        $user = new User();
                        if ($user->reg_user($_POST['email'])) {
                                $email=$_POST['email'];
                                $emailUser= strstr($email, '@', true);
                                //* Fetching data
                                $result = $user->fetchdata($email);
                                $row = $result->fetch_assoc();
                                $activecode = $row['activecode'];

                                // * Encoding activationcode 
                                $encode=new encdec();
                                $activecode=$encode->enc($activecode);
                                $activecode=bin2hex($activecode);

                                $subject = 'Email Verification';
                                 $baseUrl= 'http' . ((isset($_SERVER['SERVER_PORT'])&&$_SERVER['SERVER_PORT']== 443) ? 's' : '') . '://' . (isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'') . '/subscribeUser';
                                $body = "<html>
                                                        <head>
                                                                <meta name='viewport' content='width=device-width'>
                                                                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
                                                        </head>
                                                        <body>
                                                        <p>Hi,$emailUser</p>
                                                        <p>Thank you for showing interest in our product now after you click on the link given below, you will start receiving our emails(A random XKCD webcomic) every 5 minutes, this may take a while(around 5 to 6 minutes or earlier). So take a deep breath and enjoy.</p>

                                                        <p style='margin-bottom:10px;font-weight:normal;font-size:14px;line-height:1.6;padding:15px;background-color:#ecf8ff;margin-bottom:15px;'>Please click on the link to verify yourself 
                                                        <a href='$baseUrl/$activecode'>Subscribe</a>
                                                        </p>
                                                        <p>Best Regards,<br />XKCD Team</p>
                                                        <p>If in case above link isn't working then copy paste text given below in your browser.</p>
                                                        <p>$baseUrl/$activecode</p>  
                                                        </body>
                                                 </html>";
                                $variEmail=new sendGridApi();
                                $variEmail->sendVarificationMail($email,$body,$subject);
                               
                                
                        } else {
                                $_SESSION['msg'] = 'You are already registered!';

                        }
                }
        }
}
$url='http' . ((isset($_SERVER['SERVER_PORT'])&&$_SERVER['SERVER_PORT']== 443) ? 's' : '') . '://' . (isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'')  . '/index';
echo "<script> location.href='$url'; </script>";
die();
