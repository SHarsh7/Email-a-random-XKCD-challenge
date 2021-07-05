<?php

namespace app;
require_once dirname(__FILE__) . '/user.php';
class sendGridApi
{


        private $url = 'https://api.sendgrid.com/api/mail.send.json';
        private $session;
        private $js = array(
                'sub' => array(':name' => array('XKCD')),
        );


        public function __construct()
        {
                $sendgrid_apikey = getenv('sendgrid_apikey');
                $this->session = curl_init($this->url);
                curl_setopt($this->session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
                curl_setopt($this->session, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $sendgrid_apikey));
                curl_setopt($this->session, CURLOPT_POST, true);
                curl_setopt($this->session, CURLOPT_HEADER, false);
                curl_setopt($this->session, CURLOPT_RETURNTRANSFER, true);
        }
        public function sendVarificationMail($email, $body, $subject)
        {
                $params = array(
                        'to'        => $email,
                        'from'      => "noobbot12367@gmail.com",
                        'fromname'  => "XKCD",
                        'subject'   => $subject,
                        'html'      => $body,
                        'x-smtpapi' => json_encode($this->js),
                );
                curl_setopt($this->session, CURLOPT_POSTFIELDS, $params);
                if(curl_exec($this->session)){
                        return true;
                }
                else{
                        //* If varification mail can't be sent then delete the data
                        $deleteUser=new User();
                        $deleteUser->deletedata($email);
                }
                curl_close($this->session);
                echo "<script> location.href='index.php'; </script>";
        }
      
}
