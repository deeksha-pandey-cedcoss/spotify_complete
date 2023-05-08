<?php

use Phalcon\Mvc\Controller;
// defalut controller view
class IndexController extends Controller
{
    public function indexAction()
    {

        $url = "https://www.hindustantimes.com/feeds/rss/astrology/rssfeed.xml";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        $d = curl_exec($ch);
        $xml = simplexml_load_string($d);

        $this->view->xmldata = $xml;

        $json = json_encode($xml);
        $array = json_decode($json, true);
        $this->view->xmlarray = $array;

        curl_close($ch);

        $u = "http://api.open-notify.org/iss-now.json";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $u);

        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);

        $this->view->data = $result;

        $this->view->d = $result['iss_position'];
    }
}
