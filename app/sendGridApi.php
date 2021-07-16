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
        }
        public function sendVarificationMail($email, $body, $subject)
        {
                $sendgrid_apikey = getenv('sendgrid_apikey');
                $this->session = curl_init($this->url);
                curl_setopt($this->session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
                curl_setopt($this->session, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $sendgrid_apikey));
                curl_setopt($this->session, CURLOPT_POST, true);
                curl_setopt($this->session, CURLOPT_HEADER, false);
                curl_setopt($this->session, CURLOPT_RETURNTRANSFER, true);
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
                $sendgrid_apikey = getenv('sendgrid_apikey');
                $fileName = basename($file);
                $file = file_get_contents($file);


                // $params = array(
                //         'to'        => $email,
                //         'from'      => 'noobbot12367@gmail.com',
                //         'fromname'  => 'XKCD',
                //         'subject'   => $subject,
                //         'html'      => $body,
                //         'x-smtpapi' => json_encode($js),
                //         // 'files[' . $fileName . ']' => '@' . $filePath . '/' . $fileName,
                //         'attachments' => array(
                //                 'content' => 'BASE64_ENCODED_CONTENT',
                //                 'type' => 'img/png',
                //                 // 'filename'=>$fileName,
                //                 'files[' . $fileName . ']' => '@' . $file . '/' . $fileName,
                //         ),
                //         // 'type'=> 'image/png',
                //         'files[' . $fileName . ']' => '@' . $file . '/' . $fileName,

                // );
                // curl_setopt($this->session, CURLOPT_POSTFIELDS, $params);
                // $response = curl_exec($this->session);
                // curl_close($this->session);
                // return $response ? true : false;
                $headers = array(
                        "authorization:'$sendgrid_apikey'",
                        'Content-Type: application/json'
                );
                $data = array(
                        "personalizations" => array(
                                array(
                                        "to" => array(
                                                array(
                                                        "email" => $email
                                                )
                                        )
                                )
                                                ),
                        "from"=>array(
                                "email"=>"noobbot12367@gmail.com"
                        ),
                        "subject"=>$subject,
                        "content"=>array(
                                array(
                                        "type"=>"text/html",
                                        "value"=> $body
                                )
                        )
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://api.sendgrid.com/v3/mail/send');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $response = curl_exec($ch);
                curl_close($ch);

                unlink($file);
        }
}
