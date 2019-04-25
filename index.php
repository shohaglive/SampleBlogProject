<?php
include "header.php";

$sort_keys = array("threads.id", "threads.title", "threads.body", "users.username");
$sort_labels = array("Post Time", "Title", "Body", "Contributor Name");
$sort_val=0;
if(isset($_POST['search_topic']))
{
    $search = $_POST['search_topic'];
    $msg = "SHOWING RESULT FOR ".$search;

    $sort_val = (int)$_POST['sort'];
    if($sort_val > 0)
    {
        $sort = $sort_keys[$sort_val];
        $msg.= " SORTED BY ".$sort_labels[$sort_val];
    }
    else
        $sort = "id DESC";
}
else
{
    $search = "";
    $sort = "id DESC";
    $msg = "ALL THREADS";
}
$data = $control->getThread($search, $sort)

?>
<br><center><?php echo $msg; ?></center><br>
<div class="wthree">
    <form name="search" method="post" action="">
        <table style="float: right">
            <p>
                This change is made in develop branch in local
            </p>
            <tr>
                <td><label>Sort By</label>
                    <select name="sort">
                        <?php
                        for($i=0; $i<count($sort_labels); $i++)
                        {
                            if($i == $sort_val)
                                echo "<option value='".$i."' selected>".$sort_labels[$i]."</option>";
                            else
                                echo "<option value='".$i."'>".$sort_labels[$i]."</option>";
                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" name="search_topic" placeholder="Search"></td>
                <td><button type="submit" name="submitSearch">Search/Sort</button> </td>
            </tr>
        </table>
    </form>
</div>

<?php
foreach($data as $d)
{
    if($d['image'] == "1") $imgSrc = "default.jpg"; else $imgSrc = $d['image'];
    $postTime = "Posted ".date("h:i A M d, Y", strtotime($d['inserted_at']));
    if($d['edited']) $postEditTime = " &#8226; Edited ".date("h:i A M d, Y", strtotime($d['updated_at'])); else $postEditTime ="" ?>
    <div class="wthree" style="min-height: 100px">
        <div style="float: left;">
            <?php echo "<a href='viewThread.php?tid=".$d['id']."' >"; ?><img width="100px" height="100px" src="<?php echo 'images/posts/'.$imgSrc; ?>"></a>
        </div>

        <div style="float: left; margin-left: 20px;">
            <h2>
              <?php echo $d['title']; ?>
            </h2>

            <div style="margin-top: 2px; max-width: 600px; max-height: 200px; min-height: 40px;">
                <?php echo substr(htmlentities($d['body']),0,100)."..."; ?>
                <a href="viewThread.php?tid=<?php echo $d['id']; ?>"><button type="button">Read More</button></a>
                <?php if(isset($_SESSION['auth']))
                { ?>
                    <a href="editThread.php?tid=<?php echo $d['id']; ?>&redir=index.php"><button type="button">Edit</button></a>
                    <a href="delThread.php?tid=<?php echo $d['id'];?>"><button>Delete</button></a>
                <?php
                } ?>

            </div>

            <p>
                <?php echo "&#8226; Author: ".$d['username']."&nbsp; &#8226; ".$postTime.$postEditTime; ?>
            </p>
        </div>
    </div>
<?php
}?>
</body>
</html>