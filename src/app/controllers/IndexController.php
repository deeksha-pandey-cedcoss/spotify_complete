<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        // default action
    }
    public function searchAction()
    {
        session_start();
        $serach_name = $_POST['search1'];

        $serach_param = [];

        if (isset($_POST)) {
            if (isset($_POST['artist'])) {
                array_push($serach_param, $_POST['artist']);
            }
            if (isset($_POST['playlist'])) {
                array_push($serach_param, $_POST['playlist']);
            }
            if (isset($_POST['episode'])) {
                array_push($serach_param, $_POST['episode']);
            }
            if (isset($_POST['album'])) {
                array_push($serach_param, $_POST['album']);
            }
            if (isset($_POST['show'])) {
                array_push($serach_param, $_POST['show']);
            }
            if (isset($_POST['track'])) {
                array_push($serach_param, $_POST['track']);
            }
        }
        $new = str_replace(" ", "%20", $serach_name);
        $type = implode("%2C", $serach_param);
        $token = $this->token->Gettoken();
        $_SESSION['token']=$token;
        // print_r($token);die;

        $data= $this->data->Getdata($new, $type);

        
        

        $this->view->d=$data;
  
    }
   
}
