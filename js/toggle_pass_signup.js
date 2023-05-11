const togglePassword = document.querySelector('#togglePassword');
	const password_signup = document.querySelector('#inputPassword1');
	togglePassword.addEventListener('click', function (e) {
		// toggle the type attribute
		const type = password_signup.getAttribute('type') === 'password' ? 'text' : 'password';
		password_signup.setAttribute('type', type);
		// toggle the eye icon
		const icon = this.querySelector('#eye_icon');
		icon.classList.toggle('fa-eye');
		icon.classList.toggle('fa-eye-slash');
	}
	);