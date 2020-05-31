function validateForm() {
		
		var noValidation = document.getElementById("altaUsuario").novalidate;
		 
		if (!noValidation){
		
			var errorPassword = passwordValidation();
			var errorConfirm = passwordConfirmation();
        
			return (errorPassword.length==0) && (errorConfirm.length==0);
		}
		return true;
	}

	
	function passwordValidation(){
		var password = document.getElementById("pass");
		var pwd = password.value;
		var valid = true;

		
		valid = valid && (pwd.length>=8);
		
		
		var hasNumber = /\d/;
		var hasUpperCase = /[A-Z]/;
		var hasLowerCase = /[a-z]/;
		valid = valid && (hasNumber.test(pwd)) && (hasUpperCase.test(pwd)) && (hasLowerCase.test(pwd));
		
		
		if(!valid){
			var error = "Contraseña incorrecta: debe contener letras mayúsculas y minúsculas y números";
		}else{
			var error = "";
		}
	        password.setCustomValidity(error);
		return error;
	}
	
	
	function passwordConfirmation(){
		
        var password = document.getElementById("pass");
		var pwd = password.value;
		
		var passconfirm = document.getElementById("confirmpass");
		var confirmation = passconfirm.value;

		
		if (pwd != confirmation) {
			var error = "La contraseña y la confirmacion no coinciden";
		}else{
			var error = "";
		}

		passconfirm.setCustomValidity(error);

		return error;
	}