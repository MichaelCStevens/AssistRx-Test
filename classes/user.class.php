<?php

date_default_timezone_set('America/New_York');

class user {

    public $id;
    public $login;
    public $sessionID;
    public $sessionValid;
    public $usersName = 'guest';

    function __construct() {

        $this->id = '0';
        $this->startSession();
        $this->checkSession();
        $this->processInput();
    }

    function __destruct() {
        
    }

    function processInput() {
        if (isset($_GET['cmd'])) {
            $cmd = $_GET['cmd'];
            switch ($cmd) {
                default:
                    break;
                case 'login':
                    $this->validateUser($_POST);
                    break;
                case 'forgot':
                    $this->userForgot($_POST);
                    break;
                case "logout":
                    if ($this->logOut()) {
                        header('Location: index.php');
                    }
                    break;
                case "register":
                    $this->userRegister($_POST);
                    break;
            }
        }
    }

    function getUser() {
        if ($this->id != 0) {
            //get user from databse, or if 0 return user as guest
            $query = DB::prepare('SELECT * FROM users
                                 WHERE id="' . $this->id . '"');
            $query->execute();
            $result = $query->fetch();
            $_SESSION['users_name'] = $result['name'];
            $_SESSION['users_email'] = $result['email'];
        }
    }

    public static function getName() {

        return $this->usersName;
    }

    function startSession() {
        session_start();

        if (isset($_SESSION['user_id'])) {
            $this->id = $_SESSION['user_id'];
        }
    }

    function validateSession($session) {
        
    }

    function checkSession() {
        //check if session set/ and if set see if valid and up to date
        if (!isset($_SESSION['id'])) {
            $this->storeSession();
        } else {

            $this->verifySessionID = $_SESSION['id'];
            // echo "session set";
            $query = DB::prepare('SELECT * FROM sessions
                                 WHERE session_id="' . $this->sessionID . '" AND session_ip="' . $_SERVER['REMOTE_ADDR'] . '"');
            $query->execute();
            $rows = $query->fetchAll();
            if (isset($rows)) {
                if (count($rows) > 0) {
                    $_SESSION['is_valid'] = 1;
                }
            }

            $this->storeSession();
        }
    }

    function storeSession() {
        //  echo "changed sessiontoken";
        $dateTime = date("Y-m-d H:i:s", strtotime("-5 minutes", strtotime(date("Y-m-d H:i:s"))));
        // echo $dateTime;
        $query = DB::prepare("DELETE FROM sessions WHERE `date_time_stamp` < '$dateTime' OR session_ip='" . $_SERVER['REMOTE_ADDR'] . "' ");
        $query->execute();
        if (isset($this->sessionID)) {
            $query = DB::prepare("DELETE FROM sessions WHERE session_id = '" . $this->sessionID . "'");
            $query->execute();
        }
        $this->sessionID = session_id() . '' . rand(1, 9999);
        $_SESSION['id'] = $this->sessionID;
        $query = DB::prepare("INSERT INTO sessions (`date_time_stamp`,`session_ip`,`session_user`, `session_id`) VALUES('" . date('Y-m-d H:i:s') . "', '" . $_SERVER['REMOTE_ADDR'] . "', '', '" . $this->sessionID . "') ");
        $query->execute();
    }

    public function getSessionID() {
        return $this->sessionID;
    }

    function validateUser($post) {
        // query mysql to authenticate user
        if (isset($post['user']) && isset($post['password'])) {
            //even tho we use pdo can never be too safe
            $password = md5(mysql_real_escape_string($post['password']));
            $username = mysql_real_escape_string($post['user']);
            //xss check, lets see if the request is coming form the same form
            if (!isset($post[$this->verifySessionID])) {
                header('Location: index.php?invalidToken=1');
                return false;
            }

            $query = DB::prepare('SELECT * FROM users
                                 WHERE password = ? AND username = ?');
            $query->execute(array($password, $username));
            $result = $query->fetch();

            if ($result) {
                // print_r($row);
                $this->id = $result['id'];
                $_SESSION['user_id'] = $this->id;
                $this->getUser();
                header('Location: index.php');
            } else {
                header('Location: index.php?invalid=1');
            }
            return true;
        }
        return false;
    }

    function userForgot($post) {
        // query mysql to authenticate user
        if (isset($post['user']) && isset($post['email'])) {
            //even tho we use pdo can never be too safe

            $username = mysql_real_escape_string($post['user']);
            $email = mysql_real_escape_string($post['email']);

            $query = DB::prepare('SELECT * FROM users
                                 WHERE username = ? AND email = ?');
            $query->execute(array($username, $email));
            $result = $query->fetch();

            if ($result) {
                echo "Your password hint is: " . $result['hint'];
                ;
            } else {
                echo "Username or email invalid";
            }
        }
        return false;
    }

    function userRegister($post) {
        if (isset($post['username']) && isset($post['email']) && isset($post['password']) && isset($post['password2'])) {
            if ($post['password'] == $post['password2']) {
                //    $checkuser = $this->checkUser($post['username'], $post['email']);
                $query = DB::prepare("SELECT * FROM users WHERE username = :username OR email = :email");
                $query->bindParam(':username', $post['username']);
                $query->bindParam(':email', $post['email']);

                $query->execute();
                $rows = $query->rowCount();
                if (isset($rows)) {
                    if ($rows > 0) {
                        $result = $query->fetchAll();
                        // print_r($result);
                        echo 'Username or email is already in use';

                        return false;
                    }
                }

                $password = md5($post['password']);
                $query = DB::prepare("INSERT INTO users (`username`,`password`,`email`, `name`, `hint`) VALUES(:username, :password, :email, :name, :hint) ");

                $query->bindParam(':username', $post['username']);
                $query->bindParam(':password', $password);
                $query->bindParam(':email', $post['email']);
                $query->bindParam(':name', $post['name']);
                $query->bindParam(':hint', $post['hint']);

                $query->execute();
                echo "Successfully registered, you may <a href='javascript:void(0);' onclick='login();jQuery(this).parent().parent().slideUp();'>login now</a>";
            }
        } else {
            echo "Please fill out all the fields";
        }
    }

    function logOut() {
        unset($_SESSION['user_id']);
        unset($_SESSION['users_name']);
        $query = DB::prepare("DELETE FROM sessions WHERE session_id='$this->sessionID'");
        $query->execute();

        return true;
    }

}

?>