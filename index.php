<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>ORCID Create on Demand Demo</title>
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
  </head>

  <body>
    <div class="container-narrow">
      <div class="masthead">
        <ul class="nav nav-pills pull-right">
          <li class="active"><a href="http://eblocbroker.duckdns.org/index.php">Home</a></li>
          <li><a href="https://orcid.org" target="_blank">About ORCID</a></li>
          <li><a href="https://orcid.org/help/contact-us" target="_blank">Contact ORCID</a></li>
        </ul>
        <h3 class="muted">ORCID @ eBlocBroker</h3>
      </div>

      <hr>

      <div class="jumbotron">
        <h1>Get an ORCID iD!</h1>
        <br>
        <p class="lead">Click the button below to create an ORCID iD and connect it to eBlocBroker smart contract.</p>
        <!--replace client_id and redirect_uri with your own values-->
        <a class="btn btn-large" href="https://orcid.org/oauth/authorize?client_id=APP-90R3NMFJNN5M4J84&response_type=code&scope=/authenticate&show_login=false&redirect_uri=http://eblocbroker.duckdns.org/oauth-redirect.php"><img id="orcid-id-logo" src="https://orcid.org/sites/default/files/images/orcid_24x24.png" width='24' height='24' alt="ORCID logo"/> Create a new ORCID iD</a>
        <br> <br>
        <!--replace client_id and redirect_uri with your own values-->
        <p class="lead">Already have an ORCID iD? <a href="https://orcid.org/oauth/authorize?client_id=APP-90R3NMFJNN5M4J84&response_type=code&scope=/authenticate&redirect_uri=http://eblocbroker.duckdns.org/oauth-redirect.php&show_login=true">Connect your existing ORCID iD</a>
      </div>
      <hr>
    </div>
    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
