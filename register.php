<?php require_once 'config.php'; ?>
<?php
try {
  $rules = [
    "email" => "present|email|minlength:7|maxlength:64",
    "password" => "present|minlength:8|maxlength:64",
    "name" => "present|minlength:4|maxlength:64"
  ];
  $request->validate($rules);

  if ($request->is_valid()) {
    $email = $request->input("email");
    $password = $request->input("password");
    $name = $request->input("name");
    $user = User::findByEmail($email);
    if ($user !== null) {
      $request->set_error("email", "Email address is already registered");
    }
    else {
      $user = new User();
      $user->email = $email;
      $user->password = password_hash($password, PASSWORD_DEFAULT);
      $user->name = $name;
      $user->save();
    }
  } 
}
catch(PDOException $ex) {
  $request->set_exception("Database exception: " . $ex->getMessage());
}
catch(Exception $ex) {
  $request->set_exception("Exception: " . $ex->getMessage());    
}

if ($request->is_valid()) {
  $request->session()->set("email", $user->email);
  $request->session()->set("name", $user->name);
  $request->redirect("/home.php");
}
else {
  require "register-form.php";
}
?>