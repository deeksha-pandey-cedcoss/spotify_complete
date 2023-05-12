<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
    public function indexAction()
    {
        //    default action

    }
    public function registerAction()
    {
        $user = new Users();
        $user->assign(
            $input = array(

                "name" => $this->escaper->escapeHtml($this->request->getPost('name')),
                "email" => $this->escaper->escapeHtml($this->request->getPost('email')),
                "password" => $this->escaper->escapeHtml($this->request->getPost('password')),
                "token" => 0,

            )
        );
        $success = $user->save();
        if ($success) {
            $this->response->redirect("login/index");
        } else {
            echo "Not registered successfully";
            die;
        }
    }
}
