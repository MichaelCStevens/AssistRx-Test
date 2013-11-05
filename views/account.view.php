<div class="welcome">
    Welcome back, <?php print $_SESSION['users_name']; ?>

    <br/>
    <br/>
    Your email address is: <?php print $_SESSION['users_email']; ?>
    <br/><br/>
    You can refresh this index page and you will still be logged in, until you 
    <a href="index.php?cmd=logout">Log Out</a>
</div>