<?php

session_start();
session_unset();
session_destroy();

header('Location: /gescon/PHP/auth/login.html');
exit;
