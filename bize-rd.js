(function($) {

	function checkemail(str){
		var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
		if (filter.test(str)){
			testresults=true;
		}else{
			testresults=false
		}
		return (testresults)
	}

  $(function(){
  	$(".bize-rdstation").each(function(){
  		var thisForm = this;
  		$(thisForm).find(".submit").click(function(){
			var nome = $(thisForm).find(".nome").val();
			var email = $(thisForm).find(".email").val();

			
			var data_array = [
				{ name: 'email', value: email },
				{ name: 'identificador', value: $(thisForm).find(".conversion_id").val() },
				{ name: 'nome', value: nome },
				{ name: 'token_rdstation', value: $(thisForm).find(".token").val() }
			];

			if(nome==""){
				alert("Por favor, informe seu nome.");
				return;
			}
			if(email==""){
				alert("Por favor, informe seu e-mail.");
				return;
			}
			if(!checkemail(email)){
				alert("Por favor, informe um e-mail válido.");
				return;
			}

			RdIntegration.post(data_array, function (d,d2) { 
				if(d2=="success"){
					$(thisForm).html("<div class=\"alert alert-info\">Obrigado. Agora você receberá sempre nossas novidades também por e-mail.</div>");
				}else{
					alert("Ocorreu um problema. Cheque seu dados e tente novamente em alguns instantes.");
				}
			});
		});
  	});
  });
}(jQuery));