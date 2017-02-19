<?php

class control
{
     private function connect()
    {
        $dbhost = "localhost";
        $dbname ="assignment_db";
        $dbuser ="root";
        $dbpass = "";

        //Using PDO to prevent SQL Injection
        $con = new PDO('mysql:host='.$dbhost.';dbname='.$dbname , $dbuser, $dbpass);

        return $con;
    }

    //function for inserting data
    public function insertData($table, $params, $values)
    {
        $con = $this->connect();

        $par="";

        $par_key ="";
        $range = count($params);

        for($i=0; $i<$range; $i++)
        {
            $par_key.='?';
            $par.=$params[$i];

            if($i < ($range -1))
            {
                $par.=", ";
                $par_key.=', ';
            }
        }
        $query = "INSERT INTO $table($par) VALUES ($par_key)";

        $insert= $con->prepare($query);
        $result = $insert->execute($values);

        return $result;
    }

    public function updateData($table, $set, $where)
    {
        $con = $this->connect();

        $set_fields = array_keys($set);
        $set_values = array_values($set);
        $set_range = count($set);

        $where_fields = array_keys($where);
        $where_values = array_values($where);
        $where_range = count($where);

        $params = array_merge($set_values, $where_values);

        $set_str="";
        $where_str ="";

        for($i=0; $i< $set_range ; $i++)
        {
            $set_str.=$set_fields[$i]." = ?";
            if($i< ($set_range -1)) $set_str.=", ";
        }
        for($i=0; $i< $where_range ; $i++)
        {
            $where_str.=$where_fields[$i]." = ?";
            if($i< ($where_range -1)) $where_str.=" AND ";
        }

        $query = "UPDATE $table SET $set_str WHERE $where_str";
        $result = $con->prepare($query);
        $result->execute($params);

        return $result;
    }

    public function deleteData($table, $where)
    {
        $con = $this->connect();

        $where_fields = array_keys($where);
        $where_values = array_values($where);
        $where_range = count($where);

        $where_str ="";

        for($i=0; $i< $where_range ; $i++)
        {
            $where_str.=$where_fields[$i]." = ?";
            if($i< ($where_range -1)) $where_str.=" AND ";
        }

        $query = "DELETE FROM $table WHERE $where_str";

        $result = $con->prepare($query);
        $result->execute($where_values);

        return $result;
    }

    public function getTopics()
    {
        $con = $this->connect();

        $query = "SELECT * FROM topics WHERE 1";

        $result = $con->prepare($query);
        $result->execute();

        $data = $result->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function getThread($search, $order)
    {
        $con = $this->connect();
        $search = htmlentities(trim($search));
        if($search != "")
            $where = "AND (title LIKE '%$search%' OR body LIKE '%$search%' OR poster_id IN (SELECT id FROM users WHERE username LIKE '%$search%' ))";
        else
            $where = "";

        $query = "SELECT threads.*, users.username FROM threads, users WHERE users.id = threads.poster_id $where ORDER BY $order";

        $result = $con->prepare($query);
        $result->execute();

        $data = $result->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }
    public function getSingleThread($id)
    {
        $con = $this->connect();

        $queryThread = "SELECT threads.*, users.username FROM threads, users WHERE threads.id = $id AND users.id = threads.poster_id";
        $queryComment = "SELECT comments.*, users.username FROM comments, users WHERE comments.thread_id = $id AND users.id = comments.commenter_id ORDER BY comments.id";

        $resultThread = $con->prepare($queryThread);
        $resultComment =$con->prepare($queryComment);

        $resultThread->execute();
        $resultComment->execute();

        $dataThread = $resultThread->fetchAll(PDO::FETCH_ASSOC);
        $dataComment = $resultComment->fetchAll(PDO::FETCH_ASSOC);

        $data = array($dataThread[0], $dataComment);

        return $data;
    }


    // function to check login credentials
    public function login($email, $pass)
    {
        $con = $this->connect();
        $pass = md5($pass);
        $params = array($email, $pass);

        $query = "SELECT * FROM users WHERE email = ? AND password =?";

        $result = $con->prepare($query);
        $result->execute($params);

        $data = $result->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function uploadImg($data , $loc)
    {
        $valid = 1;
        $check = getimagesize($data["tmp_name"]);
        //Checking validity of image file
        if(!$check) $valid =0;
        if($data["size"] > 5000000) $valid =0;

        $targetName = $_SESSION['auth']['id']."_".date("dmYHis");
        $targetFile = "images/$loc/".$targetName.".".pathinfo($data["name"],PATHINFO_EXTENSION);

        if($valid)
        {
            if (move_uploaded_file($data["tmp_name"], $targetFile)) return basename($targetFile);
        }

        return 0;
    }
}