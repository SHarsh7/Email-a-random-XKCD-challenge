<?php
        class encdec{
                private  $ciphering = "AES-128-CTR";
                private  $options = 0;
                // private   $iv_length = openssl_cipher_iv_length($ciphering);
                private  $encryption_iv = "6868686868686868";
                private  $encryption_key = "EmailarandomXKCDchallenge";
                
                public function enc($code){
                        $encryption = openssl_encrypt($code, $this->ciphering,$this->encryption_key, $this->options, $this->encryption_iv);
                        return $encryption;
                        

                }
                public function dec($code){
                        $decryption = openssl_decrypt ($code, $this->ciphering,
			$this->encryption_key, $this->options, $this->encryption_iv);
                        return $decryption;
                }
        }