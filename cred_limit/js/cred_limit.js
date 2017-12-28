
//**********************************************************************************************
//Код выполняется после загрузки всего содержимого документа
//**********************************************************************************************
$(document).ready(function() {
	
	$('#btnError_message').click(function(){
		$('#error_message_div').hide();
	}
	);

	if ($('#error_message').text() != "NO_ERRORS")
		$('#error_message_div').show();
	
	$('#btnAddCompany').click(function(){
		INN               = $('#INN').val();
		OPF               = $('#OPF').val();
		INN_Length        = $('#OPF option:selected').attr('INN_Length');
		Cred_Limit_Affect = $('#SNO option:selected').attr('Cred_Limit_Affect');
		SNO               = $('#SNO').val();

		alert("Длина ИНН для "+OPF+" должна быть "+INN_Length+".");
		if (Cred_Limit_Affect==0 )
			alert("Компании, работающие по системе "+SNO+", не учитываются в расчете суммы кредита!")

	});

	$('#add_form').submit(function() {
		return false;
	}
	);

});