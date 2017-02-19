<?php include '../control/control.php';

$control = new control();

$comment = $_GET['comment'];
$cid = $_GET['cid'];
$update_time = date("Y-m-d H:i:s", strtotime("-6"));

$set = array(
    "comment_body" => "$comment",
    "updated_at" => $update_time,
    "edited" => 1
);

$where = array(
    "id" => $cid
);

$update = $control->updateData("comments", $set, $where);

if($update) echo $comment; else echo "Error! Please reload the page and try again.";