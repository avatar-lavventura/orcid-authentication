<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>ORCID Create on Demand Demo</title>
    <script src="test.js" type="text/javascript"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Styles -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="bootstrap/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="https://orcid.org/sites/default/files/images/orcid_16x16.png" />
 <style>
    html {
      margin: 0;
      padding: 0;
      height: 100%;
      width: 100%;
      background: white;
    }

    #result {
      position: relative;
      margin: auto;
      left: 0; right: 0;
      height: 400px;
      max width: 1200px;
      width: 95vw;
      margin-top: 20px;
      /*border: 1px solid black;*/
      font-size: 24px;
      padding: 5px 10px 5px 10px;
      overflow: auto;
    }

    #result p {
       margin: 0 0 10 0;
       left:20px;
        position:relative;
    }

    #btn {
      position: relative;
      display: block;
      margin: auto;
      left: 0; right: 0;
      font-size: 20px;
      font-weight: bold;
      padding: 10px 20px 10px 20px;
      border-radius: 4px;
      cursor: pointer;
      background: linear-gradient(to bottom,lightblue,white,lightblue);
      text-shadow: 1px 1px 0px rgba(192,192,192,1);
    }

    #btn:hover {
      background: linear-gradient(to bottom,lightblue,white,lightblue);
      box-shadow: 0px 0px 3px 4px rgba(192,192,192,0.3);
    }

    #btn:active {
      background: linear-gradient(to bottom,white,lightblue,white);
      text-shadow: -1px -1px 0px rgba(192,192,192,1);
    }
 </style>
  </head>

  <body>
  <script src="client.js"></script>

    <script>


function a() {
       window.addEventListener('load', function() {
            var web3 = window.web3;
            if (typeof web3 !== 'undefined') {
                web3js = new Web3(web3.currentProvider); // Use Mist/MetaMask's provider
             } else {
                alert('No web3 You should consider trying MetaMask!')
                web3js = new Web3(new Web3.providers.HttpProvider("http://localhost:8545"));
             }
      });
var account = web3.eth.accounts[0];
//alert(account)

      web3.eth.getAccounts(function(err, accounts) {
          account = accounts[0]
          //alert(account)
          return(account)
     })
}


</script>



<?php
session_start();

/*
if (!isset($_SESSION['doneID'])) {
  $_SESSION['doneID'] = 1;
  echo 'hello987';
  }
else {
  echo 'hello1234';
}
*/
  
/////////////////////////////////////////////////////////////////////////////////
//ORCID API CREDENTIALS - replace these values with your API credentials

define('OAUTH_CLIENT_ID',     '**********');                                                //client ID
define('OAUTH_CLIENT_SECRET', '**********');                                //client secret
define('OAUTH_REDIRECT_URI',  '**********'); //redirect URI

//ORCID API ENDPOINTS
////////////////////////////////////////////////////////////////////////////////
   
//Sandbox - Member API
//define('OAUTH_AUTHORIZATION_URL', 'https://sandbox.orcid.org/oauth/authorize');//authorization endpoint
//define('OAUTH_TOKEN_URL', 'https://sandbox.orcid.org/oauth/token'); //token endpoint
//define('ENV', 'https://sandbox.orcid.org'); //environment

//Sandbox - Public API
//define('OAUTH_AUTHORIZATION_URL', 'https://sandbox.orcid.org/oauth/authorize');//authorization endpoint
//define('OAUTH_TOKEN_URL', 'https://sandbox.orcid.org/oauth/token');//token endpoint
//define('ENV', 'https://sandbox.orcid.org'); //environment

//Production - Member API
//define('OAUTH_AUTHORIZATION_URL', 'https://orcid.org/oauth/authorize');//authorization endpoint
//define('OAUTH_TOKEN_URL', 'https://api.orcid.org/oauth/token'); //token endpoint
//define('ENV', 'https://orcid.org'); //environment

