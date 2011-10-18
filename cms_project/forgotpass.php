<?php require_once 'header.php'; ?>
<form method="post" action="transact-user.php">
<h1>Email Password Reminder</h1>
<p>Forgot your password? Please enter your email address, and we'll email it to you</p>
<p>Email address:<br/?
    <input type="text" id="email" name="email" />
</p>
<p>
    <input type="submit" class="submit" name="action" value="Send my reminder" />
</p>
</form>
<?php require_once 'footer.php'; ?>

