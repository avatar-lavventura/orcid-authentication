<?php
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if($_SERVER["REQUEST_METHOD"] === "POST") {
  if(!empty($_POST["ethAddr"])) {
    $code     = $_SESSION['code_id'];
    $response = $_SESSION['response_id'];
    $flag     = 0;
    $address  = "";

    if(empty($_POST["ethAddr"])) {
      die("BadAddress");
    }
    else {
      $address = test_input($_POST["ethAddr"]);
      die("GoodAddress");
    }

    //header('Location: nextpage.php');
    //session_destroy();
  }
  else if(!empty($_POST["ClientOutput"])) {
    //if(!empty($_POST) && !empty($_POST["ClientOutput"]))
    //get the object from client
    $server_var = json_decode($_POST["ClientOutput"]);
    var_dump($server_var);
    die();
    if (!empty($server_var->account) && intval($server_var->flag) == 1 ) {
      $output = shell_exec("echo ". $server_var->account ." " . $server_var->account ." > /tmp/eboc_fifo.txt");
      $output = shell_exec("echo ". $server_var->account ." " . $server_var->orcid ." > /tmp/eboc_orcid.txt");
    }
    //send it back to client
    echo json_encode($server_var);
  }
}
?>
