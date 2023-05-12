<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {

        // default
    }
    public function userAction()
    {
        session_start();

        if ($result['error']['status'] == 401 && $result['error']["message"] == "Unauthorized") {
            $token = $this->token->Gettoken();
            $_SESSION['token'] = $token;
            $url = "https://api.spotify.com/v1/me";
            $ch = curl_init();
            $header = [
                'Authorization: Bearer ' . $token
            ];

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = json_decode(curl_exec($ch), true);
            return $result;

        } else {
            $token = $_SESSION['token'];

            $url = "https://api.spotify.com/v1/me";
            $ch = curl_init();
            $header = [
                'Authorization: Bearer ' . $token
            ];

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = json_decode(curl_exec($ch), true);
            return $result;
        }
     
    }
}
