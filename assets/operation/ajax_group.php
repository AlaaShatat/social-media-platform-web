<?php
require '../classes.php';
$connect =new connection ;
$con = $connect->conn; 

$limit=50; //num of posts to be loaded

$posts=new Post($con,$_REQUEST['userloggedin']);
//$post= new Post($con,$userloggedin);
$posts->loadpostfriends($_REQUEST, $limit);

?>