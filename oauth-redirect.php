<?php
session_start();

/////////////////////////////////////////////////////////////////////////////////
//ORCID API CREDENTIALS - replace these values with your API credentials
define('OAUTH_CLIENT_ID', 'APP-90R3NMFJNN5M4J84'); //client ID
define('OAUTH_CLIENT_SECRET', 'd329775a-29dc-472a-83e7-cdf5e2119e88'); //client secret
define('OAUTH_REDIRECT_URI', 'http://eblocbroker.duckdns.org/oauth-redirect.php'); //redirect URI

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

$name     = ""; // define variables and set to empty values
$code     = "";
$response = "";

// If an authorization code exists, fetch the access token
if(isset($_GET['code'])) {
  //Build request parameter string
  $params = "client_id=" . OAUTH_CLIENT_ID .
            "&client_secret=" . OAUTH_CLIENT_SECRET .
            "&grant_type=authorization_code" .
            "&code=" . $_GET['code'] .
            "&redirect_uri=" . OAUTH_REDIRECT_URI;

  //Initialize cURL session
  $ch = curl_init();

  //Set cURL options
  curl_setopt($ch, CURLOPT_URL, OAUTH_TOKEN_URL);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Turn off SSL certificate check for testing - remove this for production version!
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Turn off SSL certificate check for testing - remove this for production version!
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  //Execute cURL command
  $result = curl_exec($ch);

  //Close cURL session
  curl_close($ch);

  //Transform cURL response from json string to php array
  $response = json_decode($result, true);
  $code = $response['orcid'];
  if(empty($code))
   header("Location: index.php");
  $_SESSION['code_id'] = $code;
  $_SESSION['response_id'] = $response;
  $_SESSION['flag_id'] = 0;
} else {
  echo "Unable to connect to ORCID "; // If an authorization code doesn't exist, throw an error
  //die();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>ORCID Create on Demand Demo</title>
    <!--<script src="client.js" type="text/javascript"></script>-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="bootstrap/js/html5shiv.js"></script>
    <![endif]-->
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
        /*width: 92vw;*/
        margin-top: 20px;
        /*border: 1px solid black;*/
        font-size: 24px;
        padding: 5px 10px 5px 10px;
        /*overflow: auto;*/
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
    <script>
      "use strict";
      window.onload = function() {
        function AddressPack(accountIn,orcidIn,flagIn) {
          this.account = accountIn;
          this.orcid   = orcidIn;
          this.flag    = flagIn;
        }

        async function myFunction(orcid) {
          var accounts = null;
          var account  = null;
          if (typeof window.ethereum !== 'undefined') {
            accounts = await ethereum.request({ method: 'eth_requestAccounts' });
            account = accounts[0];
            console.log(orcid);   //calisiyor
            console.log(account); // calisiyor
          }
          else {
            alert('No web3 You should consider try with MetaMask');
          }

          //var account = web3.eth.accounts[0];
          var flag = 1;

          //if(typeof account == "undefined") {
            //account = "";
            //flag = 0;
          //}

          if(orcid == "") {
            flag = 0;
          }
          // var mypack = AddressPack(account,orcid,flag);
          // return mypack;
          return account;
          //return new AddressPack(account,orcid,flag);
        }

        var btn = document.getElementById("btn");
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
          if(xhr.readyState === 4) {
            if(xhr.status === 200) {
              if(xhr.responseText === "BadArgument" || xhr.responseText === "SomethingFailed") {
                console.log("submit failed");
                return;
              }
              else {
                //parse the server response in order to get a js object
                var response = JSON.parse(xhr.responseText);

                if (response.account == "") {
                  //show the result in html page
                  document.getElementById("result").innerHTML = "<p>Please login into your Ethereum Address in MetaMask</p>";
                }
                else if (response.orcid == "") {
                  //show the result in html page
                  document.getElementById("result").innerHTML = "<p>Please re-connect to your ORCID iD</p>";
                }
                else {
                  //show the result in html page
                  document.getElementById("result").innerHTML = "<p>Logged in Ethereum Address = " + response.account + "</p>"
                    + "<p>orcid = " + response.orcid + "</p>"
                    + "<p>We received your registration.</p>"
                    + "<p>Result is = " + response.result + "</p>";
                }

                console.log("After:");
                console.log(response);
              }
            }
            else {
              console.log("server fault");
            }
          }
        }

        btn.addEventListener("click", function() {
          xhr.open("POST","server.php", true);
          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          //var pack = new AddressPack("testAddress","testid",1);
          //let pack = await myFunction("<?php echo $response['orcid'];?>");
          let orcid = "<?php echo $response['orcid'];?>";
          let address = myFunction("<?php echo $response['orcid'];?>").then(function(addr) {
            xhr.send("acc=" + addr + "&orcid=" + orcid);
          });
          //xhr.send("acc=" + pack.account + "&orcid=" + pack.orcid + "&flag=" + pack.flag);
        });
      }
    </script>
  </head>
  <body>
    <div class="container">
      <div class="masthead">
        <ul class="nav nav-pills pull-right">
          <li><a href="index.php">Home</a></li>
          <li><a href="https://orcid.org/about" target="_blank">About ORCID</a></li>
          <li><a href="https://orcid.org/help/contact-us" target="_blank">Contact ORCID</a></li>
        </ul>
        <h3 class="muted">ORCID @ eBlocBroker</h3>
      </div>

      <hr />

      <div class="jumbotron">
        <h1>Thanks, <?php echo $response['name']; ?>!</h1>
        <br />
        <p class="lead">Your ORCID <img src="https://orcid.org/sites/default/files/images/orcid_16x16.png" class="logo" width='16' height='16' alt="iD"/> is <a href="<?php echo ENV; ?>/<?php echo $response['orcid']; ?>" target="_blank"><?php echo ENV; ?>/<?php echo $response['orcid']; ?></a></p>
        <!--<p class="lead">We received your registration. </p>-->

        <!--<button id="btn" onclick="sendItToServer('<?php echo $response['orcid'];?>')">Click here to register with your Ethereum Address</button>-->
        <button id="btn">Click here to register with your Ethereum Address</button>

        <div id="result"></div>
      </div>
      <hr />
      <script src="bootstrap/js/jquery.js"></script>
      <script src="bootstrap/js/bootstrap.min.js"></script>
    </div>
  </body>
</html>
