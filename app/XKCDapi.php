<?php

namespace app;

class XKCDapi
{

        public function fetchComic()
        {
                $number = rand(1, 1000);
                $url = "https://xkcd.com/$number/info.0.json";

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $headers = array(
                        'Origin: https:https://cors-anywhere.herokuapp.com',
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                $resp = curl_exec($curl);
                $data = json_decode($resp);
                curl_close($curl);
                var_dump($resp);
                $imgAttch = $data->img;
                $text = $data->transcript;
                $title=$data->title;
                $altTxt=$data->alt;
                return [$imgAttch, $text,$title,$altTxt];
        }
}
