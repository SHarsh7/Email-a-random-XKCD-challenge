<?php

namespace app;

use mysqli;

class User
{

        public $db;

        public function __construct()
        {
                $this->db = new mysqli(getenv('DB_SERVER'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_DATABASE'));

                var_dump($this->db);
                var_dump(getenv('DB_SERVER'));
                var_dump(getenv('DB_USERNAME'));
                var_dump(getenv('DB_PASSWORD'));
                var_dump(getenv('DB_DATABASE'));

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
                $insert_query = $this->db->prepare('INSERT INTO `auth` (`email`, `activecode`) VALUES (?,?)');
                if ($insert_query) {
                        $insert_query->bind_param('ss', $email, $code);
                        $insert_result = $insert_query->execute();
                        return $insert_result;
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

                $fetch_result = $this->fetchdata($email);
                $count_row = $fetch_result->num_rows;

                //if the username is not in db then insert to the table
                if ($count_row == 0) {
                        $code = $this->codeGen();
                        $result = $this->insertdata($email, $code);
                        return $result;
                } else {
                        return false;
                }
        }
}
