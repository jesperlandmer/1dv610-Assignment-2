<?php

class LoginCtrl {

	private $user;

	public function loginUser(User $user) {
		$this->user = $user;
		$this->validator();
		$this->findUserInDb();
	}

	public function findUserInDb() {

		$this->user->loginUser($_POST['LoginView::UserName'], $_POST['LoginView::Password']);
		header("Location:index.php?LoginView::Message=Successful!");
	}

	private function validator() {
		if ($this->checkUsernameInput()) {
			header("Location:" . $_SERVER['PHP_SELF'] . "?LoginView::Message=Username is missing");
		} else if ($this->checkPasswordInput()) {
			header("Location:" . $_SERVER['PHP_SELF'] . "?LoginView::Message=Password is missing");
		} else if (!$this->checkUsernameExists()) {
			header("Location:" . $_SERVER['PHP_SELF'] . "?LoginView::Message=Wrong name or password");
		}
	}

	private function checkUsernameInput() {
		return strlen($_POST['LoginView::UserName']) < 3;
	}

	private function checkPasswordInput() {
		return strlen($_POST['LoginView::Password']) < 6;
	}

	private function checkUsernameExists() {
		return $this->user->userExists($_POST['LoginView::UserName']);
	}
}
