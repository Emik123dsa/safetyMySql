<?php declare(strict_types = 1); 

$config = require_once '../config.php';

require_once "../vendor/autoload.php";

use Database\Database; 

$db = new Database($config['db']);

$title = trim(str_replace('\r', '', $_POST['title'])); 
$content = trim(str_replace('\r', '', $_POST['content'])); 

$query = $db->query("INSERT INTO post(title, content) VALUES(:title, :content)", [
    "title" => $title, 
    "content" => $content
]);

?>