function validateForm() {
	var noValidation = document.getElementById("loginForm").novalidate;
	
	if (!noValidation){
		var error1 = passwordValidation();
		
		return error1.length==0;
	}
	
	return true;
	
}

function passwordValidation(){
		var password = document.getElementById("pass");
		var pwd = password.value;
		var valid = true;

		valid = valid && (pwd.length>=8);
		
		var hasNumber = /\d/;
		var hasUpperCases = /[A-Z]/;
		var hasLowerCases = /[a-z]/;
		valid = valid && (hasNumber.test(pwd)) && (hasUpperCases.test(pwd)) && (hasLowerCases.test(pwd));
		
		if(!valid){
			var error = "Contraseña incorrecta: debe contener letras mayúsculas y minúsculas y números";
		}else{
			var error = "";
		}
	        password.setCustomValidity(error);
		return error;
	}
