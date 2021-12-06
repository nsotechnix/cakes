function setstaff_present_address(){
	if ($("#homepostalcheck").is(":checked")) {
		$('#staff_present_address').val($('#staff_permenent_address').val());
		$('#staff_present_address').attr('enable', 'enable');
	} else {
		$('#staff_present_address').removeAttr('enable');
	}
	}

	$('#homepostalcheck').click(function(){
	setstaff_present_address();
	})