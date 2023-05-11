<?php

use Phalcon\Mvc\Controller;

session_start();


// defalut controller view
class AddController extends Controller
{
    public function indexAction()
    {
        // default action
    }

    public function addAction()
    {


        $type = $_GET['type'];
        $singer = $_GET['singer'];
        $id = $_GET['id'];
        $user_id = 1;
        echo $type;
        echo $singer;
        echo $id;

        $play = new Playlists();

        $input = array(
            'user_id' => $user_id,
            'type' => $type,
            'singer' => $singer,
            'spotify_id' => $id
        );

        $play->assign(
            $input,
            [
                'user_id',
                'type',
                'singer',
                'spotify_id'

            ]
        );

        $success = $play->save();
        if ($success) {
            echo "added successfully";
        } else {
            echo "not added";
        }
    }
    public function displayAction()
    {

        $token = $_SESSION['token'];

        $product = $this->db->fetchAll(
            "SELECT * FROM playlists",
            \Phalcon\Db\Enum::FETCH_ASSOC
        );

        foreach ($product as $key => $value) {

            $sid = $value['spotify_id'];

            $ch = curl_init();


            $url = "https://api.spotify.com/v1/$value[type]/$sid";

            $header = [
                'Authorization: Bearer ' . $token
            ];
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = json_decode(curl_exec($ch), true);

            $img = $result['images'][0]['url'];
            print_r($value['type']);
            $view .= "<div class='card col-3 p-3 border  border-5 border-white bg-secondary text-light mb-1'
                     style='width: 18rem;height:330px;border-radius:10px; '>
            <img class='card-img-top' src=' " . $img . " ' alt='Card image cap' height=180px>
            <div class='card-body'>
              <h6 class='card-title'>$value[name]</h6>";
            $view .=   $this->tag->linkTO(["add/delete/?id=" . $value['id'], "Delete", "class" => "btn btn-info"]);
            $view .=  "
            </div>
          </div>
          ";
        }
        $this->view->view = $view;
    }
    public function deleteAction()
    {

        $id = $_GET['id'];
        $playlists = Playlists::findFirst($id);
        $playlists->delete();
        $this->response->redirect('add/display');
    }
}
