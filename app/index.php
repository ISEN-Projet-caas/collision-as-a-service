<?php

require_once ("../php/init.php");
require_once ("../php/functions.php");
require_once ("../php/model/models.php");


$url = '';
$params = [];

// verify if parameter url is provided
if (isset($_GET['page'])) {
    $url = htmlspecialchars($_GET['page']);
    unset($_GET['page']);
} else {
    $url = htmlspecialchars($_SERVER['REQUEST_URI']);
}

// handle parameters
if (count($_GET) > 0) {
    foreach ($_GET as $param) {
        array_push($params, htmlspecialchars($param));
    }
}

// remove slashes at beginning and end of url
$url = filter_var(ltrim(rtrim($url, '/'), '/'), FILTER_SANITIZE_URL);


// set controller according to url
if (in_array($url, ['', 'home'])) {
    $controller = 'home';
}
// test if controller exist
else if (file_exists('../php/controller/'. $url .'.php')) {
    $controller = $url;
}
else {
    $controller = '404';
}


// add content in buffer
ob_start();
require_once ('../php/controller/'. $controller .'.php');
// get content in buffer and clean it
$content = ob_get_clean();


require_once('../php/view/layout.php');