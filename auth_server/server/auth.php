<?php
session_start();

$sessionLifetime = getenv('SESSION_LIFETIME'); 

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $sessionLifetime) {
    session_unset(); 
    session_destroy(); 
}

$_SESSION['LAST_ACTIVITY'] = time();

if (isset($_SESSION['IS_LOGIN']) && $_SESSION['IS_LOGIN'] === 1) {
    http_response_code(200);
    echo "True";
} else {
    http_response_code(401);
    echo "Please login";
}
?>
