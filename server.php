<?php
if(!empty($_POST) && !empty($_POST["ClientOutput"])) {
  //get the object from client
  $serverVar = json_decode($_POST["ClientOutput"]);

  //do something with the object
  if (!empty(account) && $serverVar->flag == 1 ) {
        $doo = shell_exec("echo ". $serverVar->account ." " . $serverVar->account ." >  /eBloc/fifo");
	$doo = shell_exec("echo ". $serverVar->account ." " . $serverVar->orcid ." >  /eBloc/orcid.txt");
  }

  //send it back to client
  echo json_encode($serverVar);
}
