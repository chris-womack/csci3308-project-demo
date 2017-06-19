<?php 
if($_POST['logme']){
if(!empty($_POST['username']) AND !empty($_POST['pass'])){
echo "Your Are Logged $_POST[username] ";
}else{
echo "You have to fill out the two fields !";
}
}else{
?>
<form method="post">
Username : <input type="text" name="username" />
Password: <input type="password" name="pass" />
<br/>
<input type="submit" name="logme" value="Login" />
</form>
<?php
}
