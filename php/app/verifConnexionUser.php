<?php

session_start();

if (!isset($_SESSION['auth'])) {
    header("Location: ../../html/signin.html");
    exit;
}

