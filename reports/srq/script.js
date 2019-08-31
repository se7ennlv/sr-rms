$(function() {
	$('.datepicker').datepicker({
		todayHighlight: true,
		format: 'yyyy-m-d',
		autoclose: 'true'
	});
});

function GetRawData() {
	if ($('#frmSrq').smkValidate()) {
		$.ajax({
			method: 'POST',
			url: 'pages/raw_data.php',
			data: $('#frmSrq').serialize()
		}).done(function(data) {
			$('#dynamic-table').html(data);
		});
	}

	return false;
}

$(document).ready(function() {
	var d = new Date();
	var strDate = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate();
	$('input[name=fromDate]').val(strDate);
	$('input[name=toDate]').val(strDate);
	GetRawData();
});
