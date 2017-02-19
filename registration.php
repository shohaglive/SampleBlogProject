<?php
include "header.php";

if(isset($_POST['username']))
{
    $params = array("id","username","email","password");
    $values = array("", $_POST['username'], $_POST['email'], md5($_POST['password']));
    $insertUser = $control->insertData("users", $params, $values);

    if($insertUser) $msg= "Successfully Registered!"; else $msg= "Registration isn't successful! Please check if the email is already registered.";
}
?>

<br><center><?php if(isset($msg)) echo $msg; else echo "REGISTRATION";?></center><br>
<div class="wthree" style="margin-top: 10px; min-height: 100px; align-content: center">
<center>
    <div class="form-group">
        <form name="login" method="post" action="">
            <table cellspacing="10px">
                <tr>
                    <td><label for="username">Name</label></td>
                    <td><input type="text" name="username" placeholder="Your Name" required></td>
                </tr>
                <tr>
                    <td><label for="email">Email</label></td>
                    <td><input type="email" name="email" placeholder="Email" required></td>
                </tr>
                <tr>
                    <td><label for="password">Password</label></td>
                    <td><input type="password" name="password" placeholder="Password" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button type="submit" name="register">Register</button></td>
                </tr>
            </table>
        </form>
    </div>
</center>
</div>
</body>
</html>