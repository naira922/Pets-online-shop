<?php
$conn = mysqli_connect('localhost','root','','online pet store'); // localhost -> server host(my competer) , root -> username (phpmyadmin)
if(!$conn){
    die('Error'. mysqli_connect_error());
}
?>