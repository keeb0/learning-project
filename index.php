<?php
ini_set('display_errors', 1);
session_start();
header('Content-Type: text/html; charset=utf-8');
require_once 'app/bootstrap.php';
// $_SESSION['user_id'] = 98;

session_write_close();