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
                        'from'      => 'noobbot12367@gmail.com',
                        'fromname'  => 'XKCD',
                        'subject'   => $subject,
                        'html'      => $body,
                        'x-smtpapi' => json_encode($this->js),
                     
                );
                curl_setopt($this->session, CURLOPT_POSTFIELDS, $params);
                $response = curl_exec($this->session);
                curl_close($this->session);
                if (strpos($response, 'success')) {
                        return true;
                } else {
                        //* If varification mail can't be sent then delete the data
                        $deleteUser = new User();
                        $deleteUser->deletedata($email);
                }
        }
        public function comicSender($email, $body, $subject, $file)
        {
                // $fileName = 'comic.png';
                $fileName = basename($file);
                $file = file_get_contents($file);
               
                // $filePath = dirname(__FILE__);
                $params = array(
                        'to'        => $email,
                        'from'      => 'noobbot12367@gmail.com',
                        'fromname'  => 'XKCD',
                        'subject'   => $subject,
                        'html'      => $body,
                        'x-smtpapi' => json_encode($this->js),
                        // 'files[' . $fileName . ']' => '@' . $filePath . '/' . $fileName,
                        'attachments' =>array(
                                'content' =>'BASE64_ENCODED_CONTENT',
                                'type'=>'img/png',
                                // 'filename'=>$fileName,
                                 'files['.$fileName.']' => '@'.$file.'/'.$fileName,
                        ),
                        // 'type'=> 'image/png',
                         'files['.$fileName.']' => '@'.$file.'/'.$fileName,
                       
                );
                curl_setopt($this->session, CURLOPT_POSTFIELDS, $params);
                $response = curl_exec($this->session);
                curl_close($this->session);
                unlink($file);
                return $response ? true : false;
        }
}
