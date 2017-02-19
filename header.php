<?php
session_start();
error_reporting(0);
include "control/control.php";
$control = new control();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="author" content="Developed By Mohammed Abdus Sattar">
    <title>ASSIGNMENT</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<div class="header" style="min-height: 40px">
    <table cellspacing="10" style="float: left">
        <tr>
            <td><a href="index.php">Home</a></td>
            <td><a href="newThread.php">Add Post</a></td>
            <?php
            $loc = basename($_SERVER['REQUEST_URI']);
            if(isset($_SESSION['auth'])) {
                $loc = basename($_SERVER['REQUEST_URI']);
                ?>
                <td>Logged in as <?php echo $_SESSION['auth']['username']; ?></td>
                <td><a href="logout.php?redir=<?php echo $loc; ?>">Logout</a></td>
            <?php
            }
            else
            { ?>
            <td><a href="login.php?redir=<?php echo $loc; ?>">Login</a></td>
            <td><a href="registration.php">Registration</a></td>
            <?php
            } ?>
        </tr>
    </table>

</div>