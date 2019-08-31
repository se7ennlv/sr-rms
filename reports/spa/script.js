$('.datepicker').datepicker({
	todayHighlight: true,
	format: 'yyyy-m-d',
	autoclose: 'true'
});
function spaWeeklyReport() {
	$.post('./pages/weekly.php', $('#frmAttd').serialize(), function(response) {
		$('#tableRespone').html(response);
	});
}


function spaMonthlyReport() {
	$.post('./pages/monthly.php', $('#frmAttd').serialize(), function(response) {
		$('#tableRespone').html(response);
	});
}
function spaSummaryReport() {
	$.post('./pages/monthly.php', $('#frmAttd').serialize(), function(response) {
		$('#tableRespone').html(response);
	});
}

function spaRawReport() {
	if ($('#frmAttd').smkValidate()) {
		$.post('./pages/Raw.php', $('#frmAttd').serialize(), function(response) {
			$('#tableRespone').html(response);
		});
	}
	
}

// $('#spaRawReport').on('click', function(e) {
// 	if ($('#frmAttd').smkValidate()) {
// 		$.post('./pages/Raw.php', $('#frmAttd').serialize(), function(response) {
// 			$('#tableRespone').html(response);
// 		});
// 	}
// 	e.preventDefault();
// });
