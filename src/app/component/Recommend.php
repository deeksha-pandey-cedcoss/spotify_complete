<?

namespace recommend;

use Phalcon\Di\Injectable;

class Recommend extends Injectable
{

    public function getre()
    {
        session_start();
        $token = $this->token->Gettoken();
        $_SESSION['token'] = $token;
        $ch = curl_init();
        $id = $_SESSION['trackid'];
        $url = "https://api.spotify.com/v1/recommendations?seed_artists=2FKWNmZWDBZR4dE5KX4plR";

        $header = [
            'Authorization: Bearer ' . $token
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = json_decode(curl_exec($ch), true);

        return $result;
    }
}
