<?php

class LoginCtrl {

	public function loginUser(User $user) {
		$this->getUsernameInput();
		$this->getPasswordInput();
		$this->getUser($user);
	}

	private function getUser($user) {
		if ($user->findUser($_POST['LoginView::UserName'], $_POST['LoginView::Password'])) {
			header("Location:/index.php?LoginView::Message=Welcome");
		}
	}

	private function getUsernameInput() {
		if (strlen($_POST['LoginView::UserName']) <= 0) {
			header("Location:" . $_SERVER['PHP_SELF'] . "?LoginView::Message=Username is missing");
		}
	}

	private function getPasswordInput() {
		if (strlen($_POST['LoginView::Password']) <= 0) {
			header("Location:" . $_SERVER['PHP_SELF'] . "?LoginView::Message=Password is missing");
		}
	}
}
