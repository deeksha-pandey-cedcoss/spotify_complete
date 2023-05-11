<?

namespace data;

use Phalcon\Di\Injectable;

class Data extends Injectable
{

    public function Getdata($search, $type)
    {
        $token=$_SESSION['token'];
        $ch = curl_init();
        $url = "https://api.spotify.com/v1/search/?q=$search&&type=$type";
        $header = [
            'Authorization: Bearer ' . $token
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch), true);


        return $result;
        curl_close($ch);
    }
}
