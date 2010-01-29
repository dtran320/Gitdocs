/**
 * Ajax post to sign in
 */
function signInUser(evt) {
	evt.preventDefault();
	$("#login").ajaxSubmit({
		url: "actions/signin.php",
		success: processSignIn
	});
}

function processSignIn(data) {
	if(data=="SUCCESS") {
    	window.location = "index.php";
	}
	else {
		$("#login_error").html("Incorrect email/password combination.");
		$("#login_error").addClass("error");
	}		
}

function signUpUser(evt) {
	evt.preventDefault();
	$("#signup").ajaxSubmit({
		url: "actions/signup.php",
		success: processSignUp
	});
}

function processSignUp(data) {
	if(data=="SUCCESS") {
		window.location="index.php"
	}
	else { //should eventually capture errors
		$("#signup_error").html("Error with your signup");
		$("#signup_error").addClass("error");
	}
}
