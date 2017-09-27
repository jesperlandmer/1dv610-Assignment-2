<?php

class LayoutView {

  public function render($isLoggedIn, LoginView $v, RegisterView $r, DateTimeView $dtv) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn($isLoggedIn) . '

          <div class="container">
              ' . $this->renderFormResponse($v, $r) . '

              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }

  private function renderTopLink() {
    if (isset($_GET["register"])) {
      return $this->renderLoginLink();
    } else {
      return $this->renderRegisterLink();
    }
  }

  private function renderFormResponse($v, $r) {
    if (isset($_GET["register"])) {
      return $r->response();
    } else {
      return $v->response();
    }
  }

  private function renderRegisterLink() {
    return '<a href="?register">Register a new user</a>';
  }

  private function renderLoginLink() {
      return '<a href="?">Back to login</a>';
  }

  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '' . $this->renderTopLink() . '<h2>Not logged in</h2>';
    }
  }
}
