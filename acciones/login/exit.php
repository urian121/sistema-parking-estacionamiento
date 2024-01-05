<?php
session_start();
session_unset();
session_destroy();
$parametros_cookies = session_get_cookie_params();
setcookie(session_name(), 0, 1, $parametros_cookies["path"]);
header("Location: ../../?logout=1");
