<?php

use PHPUnit\Framework\TestCase;

class sendGridApiTest extends TestCase
{
        public function testThatcanWesendVarificationmail()
        {
                $sendVarEmail = new  \App\sendGridApi;
                $email = "";
                $body = "hi";
                $subject = "testing";
                //* Set api key before testing
                $this->assertTrue($sendVarEmail->sendVarificationMail($email, $body, $subject));
        }
}
