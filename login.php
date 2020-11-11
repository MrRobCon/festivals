<?php require_once 'config.php'; ?>
<?php
if ($request->is_logged_in()) {
  $request->redirect("/home.php");
}
try {
  $rules = [
    "email" => "present|email|minlength:7|maxlength:64",
    "password" => "present|minlength:8|maxlength:64"
  ];
  $request->validate($rules);
  if ($request->is_valid()) {
    $email = $request->input("email");
    $password = $request->input("password");
    $user = User::findByEmail($email);
    if ($user === null) {
      $request->set_error("email", "Email/password invalid");
    }
    else if ($user !== null) {
      if (!password_verify($password, $user->password)) {
        $request->set_error("email", "Email/password invalid");
      }
    }
  }
}
catch (PDOException $ex) {
  $request->set_exception("Database exception: " . $ex->getMessage());
}
catch (Exception $ex) {
  $request->set_exception("Exception: " . $ex->getMessage());
}

if ($request->is_valid()) {
  $request->session()->set('email', $user->email);
  $request->session()->set('name', $user->name);
  $request->redirect("/home.php");
}
else {
  require 'login-form.php';
}
?>