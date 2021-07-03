<?php

use PHPUnit\Framework\TestCase;

class userTest extends TestCase
{

        private $email = "hehe@gmail.com";

        //*TEST 0
        public function testThatcanWeConnectToDb()
        {
                $user = new \App\Models\User;
                $this->assertNotTrue($user);
        }

        //*TEST 1
        public function testThatcanWeInsertData()
        {
                $user = new \App\Models\User;
                $code = "1234$^";
                $this->assertTrue($user->insertdata($this->email, $code));
        }
        //*TEST 2
        public function testThatcanWeUpdateData()
        {
                $user = new \App\Models\User;
                $this->assertTrue($user->updatedata($this->email));
        }
        //*TEST 3
        public function testThatcanWeFetchData()
        {
                $user = new \App\Models\User;
                $result = $user->fetchdata($this->email);
                $this->assertTrue(is_object($result));
        }
        //*TEST 4
        public function testThatcanWeDeleteData()
        {
                $user = new \App\Models\User;
                $user->deletedata($this->email);
                $result = $user->fetchdata($this->email);
                $this->assertFalse(is_string($result));
        }
        //*TEST 5
        public function testThatcanWeGenerateTheActivationCode()
        {
                $user = new \App\Models\User;
                $code = $user->codeGen();
                $this->assertTrue(is_string($code));
        }
        //*TEST 6
        public function testThatcanWeSetTheEmailInDb()
        {
                $user = new \App\Models\User;
                $this->assertTrue($user->reg_user($this->email));
        }
}
