$(document).ready(function(){
	var alertConfirmColor = "#000000";
	var alertCancelColor = "#3a3a3a";

	if(!$("#sweetalert-cpanel-button-theme").length){
		$("head").append('<style id="sweetalert-cpanel-button-theme">.sweet-alert button.cancel,.sweet-alert button.cancel:hover,.sweet-alert button.cancel:focus,.sweet-alert button.cancel:active{background-color:' + alertCancelColor + ' !important;color:#ffffff !important;}.sweet-alert button.confirm,.sweet-alert button.confirm:hover,.sweet-alert button.confirm:focus,.sweet-alert button.confirm:active{background-color:' + alertConfirmColor + ' !important;color:#ffffff !important;}</style>');
	}

///alert Confirm Eliminar
	$(document).on("click",".click-confirm",function(e){
		var c = $(this);
		e.preventDefault();

		if(c.attr("tittle-alert") == undefined){
			var tittle = "Warning";
		}else{var tittle = c.attr("tittle-alert"); }

		if(c.attr("text-alert") == undefined){
			var text = "Are you absolutely sure ?";
		}else{var text = c.attr("text-alert"); }
					swal({
		          title: tittle,
		          text:text,
		          type: "warning",
		          showCancelButton: true,
		          confirmButtonColor: alertConfirmColor,
		          confirmButtonText: "Ok",
		          cancelButtonText: "No",
		          closeOnConfirm: false,
		          closeOnCancel: true
		        },
		        function(isConfirm){
		          if (isConfirm) {
		          		if($(c).attr("href") != undefined){
		          			window.location.href =$(c).attr("href");
		          			$(".cancel").click();
		          		}else{
		          			$(c).submit();
		          			$(".cancel").click();
		          		}
		            	return false;
		          }else{
		          	return false;
		          }
		        });
	});

});


	///alert Confirm Eliminar
var _Message = function(type = "success",tittle = "Success!", message = "Process Successful!"){
	var alertConfirmColor = "#000000";
	
							  swal({
					          title: tittle,
					          text:message,
					          type: type,
					          showCancelButton: false,
					          confirmButtonColor: alertConfirmColor,
					          confirmButtonText: "Ok",
					          closeOnConfirm: true,
					          closeOnCancel: true
					        },
					        function(){
					        });
			}
	
			// _Message()
