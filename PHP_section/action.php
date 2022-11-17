<?php

function log_user($now,$user,$delayed) {
  $file = "logfile.log";
  $data = $now->format('Y-m-d H:i:s') . " | ".$user." | ";
  file_put_contents($file, $data, FILE_APPEND);
  if ($delayed) {
    add_delay($file);
  }
  file_put_contents($file, PHP_EOL, FILE_APPEND);
}

function add_delay($file){
  file_put_contents($file, "Student was deleyed",FILE_APPEND);
}


function IsDelayed($now){
  $delay_breakpoint = new DateTime("08:00:00");
  if ($now > $delay_breakpoint) {
    return true;
  }
  return false;
}

function getlog(){
  $file = "logfile.log";
  $log = file_get_contents($file);
  echo $log;
}

if(array_key_exists('Log', $_POST)) {
  getLog();
}

if (isset($_POST['username'])) {
  $user = $_POST['username'];
}
else{
  $user = $_GET['username'];
}

if ($user) {
  //
  $now = new DateTime();

  if ($now > new DateTime("20:00")){
    return die("You are late");
  }

  $delayed = IsDelayed($now);

  log_user($now,$user,$delayed);
}

?>