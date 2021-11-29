<?php
if(!empty($_POST) && !empty($_POST["ClientOutput"])) {
    //get the object from client
    $server_var = json_decode($_POST["ClientOutput"]);
    if (!empty(account) && $server_var->flag == 1 ) {
        $output = shell_exec("echo ". $server_var->account ." " . $server_var->account ." > /eBloc/fifo");
        $output = shell_exec("echo ". $server_var->account ." " . $server_var->orcid ." > /eBloc/orcid.txt");
    }
    //send it back to client
    echo json_encode($server_var);
}
