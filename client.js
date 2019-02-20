//returns a simple js object
function myFunction(orcid) {
    window.addEventListener('load', function() {
	var web3 = window.web3;
	if (typeof web3 !== 'undefined') {
	    web3js = new Web3(web3.currentProvider); // Use Mist/MetaMask's provider
	} else {
	    errorMessage="No web3!! You should consider trying MetaMask!"
	    alert('No web3 You should consider trying MetaMask!')
	    web3js = new Web3(new Web3.providers.HttpProvider("http://localhost:8545"));
	}
    });
    var account = web3.eth.accounts[0];
    flag=1;
    if (typeof account == "undefined") {
	//account = "No web3!! You should consider trying MetaMask!"
	account = ""
	flag=0;
    }
    if (orcid == "") {
	flag=0;
    }

    var myObject = {account:account, flag:flag, orcid:orcid};
    return myObject;
}

function sendItToServer(orcid) {
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

		    if (response.account == ""){
			//show the result in html page
			document.getElementById("result").innerHTML = "<p>Please login into your Ethereum Address in MetaMask</p>";
		    }
		    else if (response.orcid == "") {
			//show the result in html page
			document.getElementById("result").innerHTML = "<p>Please re-connect to your ORCID iD</p>";
		    }
		    else{
			//show the result in html page
			document.getElementById("result").innerHTML = "<p>Logged in Ethereum Address = " + response.account + "</p>"
			    +  "<p>orcid = " + response.orcid + "</p>"
			    + "<p>We received your registration.</p>"
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

    console.log("Before:");
    console.log(myFunction(orcid));

    xhr.open("POST","server.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //cast the function return orcid to JSON before sending
    xhr.send("ClientOutput=" + JSON.stringify(myFunction(orcid)));
}
