<?php

class AuthController extends Controller {

    public function index()
    {
        $this->login();
        $this->setNoLayout(1);
        return 'auth/index';
    }

    public function login()
    {
        if (false !== Auth::checkLoginActive()){

            $this->applyRole();
        }

        if (isset($_POST['login']) && $_POST['login'] != null
            && isset($_POST['pass']) && $_POST['pass']) {
        
            $posts['login']  = htmlentities($_POST['login']);
            $posts['pass']  = htmlentities($_POST['pass']);
            
            $errors = [
                'login'=>'',
                'pass'=>''
            ];

            if (empty($posts['login'])) {
                $errors['login'] = "Не заполнено поле \"login\"";
            }
            if (empty($posts['pass'])) {
                $errors['pass'] = "Не заполнено поле \"password\"";
            }
            if (!empty($errors['login']) or !empty($errors['pass'])){
                Session::setFlash($errors['login'] . '<br>' . $errors['pass']);
            } else {
                if (false !== Auth::check($posts['login'], $posts['pass'])) {
                    Auth::setCookie($posts['login']);
                    $this->applyRole($posts['login']);
                } else {
                    $this->create_user_profile($posts['login'], $posts['pass']);
                }

            }
        }

    }

    public function logout()
    {
        Auth::unsetCookieAuth();
        Router::redirect('news/index');
        exit;
    }

    public function applyRole($login = null)
    {
        $role = Auth::getRole($login);
        if ($role == 'admin') {
            Router::redirect('news/index');
            exit;
        } elseif ($role == 'user') {
            Router::redirect('news/index');
            exit;
        }else {
            Session::setFlash('У вас нет привилегий');
            $this->logout();
            exit;
        }
    }

    public function create_user_profile($login = null, $pass = null)
    {

        if (isset($_POST['registration']) && isset($login) && isset($pass)) {
            $this->setNoLayout(true);
            $user = Users::find_by_login_mail($login);
            if (isset($user) && $user->login_mail == $login) {
                Session::setFlash('Такой пользователь существует');
                Router::redirect('auth/index');
                exit;
            }
            $user = new Users;
            $user->login_mail = $login;
            $user->pass = crypt($pass, 'mySolt');
            $user->role = 'user';
            $user->active = 1;

            $user->save();

            Auth::setCookie($login);
        }

        if (Auth::checkLoginActive() !== false) {
            Router::redirect('profile/index');
        }

        Router::redirect('auth/index');
    }
}