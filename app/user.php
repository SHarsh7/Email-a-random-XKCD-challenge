<?php

namespace app;

use mysqli;

class User
{

        public $db;

        public function __construct()
        {

                $DB_SERVER='sql6.freemysqlhosting.net';
                $DB_USERNAME='sql6425905';
                $DB_PASSWORD='VW33MZZSpT';
                $DB_DATABASE='ssql6425905';
                $this->db =  new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD,$DB_DATABASE);
                if($this->db){

                        echo "connect to db";
                }


                if (mysqli_connect_errno()) {
                        echo 'Error: Could not connect to database.';
                        exit;
                }
        }
        public function codeGen()
        {
                $code = uniqid();
                return $code;
        }
        public function fetchdata($email)
        {
                $fetch_query = $this->db->prepare('SELECT `id`,`activecode`,`emailstatus` FROM `auth` WHERE `email` =?');
                if ($fetch_query) {
                        $fetch_query->bind_param('s', $email);
                        $fetch_query->execute();
                        $fetch_result = $fetch_query->get_result();
                        return $fetch_result;
                }
        }
        public function insertdata($email, $code)
        {
                echo "in insert data";
                $insert_query = $this->db->prepare('INSERT INTO `auth` (`email`, `activecode`) VALUES (?,?)');
                if ($insert_query) {
                        $insert_query->bind_param('ss', $email, $code);
                        $insert_result = $insert_query->execute();
                        var_dump($insert_result);
                        var_dump($this->fetchdata($email));

                        return $insert_result;
                        
                }
                else{
                        echo "insertion failed";
                }
        }
        public function deletedata($email)
        {
                $delete_query = $this->db->prepare('DELETE FROM `auth` WHERE `email` = ? ');
                if ($delete_query) {
                        $delete_query->bind_param('s', $email);
                        $delete_query->execute();
                }
        }
        public function updatedata($code)
        {

                $update_query = $this->db->prepare("UPDATE auth SET  emailstatus = 'verified' , userstatus='subscribed' WHERE activecode = ?");
                if ($update_query) {
                        $update_query->bind_param('s', $code);
                        $update_result = $update_query->execute();
                        return $update_result;
                }
        }
        // for registration process 
        public function reg_user($email)
        {
                //checking if the username or email is available in db
                echo "in reg user";
                $fetch_result = $this->fetchdata($email);
                $count_row = $fetch_result->num_rows;
                var_dump($count_row);
                //if the username is not in db then insert to the table
                if ($count_row == 0) {
                        echo "in if cond";
                        $code = $this->codeGen();
                        if($code){
                                echo "code";
                        }
                        $result = $this->insertdata($email, $code);
                        if($result){
                                echo "result";
                        }
                        return $result;
                } else {
                        return false;
                }
        }
        public function __destruct() 
        {
                $this->db-> close();
         }
}
