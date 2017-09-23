<?php

class LoginCtrl {

	public function loginUser(User $user) {
		if ($this->getUsernameInput()) {
			header("Location:" . $_SERVER['PHP_SELF'] . "?LoginView::Message=Username is missing");
		} else if ($this->getPasswordInput()) {
			header("Location:" . $_SERVER['PHP_SELF'] . "?LoginView::Message=Password is missing");
		} else {
			$this->getUser($user);
		}
	}

	private function getUser($user) {
		if ($user->findUser($_POST['LoginView::UserName'], $_POST['LoginView::Password'])) {
			header("Location:/index.php?LoginView::Message=Welcome");
		}
	}

	private function getUsernameInput() {

		return strlen($_POST['LoginView::UserName']) <= 0;
	}

	private function getPasswordInput() {
		
		return strlen($_POST['LoginView::Password']) <= 0;
	}
}
