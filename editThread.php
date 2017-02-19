<?php
include "header.php";
if(isset($_GET['redir'])) $loc= $_GET['redir']; else $loc = 'index.php';
if(!isset($_SESSION['auth'])) echo "<meta http-equiv='refresh' content='0; url=login.php?req=1&redir=$loc' />";
$id = $_GET['tid'];

$data = $control->getSingleThread($id);
$thread = $data[0];

if($thread['poster_id'] != $_SESSION['auth']['id']) die("<br><center>Sorry, you can not edit thread posted by other user. <a href='index.php'> Go Back</a> </center>");

if(isset($_POST['submit_post']))
{
    $upImg = 1;
    // uploading new image if given

    if($_POST['sel_topic'] == "0") $topic = $_POST['add_topic']; else $topic = $_POST['sel_topic'];
    if($_POST['add_topic'] != "")
    {
        $p = array("topic_name", "inserted_by");
        $v = array($_POST['add_topic'], $_SESSION['auth']['id']);
        $ins_topic = $control->insertData("topics", $p, $v);
        if($ins_topic) $topic =$_POST['add_topic'];
    }

    if($_FILES['upload_img']["name"] != "")
    {
        $upImg = $control->uploadImg($_FILES['upload_img'], "posts");
        $prev_img = "images/posts/".$_POST['prev_img'];
        if(file_exists($prev_img) && basename($prev_img) != "default.jpg") unlink($prev_img);
    }
    else $upImg = $_POST['prev_img'];
    if($upImg == 0)
        $msg ="ERROR WHILE UPLOADING IMAGE. CHECK FILE SIZE AND TYPE";
    else
    {
        // if a new image provided an there is no error with uploading image then try updating the post
        $update_time = date("Y-m-d H:i:s");
        $set = array(
            "title" => $_POST['title'],
            "body" => $_POST['body'],
            "image" => $upImg,
            "topic_id" => $topic,
            "updated_at" => $update_time,
            "edited" => 1
        );

        $where = array(
            "id"=> $id
        );

        $result = $control->updateData("threads", $set, $where);
        if($result) header("Location: $loc"); else $msg = "ERROR! POST ISN'T SAVED";
    }
}
if($thread['image'] == "1") $imgSrc = "default.jpg"; else $imgSrc = $thread['image'];
$topics = $control->getTopics();

?>

<br><center><?php if(isset($msg)) echo $msg; else echo "EDIT POST"; ?></center><br>
<div class="wthree" style="margin-top: 10px; min-height: 100px">
    <form name="newpost" action="" method="post" enctype="multipart/form-data">
        <table cellspacing="20px">
            <tr>
                <td><label>POST TITLE</label></td>
                <td><input name="title" type="text" placeholder="Post Title" required="" value="<?php echo $thread['title'] ?>"></td>
            </tr>
            <tr>
                <td><label>POST BODY</label></td>
                <td><textarea name="body" rows="10" cols="50" required><?php echo $thread['body'] ?></textarea></td>
            </tr>
            <tr>
                <td><label>CHANGE IMAGE</label></td>
                <td><input type="file" name="upload_img"> <label>Current Image: <img height="50px" src="images/posts/<?php echo $imgSrc ?>"><input type="hidden" name="prev_img" value="<?php echo $imgSrc ?>"></label></td>
            </tr>
            <tr>
                <td><label>TOPIC</label></td>
                <td>Select
                    <select name="sel_topic">
                        <option value="0"> Select Topic</option>
                        <?php foreach($topics as $t)
                        {
                            if($thread['topic_id'] == $t['topic_name'])
                                echo "<option value='".$t['topic_name']."' selected>".$t['topic_name']."</option>";
                            else
                                echo "<option value='".$t['topic_name']."' >".$t['topic_name']."</option>";
                        }?>

                    </select>
                    Or Add
                    <input type="text" name="add_topic">
                </td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit" name="submit_post">POST</button> <a href="<?php echo $loc; ?>"><button type="button" name="cancel">CANCEL</button></a> </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>