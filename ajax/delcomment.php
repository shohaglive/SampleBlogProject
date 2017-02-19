<?php include '../control/control.php';

$control = new control();

$cid = $_GET['cid'];

$where = array(
    "id" => $cid
);

$del = $control->deleteData("comments", $where);

if($del) echo "Comment Deleted!"; else echo "Error! Comment isn't deleted";