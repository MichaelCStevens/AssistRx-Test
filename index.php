<?php
error_reporting(E_ALL);
//set db connection info in db class
require_once('classes/user.class.php');
require_once('classes/db.class.php');
if (isset($_GET['invalid'])) {
    if ($_GET['invalid'] == 1) {
        $message = "You entered an incorrect Username/Password";
    }
}
if (isset($_GET['invalidToken'])) {
    if ($_GET['invalidToken'] == 1) {
        $message = "Invalid Token, Please try again.";
    }
}

class home extends user {

    public $page;
    public $pageContent;
    public $pageTitle;
    private $siteName;

    function __construct() {
        $this->siteName = 'Assist RX Test by Michael Stevens';
        $this->user = new user();
        if ($this->user->id == '0') {
            $this->page = 'login';
        } else {
            $this->page = 'account';
        }
        $this->getPageContent();
    }

    public function getPageContent() {

        switch ($this->page) {

            default:
                ob_start();
                include "views/login.view.php";
                $this->pageContent = ob_get_contents();
                ob_end_clean();
                break;
            case "login":
                $this->pageTitle = "Welcome, please login - $this->siteName";
                ob_start();
                include "views/login.view.php";
                $this->pageContent = ob_get_contents();
                ob_end_clean();
                break;
            case "account":
                $this->pageTitle = "Welcome Back - $this->siteName";
                ob_start();
                include "views/account.view.php";
                $this->pageContent = ob_get_contents();
                ob_end_clean();
                break;
        }
    }

    public function getPage() {
        return $this->page;
    }

    public function getSiteName() {
        return $this->siteName;
    }

    function validateUser($password) {
        // query mysql to authenticate user
        return false;
    }

}

$index = new home();
?>
<html>
    <head>
        <title><?php echo $index->pageTitle; ?>   </title>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/layout.css"/>
        <script type="text/javascript">
            jQuery(document).ready(function() {

            });
            function forgotPassword(){
                jQuery('.login-form, .register-form').slideUp();
                jQuery('.forgot-pass-form').slideDown();
            }
            function login(){
                jQuery('.forgot-pass-form, .register-form').slideUp();
                jQuery('.login-form').slideDown();
                
            }
            function register(){
                jQuery('.login-form, .forgot-pass-form').slideUp();
                jQuery('.register-form').slideDown();
                
            }
            function getHint(){
                jQuery('.pop').remove();
                var email=jQuery('.email').val();
                var user=jQuery('.user').val();
                jQuery.post("ajax.php?cmd=forgot",  { email:email, user: user },
                function(data) {
                    console.log("Data Loaded: " + data);
                    var html="<div class='pop'>";
                    html+="<div><a onclick='jQuery(this).parent().parent().slideUp().remove()' href='#'> Close &times;</a> </div>";
                    html+="<div class='text'>"+data+"</div>";
                    html+="</div>";
                    jQuery('body').prepend(html); 
                    jQuery('.pop').slideDown('slow');
         
                });
                          
            }
            
            function registerForm(){
              
                jQuery('.pop').remove();
                var email=jQuery('.emailR').val();
                var username=jQuery('.userR').val();
                var name=jQuery('.nameR').val();
                var password=jQuery('.passwordR').val();
                var password2=jQuery('.password2R').val();
                 var hint=jQuery('.hintR').val();
                var x=1;
                if(username==''){
                    alert('Please enter a username');
                    var x=0;
                }
                if(email==''){
                    alert('Please Enter your email address');
                    var x=0;
                }
                if(password==''){
                    alert('Please enter your password');
                    var x=0;
                }
                if(password2==''){
                    alert('Please confirm your password');
                    var x=0;
                }
                if(password != password2){
                    alert('Passwords do not match');
                    var x=0;
                }
                    if(hint==''){
                    alert('Pleasew enter a password hint');
                    var x=0;
                }
                if(x==1){
                    jQuery.post("ajax.php?cmd=register",  { username: username,  password:password, password2:password2, email:email,  name:name, hint:hint },
                    function(data) {
                        console.log("Data Loaded: " + data);
                        var html="<div class='pop'>";
                        html+="<div><a onclick='jQuery(this).parent().parent().slideUp().remove()' href='#'> Close &times;</a> </div>";
                        html+="<div class='text'>"+data+"</div>";
                        html+="</div>";
                        jQuery('body').prepend(html); 
                        jQuery('.pop').slideDown('slow');
         
                    });
                }
           
            }
        </script>
    </head>
    <body>
        <div id="wrapper">
            <div class="row-fluid">
                <div class="span12">  
                    <h1>Login Script for <?php echo $index->getSiteName(); ?></h1>
                    <h2>Features</h2>
                    <div class="alert alert-info">
                        <ul>
                            <li>OOP PHP & PDO MySQL</li>
                            <li>Bootstrap CSS Style</li>
                            <li>User Sessions With XSS blocking tokens ()</li>
                            <li>Login</li>
                            <li>Ajax password hint</li> 
                            <li>Improvements with more time: </li>
                            <li>Server side validation on registration </li>
                            <li>Forgot Password Email Token with AJAX</li>
                            <li>Check session with browser agent and ip</li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <?php if (isset($message)) { ?>
                        <div class="alert alert-warning">
                            <?php echo $message ?>
                        </div>
                    <?php } ?>

                    <?php echo $index->pageContent; ?>
                </div>
            </div>
        </div>
    </body>
</html>