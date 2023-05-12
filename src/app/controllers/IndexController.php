<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        
        $this->response->redirect("signup/index");
    }
    public function authorizeAction()
    {
        $client_id = "50fefd6df6e14bd88c20911cbc02ca04";

        $this->response->redirect("https://accounts.spotify.com/authorize?response_type=code&client_id=$client_id&scope=playlist-read-private&code_challenge_method=S256&redirect_uri=http://localhost:8080/display");
    
            
        }
}
