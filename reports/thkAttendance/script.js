$('.datepicker').datepicker({
	todayHighlight: true,
	format: 'yyyy-m-d',
	autoclose: 'true'
});

var $deptName = $('#deptName').text().trim();

function RawAction() {
	if ($deptName != '') {
		if ($('#frmAttd').smkValidate()) {
			$.ajax({
				url: './pages/raw.php',
				data: $('#frmAttd').serialize(),
				type: 'POST',
				success: function(data) {
					$('#tblRespone').html(data);
				}
			});
		}
	} else {
		alert('Please input department name into your account info!');
	}

	return false;
}

function HrRawAction() {
	if ($deptName != '') {
		if ($('#frmAttd').smkValidate()) {
			$.ajax({
				url: './pages/hr_raw.php',
				data: $('#frmAttd').serialize(),
				type: 'POST',
				success: function(data) {
					$('#tblRespone').html(data);
				}
			});
		}
	} else {
		alert('Please input department name into your account info!');
	}

	return false;
}

function CompleteFailAction() {
	if ($deptName != '') {
		if ($('#frmAttd').smkValidate()) {
			$.post('./pages/complete_fail.php', $('#frmAttd').serialize(), function(response) {
				$('#tblRespone').html(response);
			});
		}
	} else {
		alert('Please input department name into your account info!');
	}

	return false;
}

function SuccessAction() {
	if ($deptName != '') {
		if ($('#frmAttd').smkValidate()) {
			$.post('./pages/success.php', $('#frmAttd').serialize(), function(response) {
				$('#tblRespone').html(response);
			});
		}
	} else {
		alert('Please input department name into your account info!');
	}

	return false;
}

function FailAction() {
	if ($deptName != '') {
		if ($('#frmAttd').smkValidate()) {
			$.post('./pages/fail.php', $('#frmAttd').serialize(), function(response) {
				$('#tblRespone').html(response);
			});
		}
	} else {
		alert('Please input department name into your account info!');
	}

	return false;
}

function DeductionAction() {
	if ($deptName != '') {
		if ($('#frmAttd').smkValidate()) {
			$.post('./pages/attd_deduction.php', $('#frmAttd').serialize(), function(response) {
				$('#tblRespone').html(response);
			});
		}
	} else {
		alert('Please input department name into your account info!');
	}

	return false;
}
function DeductionResignAction() {
	if ($deptName != '') {
		if ($('#frmAttd').smkValidate()) {
			$.post('./pages/attd_deduction_resign.php', $('#frmAttd').serialize(), function(response) {
				$('#tblRespone').html(response);
			});
		}
	} else {
		alert('Please input department name into your account info!');
	}

	return false;
}

function NormVsRms() {
	if ($deptName != '') {
		if ($('#frmAttd').smkValidate()) {
			$.post('./pages/norm_vs_rms.php', $('#frmAttd').serialize(), function(response) {
				$('#tblRespone').html(response);
			});
		}
	} else {
		alert('Please input department name into your account info!');
	}

	return false;
}

function btnActiveStaff() {
	$.post('./pages/active_staff.php', $('#frmAttd').serialize(), function(response) {
		$('#tblRespone').html(response);
	});
	return false;
}

$('#btnRemoveDupData').on('click', function(e) {
	if ($('#frmAttd').smkValidate()) {
		$.post('./pages/remove_dups.php', $('#frmAttd').serialize(), function(response) {
			$('#tblRespone').html(response);
		});
	}
	e.preventDefault();
});

// $('#btnActiveStaff').on('click', function(e) {
// 	$.post('./pages/active_staff.php', $('#frmAttd').serialize(), function(response) {
// 		$('#tblRespone').html(response);
// 	});

// 	e.preventDefault();
// });

$(document)
	.ajaxStart(function() {
		$.blockUI({
			message:
				'\n\
                    <span style="font-size: 16px">Please await...</span>\n\
                    <div class="progress" style="border-radius: 0px; margin-top: 5px;">\n\
                        <div class="progress-bar progress-bar-striped active" \n\
                            role="progressbar"\n\
                            style="width:100%;">\n\
                        </div>\n\
                    </div>'
		});
	})
	.ajaxStop($.unblockUI);
