<?php
// Пользователи
$users = [
	['id' => 1, 'name' => 'Boris', 'email' => 'russia@aka.com'],
	['id' => 2, 'name' => 'Britva', 'email' => 'russia@aka.com']
];

// Чтение данных из POST-запроса
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

$answer = function (bool $success, string $error) use ($email) {
	// Логирование попытки регистрации
	$filename = __DIR__ . '/logs/registration.log';
	file_put_contents($filename, date('Y-m-d H:i:s') . " - Попытка регистрации для $email - " . ($success ? "Success\n" : "Rejected - $error\n"), FILE_APPEND);

	echo json_encode(['success' => $success, 'error' => $error]);
	exit;
};

// Валидация
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$answer(false, 'Неверный формат email');
}
if (strlen($password) < 8) {
	$answer(false, 'Пароль должен быть не менее 8 символов');
}
if (!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $password)) {
	$answer(false, 'Пароль должен содержать и буквы, и цифры');
}
if ($password !== $confirmPassword) {
	$answer(false, 'Пароли не совпадают');
}
if (empty(trim($firstName)) || empty(trim($lastName))) {
	$answer(false, 'Имя и фамилия не могут быть пустыми');
}

// Проверка на существование пользователя с таким email
foreach ($users as $user) {
	if ($user['email'] === $email) {
		$answer(false, 'Email уже зарегистрирован');
	}
}

// Если все проверки пройдены
$answer(true, '');
