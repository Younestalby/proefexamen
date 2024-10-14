<?php
// public/logout.php

include_once '../classes/Session.php';

Session::init();
Session::destroy();

header("Location: login.php");
exit();
?>
