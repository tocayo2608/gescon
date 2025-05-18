<?php
/*  GESCON – Cerrar sesión
    Ruta : /src/logout.php
--------------------------------------------------------- */
session_start();
session_unset();    // vacía el arreglo $_SESSION
session_destroy();  // destruye la sesión en el servidor

header('Location: /gescon/src/auth/login.html');   // o login.html cuando lo tengamos
exit;
