<?php

namespace app;

require_once dirname(__FILE__) . '/user.php';
class sendGridApi
{
        private $session, $name = "XKCD";
        public function __construct()
        {
                $sendgrid_apikey = getenv('sendgrid_apikey');
                $headers = array(
                        "Authorization: Bearer $sendgrid_apikey",
                        'Content-Type: application/json'
                );
                $this->session = curl_init();
                curl_setopt($this->session, CURLOPT_URL, "https://api.sendgrid.com/v3/mail/send");
                curl_setopt($this->session, CURLOPT_POST, 1);
                curl_setopt($this->session, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($this->session, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($this->session, CURLOPT_RETURNTRANSFER, true);
        }
        public function sendVarificationMail($email, $body, $subject)
        {


                $data = array(
                        "personalizations" => array(
                                array(
                                        "to" => array(
                                                array(
                                                        "email" => $email,
                                                        "name" => $this->name
                                                )
                                        )
                                )
                        ),
                        "from" => array(
                                "email" => "noobbot12367@gmail.com",
                                'fromname'  => 'XKCD'
                        ),
                        "subject" => $subject,
                        "content" => array(
                                array(
                                        "type" => "text/html",
                                        "value" => $body
                                )
                        ),
                );
                curl_setopt($this->session, CURLOPT_POSTFIELDS, json_encode($data));

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
                $content = base64_encode(file_get_contents($file));
                $data = array(
                        "personalizations" => array(
                                array(
                                        "to" => array(
                                                array(
                                                        "email" => $email,
                                                        "name" => $this->name
                                                )
                                        )
                                )
                        ),
                        "from" => array(
                                "email" => "noobbot12367@gmail.com"
                        ),
                        "subject" => $subject,
                        "content" => array(
                                array(
                                        "type" => "text/html",
                                        "value" => $body
                                )
                        ),
                        "attachments" => array(
                                array(
                                        "content" => $content,
                                        "type" => "text/plain",
                                        "filename" => basename($file)
                                )
                        )
                );
                curl_setopt($this->session, CURLOPT_POSTFIELDS, json_encode($data));



                $response = curl_exec($this->session);
                curl_close($this->session);
                unlink($file);
                return $response ? true : false;
        }
}
