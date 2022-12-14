<?php

function log_user($now,$user,$delayed) {
  $file = "logfile.log";
  $data = $now->format('Y-m-d H:i:s') . " | ".$user." | ";
  file_put_contents($file, $data, FILE_APPEND);
  $prichod = new Prichod();
  $prichod->store_prichod();
  if ($delayed) {
    add_delay($file);
  }
  file_put_contents($file, PHP_EOL, FILE_APPEND);

  Student::store_student($user);

}


Class Student{
  //store student in studenti.json
  public static function store_student($name)
  {
    if (file_exists('studenti.json')) {
      $current_data = file_get_contents('studenti.json');
      $array_data = json_decode($current_data, true);
      $new_id = count($array_data);
      $extra = array(
        "id" => $new_id,
        "name"               =>     $name,
      );
      $array_data[] = $extra;
      $final_data = json_encode($array_data);
      file_put_contents('studenti.json', $final_data);
    }
    else{
      $file=fopen("studenti.json","w");
      $array_data=array();
      $extra = array(
        "id" => 0,
        "name"               =>     $name,
      );
      $array_data[] = $extra;
      $final_data = json_encode($array_data);
      fwrite($file, $final_data);
      fclose($file);
    }
    
  }

  //display studenti.json file
  public static function print_results()
  {
    $current_data = file_get_contents('studenti.json');
    $array_data = json_decode($current_data, true);
    foreach ($array_data as $key => $value) {
      print_r($value['id']." ".$value['name']."<br>");
    }
  }
}

Class Prichod{
  // store prichody in prichody.json
  public function store_prichod()
  {
    $delay = $this::check_delay();
    if (file_exists('prichody.json')) {
      $current_data = file_get_contents('prichody.json');
      $array_data = json_decode($current_data, true);
      $new_id = count($array_data);
      $extra = array(
        "time" => date("Y-m-d H:i:s"),
        "delay" => $delay,
      );
      $array_data[] = $extra;
      $final_data = json_encode($array_data);
      file_put_contents('prichody.json', $final_data);
    }
    else{
      $file=fopen("prichody.json","w");
      $array_data=array();
      $extra = array(
        "time" => date("Y-m-d H:i:s"),
        "delay" => $delay,
      );
      $array_data[] = $extra;
      $final_data = json_encode($array_data);
      fwrite($file, $final_data);
      fclose($file);
    }
    
  }

  private function check_delay()
  {
    return new Datetime() > '08:00:00' ? true : false;
  }

  //display prichody.json file
  public static function print_results()
  {
    $current_data = file_get_contents('prichody.json');
    $array_data = json_decode($current_data, true);
    foreach ($array_data as $key => $value) {
      print_r($value['time']." ".$value['delay']."<br>");
    }
  }

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
  Student::print_results();
  echo(" <br> <br> ");
  Prichod::print_results();
}

if(array_key_exists('Log', $_POST)) {
  getLog();
}

$user = NULL;


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