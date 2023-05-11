<?php

namespace artist;

use Phalcon\Di\Injectable;

class Artist extends Injectable
{

    public function getartist($id)
    {
        session_start();
        $ch = curl_init();
        $token =$_SESSION['token'];
        // print_r($id);die;
        // 
        $url = "https://api.spotify.com/v1/artists/$id";
        

        $header = [
            'Authorization: Bearer ' . $token
        ];
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch), true);
        
        print_r($result);
        return $result;
       
        curl_close($ch);
    }
}
