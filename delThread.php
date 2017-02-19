<?php
include "header.php";
if(isset($_GET['tid'])) $id = $_GET['tid']; else header("Location: index.php");
// Inserting a comment


$data = $control->getSingleThread($id);
$thread = $data[0];
$poster_id = $thread['poster_id'];
$user_id = $_SESSION['auth']['id'];

if($user_id == $poster_id)
{
    $where = array(
        "id" => $id
    );
    // Deleting post
    $del = $control->deleteData("threads", $where);

    // Deleting the image file associated with that image
    $img_file = "images/posts/".$thread['image'];
    if(file_exists($img_file)) unlink($img_file);

    if($del)
    {
        $where = array(
            "thread_id" => $id
        );
        // Deleting comments of the post
        $delcomment = $control->deleteData("comments", $where);
        echo "<meta http-equiv='refresh' content='0; url=index.php' />";

    }
    die("<br><center>Sorry, Thread can not be deleted. Try again or <a href='index.php'> Go Back</a> </center>");
}
die("<br><center>Sorry, you can not delete thread posted by other user. <a href='index.php'> Go Back</a> </center>");

?>
