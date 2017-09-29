<?php

session_start();

// TURN ON OUTPUT BUFFERING
ob_start();

// SET TIME ZONE
date_default_timezone_set('Europe/Stockholm');

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

  //CREATE OBJECTS OF THE VIEWS
  $v = new LoginView();
  $rv = new RegisterView();
  $dtv = new DateTimeView();
  $lv = new LayoutView();

  //CREATE OBJECTS OF THE CONTROLLERS
  $rc = new RegisterCtrl();
  $lc = new LoginCtrl();
  $roc = new RouterCtrl();

  //CREATE OBJECTS OF THE MODEL
  $usr = new User();

  //INITIALIZE CONTROLLERS
  $roc->route($usr, $rc, $lc);
  $isLoggedIn = $lc->isLoggedIn($usr);

  //INITIALIZE VIEWS
  $lv->render($isLoggedIn, $v, $rv, $dtv);
  
} catch (Exception $e) {

  echo $e->getMessage();
}