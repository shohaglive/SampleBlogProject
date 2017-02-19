<?php
include "header.php";
$loc = basename($_SERVER['REQUEST_URI']);
if(!isset($_SESSION['auth'])) { 
    echo "<meta http-equiv='refresh' content='0; url=login.php?req=1&redir=$loc' />"; 
    die("<br><center>AUTHENTICATING...</center>");
}

if(isset($_POST['submit_post']))
{
    $upImg = 1;
    // uploading the image
    if($_FILES['upload_img']["name"] != "") $upImg = $control->uploadImg($_FILES['upload_img'], "posts");

    if($_POST['sel_topic'] == "0") $topic = $_POST['add_topic']; else $topic = $_POST['sel_topic'];
    if($_POST['add_topic'] != "")
    {
        $p = array("topic_name", "inserted_by");
        $v = array($_POST['add_topic'], $_SESSION['auth']['id']);
        $control->insertData("topics", $p, $v);

    }
    if($upImg == 0)
        $msg ="ERROR WHILE UPLOADING IMAGE. CHECK FILE SIZE AND TYPE";
    else
    {
        // if no error with uploading image then try saving the post
        $params = array("title", "body", "image", "poster_id", "topic_id", "updated_at");
        $values = array($_POST['title'], $_POST['body'], $upImg , $_SESSION['auth']['id'], $topic, "");
        $result = $control->insertData("threads", $params, $values);
        if($result) $msg = "POST SAVED SUCCESSFULLY"; else $msg = "ERROR! POST ISN'T SAVED";
    }
}
$topics = $control->getTopics();
?>

<br><center><?php if(isset($msg)) echo $msg; else echo "ADD POST"; ?></center><br>
<div class="wthree" style="margin-top: 10px; min-height: 100px">
    <form name="newpost" action="" method="post" enctype="multipart/form-data">
        <table cellspacing="20px">
            <tr>
                <td><label>POST TITLE</label></td>
                <td><input name="title" type="text" placeholder="Post Title" required=""></td>
            </tr>
            <tr>
                <td><label>POST BODY</label></td>
                <td><textarea name="body" rows="10" cols="50" required></textarea></td>
            </tr>
            <tr>
                <td><label>ADD IMAGE</label></td>
                <td><input type="file" name="upload_img"></td>
            </tr>
            <tr>
                <td><label>TOPIC</label></td>
                <td>Select
                    <select name="sel_topic">
                        <option value="0"> Select Topic</option>
                        <?php foreach($topics as $t)
                        {
                            echo "<option value='".$t['topic_name']."' >".$t['topic_name']."</option>";
                        }?>

                    </select>
                    Or Add
                    <input type="text" name="add_topic">
                </td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit" name="submit_post">POST</button> </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>