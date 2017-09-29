<?php

class LayoutView {

  /**
   * Renders the HTML code document
   *
   * @param $isLoggedIn, Boolean check if logged in
	 *
	 * @return void BUT writes to standard output
	 */
  public function render($isLoggedIn, LoginView $v, RegisterView $r, DateTimeView $dtv) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderTopLink($isLoggedIn) . '
          ' . $this->generateAuthStatus($isLoggedIn) . '

          <div class="container">
              ' . $this->renderFormResponse($isLoggedIn, $v, $r) . '

              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }

  /**
	 * Checks if register page or not
	 * @return boolean
	 */
  private function isRegisterPage() {
    return isset($_GET["register"]);
  }

  /**
	 * Returns top link in layout
	 * @return string 
	 */
  private function renderTopLink($isLoggedIn) {
    if (!$isLoggedIn) {
      return $this->generateTopLinkHTML();
    }
  }

  /**
	 * Generate HTML code for the top link
	 * @return string HTML code
	 */
  private function generateTopLinkHTML() {
    if ($this->isRegisterPage()) {
      return '<a href="?">Back to login</a>';
    } else {
      return '<a href="?register">Register a new user</a>';
    }
  }

  /**
	 * Returns the requested page form
	 * @return string HTML code
	 */
  private function renderFormResponse($isLoggedIn, $v, $r) {
    if ($this->isRegisterPage()) {
      return $r->response($isLoggedIn);
    } else {
      return $v->response($isLoggedIn);
    }
  }

  /**
	 * Generate authorization status HTML code
	 * @return string HTML code
	 */
  private function generateAuthStatus($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }

  protected function setMessage($view) {
		$message = '';

		if(isset($_SESSION[$view])) {
			$message = $_SESSION[$view];
			unset($_SESSION[$view]);
			return $message;
		}
  }
  
  /**
	* Gets stored username from previous register attempt
	* @return string, session stored username
	*/
	protected function getRequestUserName($storedUserName) {
		$usernameToReturn = '';

		if ($this->isRequestUsername($storedUserName)) {
			$usernameToReturn = $_SESSION[$storedUserName];
			unset($_SESSION[$storedUserName]);
		}

		return $usernameToReturn;
	}

	/**
	* Check if stored session username
	* @return boolean
	*/
	private function isRequestUsername($userToCheck) {
		return isset($_SESSION[$userToCheck]);
	}
}
