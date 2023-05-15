<?

namespace token;

use Phalcon\Di\Injectable;

class Token extends Injectable
{

    public function Gettoken()
    {
        $client_id = "50fefd6df6e14bd88c20911cbc02ca04";
        $client_secret = "c71dec9d46b24828821527148f4e7367";

        $url = "https://accounts.spotify.com/api/token";
        $ch = curl_init();
        $header = [
            "Content-Type: application/x-www-form-urlencoded",
        ];
        $param = http_build_query([
            "grant_type" => "client_credentials",
            "client_id" => $client_id,
            "client_secret" => $client_secret,
        ]);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $result = json_decode(curl_exec($ch), true);
        
        
        curl_close($ch);
        return $result['access_token'];
    }
}
