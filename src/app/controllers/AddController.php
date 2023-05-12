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
        session_start();
        $type = $_GET['type'];
        $singer = $_GET['singer'];
        $id = $_GET['id'];
        $user_id = $_SESSION['user'];


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

            $this->response->redirect("add/display");
        } else {
            echo "not added";
        }
    }
    public function displayAction()
    {
        session_start();
        $token = $_SESSION['token'];
        $uid=$_SESSION['user'];
        $product = $this->db->fetchAll(
            "SELECT * FROM playlists where `user_id` = $uid",
            \Phalcon\Db\Enum::FETCH_ASSOC
        );
        foreach ($product as $key => $value) {

            $sid = $value['spotify_id'];
            $_SESSION['trackid'] = $sid;

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

            if ($img == "") {
                $img = "https://i.scdn.co/image/ab6761610000e5eb92103a69abd9fbf76d866374";
            } else {
                $img = $result['images'][0]['url'];
            }
            print_r($value['type']);
            $view .= "<div class='card col-3 p-3 border  border-5 border-white bg-secondary text-light mb-1'
                     style='width: 18rem;height:330px;border-radius:10px; '>
            <img class='card-img-top' src=' " . $img . " ' alt='Card image cap' height=180px>
            <div class='card-body'>
              <h4 class='card-title'>$value[singer]</h4>";
            $view .=   $this->tag->linkTO(["add/delete/?id=" . $value['id'], "Delete", "class" => "btn btn-info"]);
            $view .=  "
            </div>
          </div>
          ";
            echo "</div>";
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
