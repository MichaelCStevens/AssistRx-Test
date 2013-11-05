
<div class="login-form">
    <div class="row-fluid">
        <div class="span12">
            <h1>Login</h1>
            <form action="index.php?cmd=login" method="post">
                <p><label>Username:</label> <input type="text" name="user" value="" /> *required</p>
                <p><label>Password:</label> <input type="password" name="password" value="" /> *required</p>
                <p>
                    <input type="hidden" name="<?php echo $_SESSION['id']; ?>" value="1">
                    <input class="btn btn-primary" type="submit" name="submit" value="Login" /> 
                    <a onclick="forgotPassword();" href="javascript:void(0);" class="btn btn-warning">Forgot Password?</a> 
                    <a onclick="register();" class="btn btn-success" href="javascript:void(0);">Register</a>
                </p>
            </form>
        </div>

    </div>
</div>




<div class="forgot-pass-form">
    <h1>Forgot Password</h1>
    <form action="" method="post">
        <p><label>Username:</label> <input type="text" name="user" value="" class="user" /> *required</p>
        <p><label>Email Address:</label> <input type="text" name="email" class="email" value="" /> *required</p>
        <p>
            <input class="token" name="sendToken" type="hidden" value="0"/>
            <a class="btn btn-primary" onclick="getHint();">See my secret hint</a>
            <a onclick="forgotPassword();" href="javascript:void(0);" class="btn btn-warning">Email Reset Token</a> 
            <a onclick="login();" href="javascript:void(0);" class="btn btn-success" >Login Form</a> 
            <!--            <a class="btn btn-success"  onclick="register();" href="javascript:void(0);">Register</a>-->
        </p>
    </form>
</div>


<div class="register-form">
    <h1>Register to Login</h1>
    <form action="" method="post"><p><label>Name:</label> <input type="text" name="name" value="" class="nameR" /> *required</p>
        <p><label>Username:</label> <input type="text" name="username" value="" class="userR" /> *required</p>
        <p><label>Email Address:</label> <input type="text" name="email" value="" class="emailR" /> *required</p>
        <p><label>Password:</label> <input type="password" name="password" value="" class="passwordR" /> *required</p>
        <p><label>Confirm Password:</label> <input type="password" name="password2" value="" class="password2R" /> *required</p>
                <p><label>Password Hint:</label> <input type="text" name="hint" value="" class="hintR" /> *required</p>
        <p>
            <a class="btn btn-primary" onclick="registerForm();">Register</a>
            <a onclick="forgotPassword();" href="javascript:void(0);" class="btn btn-warning">Forgot Password?</a> 
            <a onclick="login();" href="javascript:void(0);" class="btn btn-success" >Login Form</a>  
        </p>
    </form>
</div>