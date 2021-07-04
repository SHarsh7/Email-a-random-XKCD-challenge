<?php
namespace app;

require_once dirname(__FILE__).'/user.php';
include dirname(__FILE__).'/validateForm.php';
include dirname(__FILE__).'/sandGridApi.php';
include dirname(__FILE__).'/encdec.php';

 //TODO:integrate sendgrid api


if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["email"])) {
                $validate = new validateForm();
                if ($validate->validateEmail($_POST["email"])) {
                        $user = new User();
                        if ($user->reg_user($_POST["email"])) {
                                $email=$_POST["email"];

                                //* Fetching data
                                $result = $user->fetchdata($email);
                                $row = $result->fetch_assoc();
                                $activecode = $row['activecode'];

                                // * Encrypting activationcode 
                                $encryptData=new encdec();
                                $activecode=$encryptData->encrypt($activecode);

                                $subject = "Email Verification";
                                //todo:set base url
                                $baseUrl="";
                                $body = "<html>
                                                        <head>
                                                                <meta name='viewport' content='width=device-width'>
                                                                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
                                                        </head>
                                                        <body>
                                                        <p style='margin-bottom:10px;font-weight:normal;font-size:14px;line-height:1.6;padding:15px;background-color:#ecf8ff;margin-bottom:15px;'>Please click on the link to verify yourself 
                                                        <a href='$baseUrl/$activecode'>Here</a>
                                                        </p>
                                                        <p>Best Regards,<br />XKCD Team</p>
                                                        <p>$baseUrl/$activecode</p>  
                                                        </body>
                                                 </html>";
                                $variEmail=new sendGridApi();
                                $variEmail->sendVarificationMail($email,$body,$subject);
                                //TODO:Make a .htaccess file for URL ($baseUrl/$activecode)
                                
                        } else {
                                $_SESSION['msg'] = "You are alerady registerd!";

                        }
                }
        }
}
echo "<script> location.href='index.php'; </script>";
die();
