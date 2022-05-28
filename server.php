<?php

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
  if(!empty($_POST["acc"]) && !empty($_POST["orcid"])) {
    $pack = new AccountPack($_POST["acc"],$_POST["orcid"], 1);
    $output = exec("curl -X POST http://127.0.0.1:8000/webhook -d ". "\"" . $_POST["acc"] . " " . $_POST["orcid"] ."\"");
    $pack->result = $output;
    echo json_encode($pack);
  }
}
?>
