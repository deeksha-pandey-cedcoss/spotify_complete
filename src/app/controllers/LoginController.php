<?php

use Phalcon\Mvc\Controller;
// login controller
class LoginController extends Controller
{
    public function indexAction()
    {
        // default login view
    }
    // login action page
    public function loginAction()
    {
        $email = $this->request->getPost("email");
        $success = Users::findFirst(array("email = ?0", "bind" => array($email)));
        if ($success) {
            $this->view->message = "LOGIN SUCCESSFULLY";
        } else {
            $this->view->message = "Not Login succesfully ";
        }
    }
}
