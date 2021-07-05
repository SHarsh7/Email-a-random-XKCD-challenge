<?php 
        use PHPUnit\Framework\TestCase;
        class  xkcdApiTest extends TestCase{

                public function testThatWhetherApiReturnsData(){
                        $comic =new \App\XKCDapi;
                        $data=$comic->fetchComic();
                        $this->assertTrue(is_array($data));
                }
        }