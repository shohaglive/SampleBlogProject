<?php
session_start();
session_destroy();
$loc = $_GET['redir'];
header("Location: $loc");