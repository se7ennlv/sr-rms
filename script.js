var userId = $('#userId').text().trim();
var rptName;

$(document).ready(function() {
	$('#frmLogin').on('submit', function(e) {
		e.preventDefault();

		$.ajax({
			method: 'POST',
			url: 'controllers/login.php',
			data: $(this).serialize()
		}).done(function(data) {
			if (data.status === 'success') {
				$.smkAlert({ text: data.message, type: data.status });
				window.location = './';
			} else {
				$.smkAlert({ text: data.message, type: data.status });
				$.unblockUI();
			}
		});
	});
});

function reportAction(id, urls) {
	$.ajax({
		method: 'POST',
		url: 'controllers/rpt_auth.php',
		data: {
			userId: userId,
			rptName: rptName
		}
	}).done(function(data) {
		var idmenu = data.message;
		var condition;
		if (idmenu.length > 0) {
			$.each(idmenu.split(','), function(index, value) {
				console.log(value);

				if (value == id) {
					window.location.href = urls + '?group_id=' + id + '';
					$.unblockUI();
					$.post('./controllers/log.php?userId=' + userId + '&rptName=' + rptName);
					condition = true;
				}
			});
			if (condition != true) {
				swal({
					type: 'warning',
					title: 'Sorry!',
					text: 'You do not have permission, Please contact IT',
					showConfirmButton: true
				});
				$.unblockUI();
			}
		} else {
			swal({
				type: 'warning',
				title: 'Sorry!',
				text: 'You do not have permission, Please contact IT',
				showConfirmButton: true
			});
			$.unblockUI();
		}
	});

	return false;
}

function AddUser() {
	$.ajax({
		url: 'pages/AddUsers.php',
		success: function(data) {
			$('#mainContent').html(data);
		}
	});

	return false;
}

function LogAccessSystem() {
	$.ajax({
		url: 'pages/Log.php',
		success: function(data) {
			$('#mainContent').html(data);
		}
	});

	return false;
}

function updatePwd() {
	$.ajax({
		url: 'pages/UpdatePwd.php',
		success: function(data) {
			$('#mainContent').html(data);
		}
	});

	return false;
}

/*============================================================================*/
$(document).ready(function() {
	$('#formAddUsers').on('submit', function(e) {
		// if ($('#formAddUsers').smkValidate()) {
		// 	$.post('./controllers/phpAddUsers.php', $('#formAddUsers').serialize()).done(function(data) {
		// 		if (data.status === 'success') {
		// 			$.smkAlert({ text: data.message, type: data.status });
		// 			$('#formAddUsers').smkClear();
		// 		} else {
		// 			$.smkAlert({ text: data.message, type: data.status });
		// 		}
		// 	});
		// }
		console.log('123123');

		e.preventDefault();
	});

	$('#formUpdatePwd').on('submit', function(e) {
		$.post('./controllers/change_password.php', $('#formUpdatePwd').serialize()).done(function(data) {
			if (data.status === 'success') {
				$.smkAlert({ text: data.message, type: data.status });
				$('#formUpdatePwd').smkClear();
			} else {
				$.smkAlert({ text: data.message, type: data.status });
			}
		});
		e.preventDefault();
	});
});

/*=====================================================================*/
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

/*=====================================================================*/
$('.modal').on('hidden.bs.modal', function() {
	$(this).find('form').trigger('reset');
});

$('.datepicker').datepicker({
	todayHighlight: true,
	format: 'yyyy-mm-dd',
	autoclose: 'true'
});

/*------------------------------------------------------------------------*/
var data = Array();
function checkBoxgroup_id(id) {
	//	console.log($('#checkBoxgroup_id' + id + ':checked').val());
	var check = $('#checkBoxgroup_id' + id + '').is(':checked');
	console.log(check);
	if (check == false) {
		$('.groupx' + id + '').prop('checked', false);
	} else {
		$('.groupx' + id + '').prop('checked', true);
	}
}

function SaveAddUser() {
	var menus = [];
	$('.group_idx:checked').each(function() {
		menus.push($(this).val());
	});
	//	console.log(menus);
	var group = [];
	$('.grouploop:checked').each(function() {
		group.push($(this).val());
	});
	//	console.log(group);

	// $.post(
	// 	'./controllers/add_user.php',
	// 	'menu=' + menus + '&group=' + group + '&' + $('#formAddUsers').serialize() + ''
	// ).done(function(data) {
	// 	if (data.status === 'success') {
	// 		$.smkAlert({ text: data.message, type: data.status });
	// 		$('#formAddUsers').smkClear();
	// 	} else {
	// 		$.smkAlert({ text: data.message, type: data.status });
	// 	}
	// });

	if ($('#formAddUsers').smkValidate()) {
		$.post(
			'./controllers/add_user.php',
			'menu=' + menus + '&group=' + group + '&' + $('#formAddUsers').serialize() + ''
		).done(function(data) {
			if (data.status === 'success') {
				$.smkAlert({ text: data.message, type: data.status });
				$('#formAddUsers').smkClear();
			} else {
				$.smkAlert({ text: data.message, type: data.status });
			}
		});
	}

	//console.log($('#formAddUsers').serialize());
}
