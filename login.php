<?php
include "header.php";
$title = "LOGIN";
$loc = "index.php";
if(isset($_GET['redir']))
{
    $loc = $_GET['redir'];
    if(isset($_GET['req'])) $title = "LOGIN REQUIRED";
}
if(isset($_POST['login']))
{
  $login = $control->login($_POST['user'], $_POST['password']);
  if(count($login))
  {
      session_destroy();
      session_start();
      $_SESSION['auth']= $login[0];
      echo "<meta http-equiv='refresh' content='0; url=$loc' />";
      die("<br><center>LOGIN SUCCESSFUL! REDIRECTING...</center>");
  }
    else
    {
        $title = "LOGIN CREDENTIALS INVALID!";
    }
}
?>
<br><center><?php echo $title; ?></center><br>
<div class="wthree" style="margin-top: 10px; min-height: 100px; align-content: center">
<center>
    <div class="form-horizontal">
        <form class="form-horizontal" name="login" method="post" action="">
            <table cellspacing="10px">
                <tr>
                    <td><label for="user">Email</label></td>
                    <td><input type="email" name="user" placeholder="Email" required></td>
                </tr>
                <tr>
                    <td><label for="password">Password</label></td>
                    <td><input type="password" name="password" placeholder="Password" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button type="submit" name="login">Login</button> Need Account? <a href="registration.php">Register</a> here</td>
                </tr>
            </table>
        </form>
    </div>
</center>
</div>
</body>
</html>