
function is_valid_INN() {
	var INN                = $('#INN').val();
	var correct_INN_Length = $('#OPF option:selected').attr('INN_Length');
	return (INN.length == correct_INN_Length);
}

// function wait(ms){
// 	var start = new Date().getTime();
// 	var end   = start;
// 	while(end < start + ms) {
// 	  end = new Date().getTime();
//    }
//  }

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
	
	$('.validated_company_form').submit(function(event){
		event.preventDefault();

		var INN               = $('#INN').val();
		var OPF               = $('#OPF').val();
		var INN_Length        = $('#OPF option:selected').attr('INN_Length');
		var Cred_Limit_Affect = $('#SNO option:selected').attr('Cred_Limit_Affect');
		var SNO               = $('#SNO').val();
		var Date_Registr      = $('#Date_Registr').val();
		var Date_Begin_Work   = $('#Date_Begin_Work').val();
		
		if ((Date_Begin_Work == null) || (Date_Begin_Work.trim() == ''))
			$('#Date_Begin_Work').val(Date_Registr);
	
		if (Cred_Limit_Affect==0 ) {
			alert('Внимание! Компании, работающие по системе '+SNO+', не учитываются в расчете суммы кредита!');
			// Пробовал сделать magnific-popup с сообщением - не получается, оно сразу закрывается и срабатывает submit
			// message = '<b>Внимание!</b> <br>Компании, работающие по системе '+SNO+', не учитываются в расчете суммы кредита!';
			// $('#text-popup').html(message);
			// $.magnificPopup.open({
			// 	items: {
			// 		src : "#text-popup",
			// 		type: "inline"
			// 	}
			// });
		}
		
		if (!is_valid_INN()) {
			$('#error_message').html('Некорректный ИНН: для <b>'+OPF+'</b> длина должна быть <b>'+INN_Length+'</b>.');
			$('#error_message_div').show();
			return;
		}
		
		$('.validated_company_form').unbind('submit').submit();
	});


});