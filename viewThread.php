<?php
include "header.php";
if(isset($_GET['tid'])) $id = $_GET['tid']; else echo "<meta http-equiv='refresh' content='0; url=index.php' />";

// Inserting a comment
if(isset($_POST['comment']))
{
    // Check to ignore duplicate entry
    if($_SESSION['check_posted'] == $_POST['token'])
        $duplicate = 1;
    else
    {
        $duplicate =0;
        $_SESSION['check_posted'] = $_POST['token'];
    }
    if(!$duplicate)
    {
        $upImg ="0";
        if($_FILES['commentImg']["name"] !="") $upImg = $control->uploadImg($_FILES['commentImg'], "comments");
        $params = array("thread_id", "comment_body", "comment_image", "commenter_id", "updated_at");
        $values = array($id, $_POST['comment'], $upImg, $_SESSION['auth']['id'],"");
        $result = $control->insertData("comments", $params, $values);
    }
}

$data = $control->getSingleThread($id);
$thread = $data[0];
$comments = $data[1];
if($thread['image'] == "1") $imgSrc = "default.jpg"; else $imgSrc = $thread['image'];

$postTime = "Posted ".date("h:i A M d, Y", strtotime($thread['inserted_at']));
if($thread['edited']) $postEditTime = "&#8226; Edited ".date("h:i A M d, Y", strtotime($thread['updated_at'])); else $postEditTime ="";

?>
<br><center><?php if(isset($msg)) echo $msg; else echo "VIEW THREAD"; ?></center><br>
<div class="wthree" style="margin-top: 10px; min-height: 1000px;">
    <div style="float: left; width: 100%">
        <div style="float: left">
            <img width="300px" src="<?php echo 'images/posts/'.$imgSrc; ?>">
        </div>
        <div style="float: left; margin-left: 10px">
            <h2><?php echo ucfirst($thread['title']); ?></h2>
            <?php
            if(isset($_SESSION['auth']))
            {
                // Getting the Edit and Delete option available only to the post owner
                if($_SESSION['auth']['id'] == $thread['poster_id'])
                { ?>
                    <table cellspacing="5">
                        <tr>
                            <td><a href="editThread.php?tid=<?php echo $id.'&redir=viewThread.php?tid='.$id;?>"><button type="button"> Edit</button></a></td>
                            <td><a href="delThread.php?tid=<?php echo $id;?>"><button>Delete</button></a></td>
                        </tr>
                    </table>
                    <?php
                }
            }?>
        </div>
    </div>
    <div style="float: left; margin-left: 10px; margin-top: 20px; min-height: 100px; width: 100%">
        <?php echo htmlentities($thread['body']); ?>
        <p>
            <?php echo "&#8226; Author: ".$thread['username']."&nbsp; &#8226; ".$postTime.$postEditTime." &#8226; Topic: ".$thread['topic_id']; ?>
        </p>
    </div>

    <div style="float: left; width: 100%">
        <h6>Comments</h6>
        <div class="wthree">
            <?php
            foreach($comments as $com)
            {
                $comTime = "Commented ".date("h:i A M d, Y" , strtotime($com['inserted_at']));
                if($com['edited'])  $comEditTime = "&#8226; Edited ".date("h:i A M d, Y" , strtotime($com['updated_at'])); else $comEditTime = "";
                ?>
                <div id="commentsect<?php echo $com['id']; ?>">
                    <div style="float: left;"><?php echo $com['username']; ?></div>
                    <div id="comtime<?php echo $com['id']; ?>" style="font-size:14; margin-left: 10px; color: darkgray; float: left;"><?php echo "	&#8226; ".$comTime."  $comEditTime"; ?></div><br>
                    <?php if($com['comment_image'] != "0")  echo "<br><img height='100px' src='images/comments/".$com['comment_image']."'>"; ?>
                    <p id="com<?php echo $com['id']; ?>" style="font-size: 16">

                        <?php echo $com['comment_body']; ?>
                    </p>

                    <div style="display: none" id="editcom<?php echo $com['id']; ?>">
                        <textarea id="comtextedit<?php echo $com['id']; ?>" name="comtextedit<?php echo $com['id']; ?>" rows="5" cols="40"> <?php echo $com['comment_body']; ?></textarea>
                        <button onclick="editComment(<?php echo $com['id'].','.$com['commenter_id'].','.$_SESSION['auth']['id']; ?>)" type="button">Done</button></a>
                    </div>
                    <?php
                    // Hiding buttons if there's no one logged in
                    if(isset($_SESSION['auth']))
                    { ?>
                        <p style="font-size: 12">
                            <button type="button" onclick="openEdit(<?php echo $com['id'].','.$com['commenter_id'].','.$_SESSION['auth']['id']; ?>)">Edit</button>
                            <button type="button" onclick="delComment(<?php echo $com['id'].','.$com['commenter_id'].','.$_SESSION['auth']['id']; ?>)">Delete</button>
                        </p>
                        <?php
                    }
                    ?>

                    <hr align="left" width="100%">

                </div>

                <?php
            } ?>
            <?php if(isset($_SESSION['auth']))
            { ?>
                <h4>Add A Comment</h4>
                <form method="post" action="" enctype="multipart/form-data">
                    <table cellspacing="10px">
                        <tr>
                            <td>Name</td>
                            <td><input type="text" value="<?php echo $_SESSION['auth']['username']; ?>" readonly ></td>
                        </tr>
                        <tr>
                            <td>Comment</td>
                            <td><textarea name="comment" rows="5" cols="50" placeholder="Your comment" required></textarea></td>
                        </tr>
                        <tr>
                            <td>Add Image</td>
                            <td><input type="file" name="commentImg"></td>
                        </tr>
                        <tr>
                            <td><input type="hidden" name ="token" value="<?php echo date('dmYHis'); ?>"></td>
                            <td><button type="submit" name="submit_comment">Publish Comment</button> </td>
                        </tr>
                    </table>
                </form>
                <?php
            }
            else
            {
                echo "<br>Please <a href='login.php?req=1&redir=viewThread.php?tid=$id'>Login</a> to Comment";
            } ?>
        </div>
    </div>
</div>
</body>

<script>
    // Function to check if the comment edit request is from the owner of that particular comment (As per the assignment requirement)
    function openEdit(id, commenterid, userid)
    {
        if(commenterid == userid)
        {
            document.getElementById("com"+id).style.display= 'none';
            document.getElementById("editcom"+id).style.display= 'block';

        }

        else
            alert("You can not edit comment posted by other users.")
    }

    // Function using ajax to edit comment without page reloading
    function editComment(id, commenterid, userid)
    {

        if(commenterid !=userid) return 0;
        var comment = document.getElementById("comtextedit" + id ).value;
        document.getElementById("com" + id).style.display = 'block';

        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if(xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                var rt=xmlhttp.responseText;
                document.getElementById("com" + id).innerHTML = rt;
                document.getElementById("editcom" + id).style.display = 'none';
            }
        }
        xmlhttp.open("GET","ajax/editcomment.php?cid="+ id + "&comment="+ comment ,true);
        xmlhttp.send();
    }

    // Function using ajax to delete comment without page reloading
    function delComment(id, commenterid, userid)
    {

        if(commenterid!= userid)
        {
            alert("You can't delete comment posted by other users");
            return 0;
        }
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if(xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                var rt=xmlhttp.responseText;
                alert(rt);
                document.getElementById("editcom" + id).style.display = 'none';
                document.getElementById("commentsect" + id).style.display = 'none';
            }
        }
        xmlhttp.open("GET","ajax/delcomment.php?cid="+ id ,true);
        xmlhttp.send();
    }
</script>
</html>