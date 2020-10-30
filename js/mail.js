	function validate_required(field,alerttxt) {
	with (field) {
		if (value==null||value=="") {
			alert(alerttxt);
			return false;
		}
		else {
			return true;
		}
	}
}

function validate_email(field,alerttxt) {
	with (field) {
		apos=value.indexOf("@")
		dotpos=value.lastIndexOf(".")
		if (apos<1||dotpos-apos<2) {
			alert(alerttxt);
			return false;
		} else {
			return true;
		}
	}
}

function validate_form(thisform) {
	with (thisform) {
		if (validate_required(ime,"Please specify your name!")==false) {
			ime.focus();
			return false;
		}
		if (validate_required(email,"Email must be filled out!")==false) {
			email.focus();
			return false;
		}
		if (validate_email(email,"Not a valid e-mail address!")==false) {
			email.focus();
			return false;
		}
		if (validate_required(poraka,"Forgot message?!")==false) {
			poraka.focus();
			return false;
		}
	}
}