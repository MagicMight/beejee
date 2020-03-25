<?php 

include 'models/home.php';

$p =  isset($_GET['p']) ? filter_input(INPUT_GET, 'p', FILTER_SANITIZE_SPECIAL_CHARS) : 1;
$tasklist = getTasklist( $p );

include 'views/home.php';


?>