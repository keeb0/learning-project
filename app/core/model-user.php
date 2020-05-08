<?php
class Model_User extends Model
{
	public $user_id;
	public $login;
	public $email;
<<<<<<< HEAD
	public $role;
=======
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782
	public $avatar_name;
	public $pswd;
	public $pswd_new;
	public $pswd_conf;

	//Конструктор (присвоение свойствам класса элементы массива $user_info)
<<<<<<< HEAD
	public function __construct($user_data)
	{
		parent::__construct();

		foreach ($user_data as $key => $value)
=======
	function __construct($user_dates)
	{
		parent::__construct();

		foreach($user_dates as $key => $value)
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782
			$this->$key = $value;
	}

	// Передача данных по id для заполнения свойств объекта
<<<<<<< HEAD
	public function getData()
	{
		$stmt = self::$connection->prepare("
			SELECT login, email, avatar_name, role
=======
	function get_user_data()
	{
		$stmt = self::$connection->prepare("
			SELECT login, email, avatar_name
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782
			FROM users 
			WHERE id = '$this->user_id'
			");
		$stmt->execute();
		$result_set = $stmt->get_result();
		$stmt->close();
		$row = $result_set->fetch_array(MYSQLI_ASSOC);

		foreach ($row as $key => $value)
			$this->$key = $value;
	}

	// Запись нового пользователя
<<<<<<< HEAD
	public function create()
	{
		$successful_validate = true;
		// Указан не корректный id -1 (пользователь еще не создан)
		$existing_user = $this->getExistingUser(-1);
		$error_message['login'] = $this->validateLogin($existing_user['login']);
		$error_message['email'] = $this->validateEmail($existing_user['email']);
		$error_message['pswd'] = $this->validatePswd();

		foreach ($error_message as $key => $value) {
=======
	function create_user()
	{
		$successful_validate = true;
		$exists_user = $this->get_exists_user_data(-1);
		$error_messege['login'] = $this->validateLogin($exists_user['login']);
		$error_messege['email'] = $this->validateEmail($exists_user['email']);
		$error_messege['pswd'] = $this->validatePswd();

		foreach ($error_messege as $key => $value) 
			{
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782
				if(!empty($value))
				{
					$successful_validate = 0;
					break;
				}
			}
		
<<<<<<< HEAD
		if ($successful_validate) {
=======
		if($successful_validate)
		{
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782
			$this->pswd_new = password_hash($this->pswd_new, PASSWORD_DEFAULT);
			$stmt = self::$connection->prepare("
				INSERT INTO users (id, login, email, password) 
				VALUES (NULL , ?, ?, ?)
				");
			$stmt->bind_param('sss', $this->login, $this->email, $this->pswd_new);
			$stmt->execute();

			$_SESSION['user_id'] = self::$connection->insert_id;
			setcookie('checkIn', true, time() + 3);
			return 1;
		}
		else
<<<<<<< HEAD
			return $error_message;
	}

	// Редактирование данных пользователем
	public function updateData($user_id)
	{
		$successful_validate = 1;

		$existing_user = $this->getExistingUser($user_id);
		$error_message['login'] = $this->validateLogin($existing_user['login']);
		$error_message['email'] = $this->validateEmail($existing_user['email']);

		foreach ($error_message as $key => $value) {
=======
			return $error_messege;
	}

	// Редактирование данных пользователем
	function update_data($user_id)
	{
		$exists_user = $this->get_exists_user_data($user_id);
		$error_messege['login'] = $this->validateLogin($exists_user['login']);
		$error_messege['email'] = $this->validateEmail($exists_user['email']);
		$successful_validate = 1;

		foreach ($error_messege as $key => $value) 
		{
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782
			if(!empty($value))
			{
				$successful_validate = 0;
				break;
			}
		}
	
<<<<<<< HEAD
		if ($successful_validate) {
			foreach ($this as $key => $value)
			{
				if (!empty($value) && $key != 'data_updating') {
=======
		if($successful_validate)
		{
			foreach ($this as $key => $value)
			{
				if(!empty($value) && $key != 'data_updating')
				{
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782
					$stmt = self::$connection->prepare("UPDATE users SET $key = ? WHERE id = '$user_id'");
					$stmt->bind_param('s', $value);
					$stmt->execute();
				}
			}
			header("Location: profile");
		}
		else
<<<<<<< HEAD
			return $error_message;
	}

	public function updatePswd($user_id)
	{
		$error_message['pswd'] = $this->validatePswd();
		if (empty($error_message['pswd'])) {
=======
			return $error_messege;
	}

	function update_pswd($user_id)
	{
		$error_messege['pswd'] = $this->validatePswd();
		if(empty($error_messege['pswd']))
		{
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782
			$this->pswd_new = password_hash($this->pswd_new, PASSWORD_DEFAULT);
			$stmt = self::$connection->prepare("UPDATE users SET password = ? WHERE id = '$user_id'");
			$stmt->bind_param('s', $this->pswd_new);
			$stmt->execute();
			header("Location: profile");
		}
		else
<<<<<<< HEAD
			return $error_message;
	}

	// Проверка незанятости login и email во время редактиривания
	public function getExistingUser($user_id)
=======
			return $error_messege;
	}

	// Проверка незанятости login и email во время редактиривания
	function get_exists_user_data($user_id)
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782
	{
		$stmt = self::$connection->prepare("
			SELECT email, login 
			FROM users 
			WHERE id <> '$user_id' 
				AND (login = '$this->login' 
				OR email = '$this->email')
			");
		$stmt->execute();
		$result_set = $stmt->get_result();
		$row = $result_set->fetch_assoc();
		return $row;
	}

	// Проверка введных данных при входе
<<<<<<< HEAD
	public function verifyPswd()
	{
		$stmt = self::$connection->prepare("
			SELECT id, role, password
=======
	function verify_pswd()
	{
		$stmt = self::$connection->prepare("
			SELECT id, password 
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782
				AS 'hash'
			FROM users
			WHERE login = ?
			");
		$stmt->bind_param('s', $this->login);
		$stmt->execute();
		$result_set = $stmt->get_result();
		$row = $result_set->fetch_assoc();

<<<<<<< HEAD
		if (password_verify($this->pswd, $row['hash'])) 
			return [
				'id' => $row['id'],
				'role'=> $row['role']
			];
=======
		if(password_verify($this->pswd, $row['hash'])) 
			return $row['id'];
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782
		else
			return false;
	}

<<<<<<< HEAD
	public function validateLogin($login)
	{
		if ($this->login == '')
			return' Заполните поле логин';
		elseif (preg_match('/\W/', $this->login))
			return 'Логин может включать латинские буквы (a-z), цифры (0-9) и знак _';
		elseif ($login == $this->login)
			return 'Пользователь с таким логином уже существует!';
	}

	public function validateEmail($email)
	{
		if ($this->email == '')
			return 'Заполните поле e-mail';
		elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
			return 'Неверная электронная почта!';
		elseif ($email == $this->email)
			return 'Пользователь с таким e-mail уже существует!';
	}

	public function validatePswd()
	{
		if (strlen($this->pswd_new) < 1)
			return 'Введите новый пароль';
		elseif (strlen($this->pswd_new) < 6)
=======
	function validateLogin($exists_login)
	{
		if($this->login == '')
			return' Заполните поле логин';
		elseif(preg_match('/\W/', $this->login))
			return 'Логин может включать латинские буквы (a-z), цифры (0-9) и знак _';
		elseif($exists_login == $this->login)
			return 'Пользователь с таким логином уже существует!';
	}

	function validateEmail($exists_email)
	{
		if($this->email == '')
			return 'Заполните поле e-mail';
		elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
			return 'Неверная электронная почта!';
		elseif($exists_email == $this->email)
			return 'Пользователь с таким e-mail уже существует!';
	}

	function validatePswd()
	{
		if(strlen($this->pswd_new) < 1)
			return 'Введите новый пароль';
		elseif(strlen($this->pswd_new) < 6)
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782
			return 'Пароль должен содержать не меньше 6 символов!';

		// Код рабочий, временно отключен
		// elseif(!(preg_match('/[a-z]/', $this->pswd_new) &&
		// 	preg_match('/[A-Z]/', $this->pswd_new) &&
		// 	preg_match('/[0-9]/', $this->pswd_new)))
		// 	return 'Пароль должен содержать по одному из символов (a-z), (A-Z), (0-9)';
<<<<<<< HEAD
		elseif ($this->pswd_new != $this->pswd_conf)
=======
		elseif($this->pswd_new != $this->pswd_conf)
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782
			return 'Пароли не совпадают!';
		return '';
	}
}