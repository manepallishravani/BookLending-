<?php
session_start();
echo($_SESSION['un']." ".$_SESSION['ps']." ".$_SESSION['id']." ");
/*session_destroy();*/
echo hash("sha256", "34550715062af006ac4fab288de67ecb44793c3a05c475227241535f6ef7a81b")
?>