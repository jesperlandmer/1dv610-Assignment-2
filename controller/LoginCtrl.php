<?php

class LoginCtrl {

	public function loginUser(User $user) {
		if ($this->getUsernameInput()) {
			$_SESSION['LoginView::Message'] = 'Username is missing';
		} else if ($this->getPasswordInput()) {
			$_SESSION['LoginView::Message'] = 'Password is missing';
		} else {
			$this->getUser($user);
		}
	}

	private function getUser($user) {
		if ($user->findUser($_POST['LoginView::UserName'], $_POST['LoginView::Password'])) {
			$_SESSION['LoginView::Message'] = 'Welcome';
		}
	}

	private function getUsernameInput() {

		return strlen($_POST['LoginView::UserName']) <= 0;
	}

	private function getPasswordInput() {
		
		return strlen($_POST['LoginView::Password']) <= 0;
	}
}
