<?php


use Phalcon\Mvc\Controller;


class LoginController extends Controller
{
    public function indexAction()
    {
        // default action
    }
    public function loginAction()
    {
        session_start();

        $email = $this->request->getPost('email');
        if ($this->request->isPost()) {
            $user = Users::findFirst(array(
                'email = :email: and password = :password:', 'bind' =>
                array(
                    'email' => $this->request->getPost("email"), 'password' => $this->request->getPost("password")
                )
            ));

            if ($user) {

                if ($user->token == 0) {
                    $_SESSION['user'] = $user->id;
                  
                    $token = $this->token->Gettoken();
                    $_SESSION['token'] = $token;
                   
                    $u = new Users();
                    $u->assign(
                        $input = array(
                            "name" => $user->name,
                            "email" => $user->email,
                            "password" => $user->password,
                            "token" => $token,
                            "id" => $user->id
                        )
                    );
                    $data = $this->db->execute(
                        " UPDATE `users` SET `name`=\"$input[name]\",`email`=\"$input[email]\",
                    `password`=\"$input[password]\",`token`=\"$input[token]\" WHERE `id`=\"$input[id]\""

                    );
                    $this->response->redirect("index/authorize");
                }
            } else {
                echo "Wrong credentials";
                $this->response->redirect("login");
            }
        }
    }
    public function logoutAction()
    {
        $this->response->redirect("login/index");
    }
}