//Production - Public API
define('OAUTH_AUTHORIZATION_URL', 'https://orcid.org/oauth/authorize');//authorization endpoint
define('OAUTH_TOKEN_URL', 'https://orcid.org/oauth/token');//token endpoint
define('ENV', 'https://orcid.org'); //environment

//EXCHANGE AUTHORIZATION CODE FOR ACCESS TOKEN
////////////////////////////////////////////////////////////////////////

$name = ""; // define variables and set to empty values
$code = "";
$response = "";
  
//If an authorization code exists, fetch the access token
if (isset($_GET['code'])) {
	//Build request parameter string
	$params = "client_id=" . OAUTH_CLIENT_ID . "&client_secret=" . OAUTH_CLIENT_SECRET . "&grant_type=authorization_code&code=" . $_GET['code'] . "&redirect_uri=" . OAUTH_REDIRECT_URI;

	//Initialize cURL session
	$ch = curl_init();

	//Set cURL options
	curl_setopt($ch, CURLOPT_URL, OAUTH_TOKEN_URL);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);//Turn off SSL certificate check for testing - remove this for production version!
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);//Turn off SSL certificate check for testing - remove this for production version!
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

	//Execute cURL command
	$result = curl_exec($ch);

	//Close cURL session
	curl_close($ch);

	//Transform cURL response from json string to php array
        $response = json_decode($result, true);
        $code=$response['orcid'];
        $_SESSION['code_id'] = $code;
        $_SESSION['response_id'] = $response;
        $_SESSION['flag_id']     = 0;

        //if (!empty($code)) {
        //   $doo = shell_exec("echo ". $code ." >  /eBloc/fifo");
        //   $doo = shell_exec("echo ". $code ." >> /eBloc/orcid.txt");
        //}
        //$doo = shell_exec("echo ". htmlspecialchars($_GET["code"]) ." >> /eBloc/");
        // echo '' . htmlspecialchars($_GET["code"]) . '!';
        //$doo = shell_exec('/eBloc/dene.sh');
        //$doo = shell_exec('ls /eBloc/');
        //echo "<pre>$doo</pre>";
} else { 
      echo "Unable to connect to ORCID "; //If an authorization code doesn't exist, throw an error
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $code     = $_SESSION['code_id'];
  $response = $_SESSION['response_id'];
  $flag = 0;
  
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
  }
  header('Location: nextpage.php');
  //session_destroy();
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
  }

//echo "<p id='resultJS'> </p>";
echo "<script type='text/javascript'>".
        "document.getElementById('resultJS').innerText = a()".
        "</script>";

?>

<div class="container">
      <div class="masthead">
        <ul class="nav nav-pills pull-right">
          <li><a href="index.php">Home</a></li>
          <li><a href="https://orcid.org/about" target="_blank">About ORCID</a></li>
          <li><a href="https://orcid.org/help/contact-us" target="_blank">Contact ORCID</a></li>
        </ul>
        <h3 class="muted">ORCID @ eBlocBroker</h3>
      </div>

      <hr>

      <div class="jumbotron">
      <h1>Thanks, <?php echo $response['name']; ?>!</h1>
      <br>
      <p class="lead">Your ORCID <img src="https://orcid.org/sites/default/files/images/orcid_16x16.png" class="logo" width='16' height='16' alt="iD"/> is <a href="<?php echo ENV; ?>/<?php echo $response['orcid']; ?>" target="_blank"><?php echo ENV; ?>/<?php echo $response['orcid']; ?></a></p>
    <!--
    <p class="lead">We received your registration. </p>
    -->

    <button id="btn" title="Come on, click It!"
    onclick="sendItToServer('<?php echo $response['orcid'];?>')">Click
    here to register with your Ethereum Address</button>
    <div id="result"></div>

    <!--
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Ethereum Address: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

<?php
echo "<h2>Your Input:</h2>";
  echo $name;
  echo $code;
echo "<br>";
?>
-->


      </div>

<hr>
      <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
