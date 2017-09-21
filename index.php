<?php

// START SESSION
session_start();
unset($_SESSION["errorLog"]);
unset($_SESSION["errorMessage"]);
$_SESSION["errorLog"] = array();

//INCLUDE THE VIEW FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

//INCLUDE THE CONTROLLER FILES NEEDED...
require_once('controller/RegisterCtrl.php');
require_once('controller/LoginCtrl.php');
require_once('controller/RouterCtrl.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

try {

  //CREATE OBJECTS OF THE DATABASE
  $db = new Connection();

  //CREATE OBJECTS OF THE VIEWS
  $v = new LoginView();
  $rv = new RegisterView();
  $dtv = new DateTimeView();
  $lv = new LayoutView();

  //CREATE OBJECTS OF THE CONTROLLERS
  $usr = new User();
  $rc = new RegisterCtrl();
  $lc = new LoginCtrl();
  $roc = new RouterCtrl();

  $roc->route($usr, $rc, $lc, $db);

} catch (Exception $e) {

  $_SESSION["errorMessage"] = $e->getMessage();
}

$lv->render(false, $v, $rv, $dtv);
