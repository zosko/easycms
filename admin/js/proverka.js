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

function validate_form(thisform) {
	with (thisform) {
	//radio
		if (validate_required(vid_radio,"Please choose radio type!")==false) {
			vid_radio.focus();
			return false;
		}
		if (validate_required(ime_radio,"Need name for radio!")==false) {
			ime_radio.focus();
			return false;
		}
		if (validate_required(link_radio,"Need link for radio!")==false) {
			link_radio.focus();
			return false;
		}
	}
}