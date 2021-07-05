<?php 
namespace app;
class encdec{
        private $ciphering = "AES-128-CTR";
        private $options = 0;
        private $iv = '6986986986986986';
        private $key = "HEHE";
        public function encrypt($data)
        {
                $data = openssl_encrypt($data, $this->ciphering,
		$this->key, $this->options, $this->iv);
                return $data;
                
        }
        public function decrypt($data)
        {
                $data=openssl_decrypt ($data, $this->ciphering,
		$this->key, $this->options, $this->iv);
                return $data;
                
        }
} 