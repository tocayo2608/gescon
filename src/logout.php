<?php

session_start();
session_unset();
session_destroy();

header('Location: /gescon/src/auth/login.html');
exit;
