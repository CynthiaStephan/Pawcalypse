<?php
require_once './config/whoops.php';
session_start();
session_destroy();

header('Location: index.php');
