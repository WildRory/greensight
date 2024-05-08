function submitForm() {
	var formData = {
		firstName: $('#firstName').val(),
		lastName: $('#lastName').val(),
		email: $('#email').val(),
		password: $('#password').val(),
		confirmPassword: $('#confirmPassword').val()
	}

	var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/ // Простая проверка формата email
	var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/ // Минимум 8 символов, хотя бы одна цифра, одна заглавная и одна строчная буква

	if (!emailRegex.test(formData.email)) {
		$('#error-message').text('Некорректный формат email').addClass('alert alert-danger')
		return
	}
	if (!passwordRegex.test(formData.password)) {
		$('#error-message').text('Пароль должен содержать минимум 8 символов, включая цифры, заглавные и строчные латинские буквы').addClass('alert alert-danger')
		return
	}
	if (formData.password !== formData.confirmPassword) {
		$('#error-message').text('Введенные пароли не совпадают').addClass('alert alert-danger')
		return
	}

	$.ajax({
		type: "POST",
		url: "register.php",
		data: formData,
		success: function (response) {
			var data = JSON.parse(response)
			if (data.success) {
				$('#registration-form').hide()
				$('#error-message').text('Регистрация успешно завершена!').removeClass('alert-danger').addClass('alert alert-success')
			} else {
				$('#error-message').text(data.error).addClass('alert alert-danger')
			}
		}
	})
}