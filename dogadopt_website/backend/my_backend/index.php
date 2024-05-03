<?php
require_once 'JWT.php';
use \Firebase\JWT\JWT;

require __DIR__ . "/inc/bootstrap.php";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
$strMethodName = '';

if (isset($uri[5]) && isset($uri[6])) {
    $strMethodName = $uri[5] . $uri[6];
    
    switch ($uri[5]) {
        case 'user':
            #user operations
            break;
        case 'dog':
            #dog operations
            break;
        case 'application':
            #application operations
            break;
        default:
            header("HTTP/1.1 404 Not Found");
            exit();
    }
}

require PROJECT_ROOT_PATH . "/Controller/Api/MainController.php";

$objFeedController = new MainController();
if (isset($uri[7])) {
    $strMethodName = $strMethodName . $uri[7];
}
$strMethodName = $strMethodName . 'Action';
$objFeedController->{$strMethodName}();
?>
