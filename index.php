<?php

// START SESSION
session_start();

//INCLUDE THE LIBRARY FILES NEEDED...
require_once('libs/Connection.php');

//INCLUDE THE VIEW FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

//INCLUDE THE CONTROLLER FILES NEEDED...
require_once('controller/RegisterCtrl.php');
require_once('controller/RouterCtrl.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE DATABASE
$db = new Connection();

//CREATE OBJECTS OF THE VIEWS
$v = new LoginView();
$rv = new RegisterView();
$dtv = new DateTimeView();
$lv = new LayoutView();

$lv->render(false, $v, $rv, $dtv);

//CREATE OBJECTS OF THE CONTROLLERS
$rc = new RegisterCtrl();
$roc = new RouterCtrl();

$roc->route($rc, $db);
