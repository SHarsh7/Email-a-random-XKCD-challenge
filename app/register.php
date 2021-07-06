<?php
namespace app;

require_once dirname(__FILE__).'/user.php';
include dirname(__FILE__).'/validateForm.php';
require_once dirname(__FILE__).'/sendGridApi.php';

 


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

                                // * Encoding activationcode 
                                $activecode=base64_encode($activecode);

                                $subject = "Email Verification";
                                $baseUrl="https://xkcdmailer.herokuapp.com/subscribeUser";
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
                                                        <p>If in case above link isn't working then copy paste text given below in your browser.</p>
                                                        <p>$baseUrl/$activecode</p>  
                                                        </body>
                                                 </html>";
                                $variEmail=new sendGridApi();
                                $variEmail->sendVarificationMail($email,$body,$subject);
                               
                                
                        } else {
                                $_SESSION['msg'] = "You are alerady registerd!";

                        }
                }
        }
}
echo "<script> location.href='index.php'; </script>";
die();
