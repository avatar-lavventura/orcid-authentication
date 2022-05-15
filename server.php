<?php
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

class AccountPack {
  public $account;
  public $orcid;
  public $flag;

  function __construct($accIn,$orcIn,$flagIn) {
    $this->account = $accIn;
    $this->orcid   = $orcIn;
    $this->flag    = $flagIn;
    $this->result  = "";
  }
}

if($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST)) {
  //if(!empty($_POST["acc"]) && !empty($_POST["orcid"]) && !empty($_POST["flag"])) {
  if(!empty($_POST["acc"]) && !empty($_POST["orcid"])) {
    //get the object from client
    $pack = new AccountPack($_POST["acc"],$_POST["orcid"], 1);
    //$output = shell_exec("echo ". $_POST["acc"] ." " . $_POST["acc"] ." > /eBloc/fifo");
    //$output = shell_exec("echo ". $_POST["acc"] ." " . $_POST["orcid"] ." > /eBloc/orcid.txt");

    //die("echo ". "\"" . $_POST["acc"] . " " . $_POST["acc"] ."\" > /tmp/ebloc_fifo.txt");

    //Z: BUNLAR CALISIYOR
    //$output = exec("echo ". "\"" . $_POST["acc"] . " " . $_POST["acc"] ."\" > ebloc_fifo.txt");
    //$output = exec("echo ". "\"" . $_POST["acc"] . " " . $_POST["orcid"] ."\" > ebloc_orcid.txt");
    $output = exec("./alper.py");
    $pack->result = $output;

    //$output = exec("echo ". "\"" . $_POST["acc"] ." \"" . $_POST["acc"] ."\" > /tmp/ebloc_fifo.txt");
    //$output = exec("echo ". "\"" . $_POST["acc"] ." \"" . $_POST["orcid"] ."\" > /tmp/ebloc_orcid.txt");
    //send it back to client
    echo json_encode($pack);
  }
}
?>
