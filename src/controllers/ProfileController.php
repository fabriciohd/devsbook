<?php
namespace src\controllers;

use \core\Controller;
use DateTime;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;
use src\models\User;
use Nette\Utils\Image;

class ProfileController extends Controller {

    private $loggedUser;

    public function __construct() {
        $this->loggedUser = UserHandler::checkLogin();
        if ($this->loggedUser === false) {
            $this->redirect('/login');
        }
    }

    public function index($args = []) {
        $page = intval(filter_input(INPUT_GET, 'page'));

        //Detectando o usuario acessado
        $id = $this->loggedUser->id;
        if (!empty($args['id'])) {
            $id = $args['id'];
        }

        //Pegando informações do usuario
        $user = UserHandler::getUser($id, true);
        if (!$user) {
            $this->redirect('/');
        }
        $dateFrom = new \DateTime($user->birthdate);
        $dateTo = new \DateTime('today');
        $user->ageYears = $dateFrom->diff($dateTo)->y;

        //Pegando o feed do usuario
        $feed = PostHandler::getUserFeed(
            $id,
            $page,
            $this->loggedUser->id
        );
        
        //Verificar se eu sigo o usuario
        $isFollowing = false;
        if($user->id != $this->loggedUser->id) {
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
        }

        $this->render('profile', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'feed' => $feed,
            'isFollowing' => $isFollowing
        ]);    
    }

    public function follow($args) {
        $to = intval($args['id']);        

        if (UserHandler::idExists($to)) {
            if (UserHandler::isFollowing($this->loggedUser->id, $to)) {
                UserHandler::unfollow($this->loggedUser->id, $to);
            } else {
                UserHandler::follow($this->loggedUser->id, $to);
            }
        }

        $this->redirect('/perfil/'.$to);

    }

    public function friends($args = []) {
        //Detectando o usuario acessado
        $id = $this->loggedUser->id;
        if (!empty($args['id'])) {
            $id = $args['id'];
        }

        //Pegando informações do usuario
        $user = UserHandler::getUser($id, true);
        if (!$user) {
            $this->redirect('/');
        }
        $dateFrom = new \DateTime($user->birthdate);
        $dateTo = new \DateTime('today');
        $user->ageYears = $dateFrom->diff($dateTo)->y;

        //Verificar se eu sigo o usuario
        $isFollowing = false;
        if($user->id != $this->loggedUser->id) {
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
        }

        $this->render('profile_friends', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,            
            'isFollowing' => $isFollowing
        ]);
    }

    public function photos($args = []) {
        //Detectando o usuario acessado
        $id = $this->loggedUser->id;
        if (!empty($args['id'])) {
            $id = $args['id'];
        }

        //Pegando informações do usuario
        $user = UserHandler::getUser($id, true);
        if (!$user) {
            $this->redirect('/');
        }
        $dateFrom = new \DateTime($user->birthdate);
        $dateTo = new \DateTime('today');
        $user->ageYears = $dateFrom->diff($dateTo)->y;

        //Verificar se eu sigo o usuario
        $isFollowing = false;
        if($user->id != $this->loggedUser->id) {
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
        }

        $this->render('profile_photos', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,            
            'isFollowing' => $isFollowing
        ]);
    }

    public function config() {
        $flash = '';
        if (!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }
        $this->render('profile_config', [
            'loggedUser' => $this->loggedUser, 
            'flash' => $flash           
        ]);
    }

    public function configAction() {
        $photo = $_FILES['photo'];
        $cover = $_FILES['cover'];        
        $name = filter_input(INPUT_POST, 'name');
        $birthdate = filter_input(INPUT_POST, 'birthdate');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $city = filter_input(INPUT_POST, 'city');
        $work = filter_input(INPUT_POST, 'work');
        $password = filter_input(INPUT_POST, 'password');
        $confirmPassword = filter_input(INPUT_POST, 'confirmPassword');
        

        if ($name && $birthdate && $email) {
            
            //autentica a data de nascimento
            $birthdate = explode('/', $birthdate);
            if (count($birthdate) != 3) {
                $_SESSION['flash'] = 'Data de nascimento inválida.';
                $this->redirect('/config');
            }
            $birthdate = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];           
            if (strtotime($birthdate) === false) {
                $_SESSION['flash'] = 'Data de nascimento inválida.';
                $this->redirect('/config');
            }            
            if ($email != $this->loggedUser->email && UserHandler::emailExists($email)) {
                $_SESSION['flash'] = 'Este e-mail já está cadastrado.';
                $this->redirect('/config');
            }

            UserHandler::updateUser($name, $birthdate, $email, $city, $work, $this->loggedUser->email);

            if ($password && $confirmPassword) {
                if ($password == $confirmPassword) {
                    UserHandler::updatePassword($password, $email);
                }
            }
            
            if (!empty($photo['type'])) {
                if ($photo['type'] == 'image/jpeg' || $photo['type'] == 'image/png') {
                    $photoName = md5(rand(0, 9999999).time()).'.jpg';
                    $photoDir = '../public/media/avatars/'.$photoName;                    
                    
                    move_uploaded_file($_FILES['photo']['tmp_name'], $photoDir);

                    $image = Image::fromFile($photoDir);
                    $image->resize(50, 50, Image::EXACT);
                    $image->save($photoDir);

                    UserHandler::updatePhoto($photoName, $email);
                    
                } else {
                    $_SESSION['flash'] = 'Verifique se sua imagem é valida(png/jpeg).';
                    $this->redirect('/config');
                }
            }

            if (!empty($cover['type'])) {
                if ($cover['type'] == 'image/jpeg' || $cover['type'] == 'image/png') {
                    $photoName = md5(rand(0, 9999999).time()).'.jpg';
                    $photoDir = '../public/media/covers/'.$photoName;                    
                    
                    move_uploaded_file($_FILES['cover']['tmp_name'], $photoDir);

                    $image = Image::fromFile($photoDir);
                    $image->resize(840, 250, Image::EXACT);
                    $image->save($photoDir);

                    UserHandler::updateCover($photoName, $email);
                    
                } else {
                    $_SESSION['flash'] = 'Verifique se sua imagem é valida(png/jpeg).';
                    $this->redirect('/config');
                }
            }

            UserHandler::checkLogin();

        } else {
            $_SESSION['flash'] = 'Verifique se os campos: nome, nascimento e email estão preenchidos corretamente!';
                $this->redirect('/config');
        }

        $this->redirect('/config');
    }


}
