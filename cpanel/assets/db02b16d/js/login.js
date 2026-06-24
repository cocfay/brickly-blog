$('.recover-link').click(function(e){
	let step = $('.recover-continue').data('step');
	if(step == 'finish'){
		$('.recover-continue').data('step','user');
		$('.recover-continue').html('Continuar');
		$('.recover-continue').css({display : 'unset'});
		$('.recover-pass-user').css({display : 'unset'});
		$('.recover-pass-code').css({display : 'none'});
		$('.recover-pass-newpass').css({display : 'none'});
		$('.recover-pass-finish').css({display : 'none'});

	}
})

$('.recover-continue').click(function(e){
	var btnClick = $(this);
	btnClick.html('<i class="fas fa-spinner fa-spin"></i>');
	btnClick.attr('disabled',true);
	let step = btnClick.data('step');
	let usrdat = $('#userinp-recover').val();
	let codedat = $('#codeinp-recover').val();
	let passdat = $('#passwordinp-recover').val();

	let txtBTN = 'Continuar';

	console.log(step)
	switch(step){
		case 'user' :

			if(usrdat == undefined || usrdat == ''){
				NotifyAlert({ type : 'warning' , title : '¡Advertencia!' , msg : 'No puede dejar el campo vacio' });
				btnClick.html(txtBTN);
				btnClick.attr('disabled',false);
				return true;
			}
			$.post('recover/recoveraccess',{user : usrdat},function(r){

				if(r.error){
					NotifyAlert({ type : 'warning' , title : '¡Advertencia!' , msg : r.message });
				}else{
					$('#coreo-verificacion').text(r.data.email);
					$('.recover-pass-user').hide('slow',function(){
						$('.recover-pass-code').show('slow');
						btnClick.data('step','code');
						// $('.recover-pass-newpass')
					})

				}
						
			})
		break;
		case 'code':

			if(codedat == undefined || codedat == ''){
				NotifyAlert({ type : 'warning' , title : '¡Advertencia!' , msg : 'No puede dejar el campo vacio' });
				btnClick.html(txtBTN);
				btnClick.attr('disabled',false);
				return true;
			}

			$.post('recover/recoveraccess',{user : usrdat,code: codedat},function(r){

				if(r.error){
					NotifyAlert({ type : 'warning' , title : '¡Advertencia!' , msg : r.message });
				}else{
					
					$('.recover-pass-code').hide('slow',function(){
						$('.recover-pass-newpass').show('slow');
						btnClick.data('step','pass');
						txtBTN = 'Cambiar Contraseña';
						// $('.recover-pass-newpass')
					})

				}
						
			})

		break;

		case 'pass':
			if(passdat == undefined || passdat == ''){
				NotifyAlert({ type : 'warning' , title : '¡Advertencia!' , msg : 'No puede dejar el campo vacio' });
				btnClick.html(txtBTN);
				btnClick.attr('disabled',false);
				return true;
			}

			$.post('recover/recoveraccess',{user : usrdat,code: codedat,pass : passdat},function(r){

				if(r.error){
					NotifyAlert({ type : 'warning' , title : '¡Advertencia!' , msg : r.message });
				}else{
					
					$('.recover-pass-newpass').hide('slow',function(){
						$('.recover-pass-finish').show('slow');
						btnClick.data('step','finish');
						btnClick.css({display : 'none'});
						// $('.recover-pass-newpass')
					})

				}
						
			})

		break;
	}
	btnClick.html(txtBTN);
	btnClick.attr('disabled',false);
	//BOX STEPS
	//$('.recover-pass-user')
	//$('.recover-pass-code')
	// $('.recover-pass-newpass')

})



  function NotifyAlert($options_){
	$_options = { type : 'warning' , title : '' , msg : '' , icon: false };

	$options = $.extend({}, $_options, $options_);

	if($options.icon === false){
		switch($options.type){
			case 'success':
				$options.icon = 'glyphicon glyphicon-check'
			break;
			default:
				$options.icon = 'glyphicon glyphicon-warning-sign'
			break;
		}
	}

	$.notify({
    // options
        icon: $options.icon,
        title: $options.title,
        message: $options.msg 
    },{
        offset: 20,
        spacing: 10,
        type: $options.type,
        allow_dismiss: true,
        mouse_over: 'pause',
        animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
        delay: 5000,
        timer: 1000,
    });
}
