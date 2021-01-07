<?php

setcookie("auth", "", time() - 60, "/", "", false, false);
header('Location:login.php');
