<?php
class Model_User extends Model
{
	public $user_id;
	public $login;
	public $email;
	public $avatar_name;
	public $pswd;
	public $pswd_new;
	public $pswd_conf;

	//Конструктор (присвоение свойствам класса элементы массива $user_info)
	function __construct($user_dates)
	{
		parent::__construct();

		foreach($user_dates as $key => $value)
			$this->$key = $value;
	}

	// Передача данных по id для заполнения свойств объекта
	function get_user_data()
	{
		$stmt = self::$connection->prepare("
			SELECT login, email, avatar_name
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
	function create_user()
	{
		$successful_validate = true;
		$exists_user = $this->get_exists_user_data(-1);
		$error_messege['login'] = $this->validateLogin($exists_user['login']);
		$error_messege['email'] = $this->validateEmail($exists_user['email']);
		$error_messege['pswd'] = $this->validatePswd();

		foreach ($error_messege as $key => $value) 
			{
				if(!empty($value))
				{
					$successful_validate = 0;
					break;
				}
			}
		
		if($successful_validate)
		{
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
			if(!empty($value))
			{
				$successful_validate = 0;
				break;
			}
		}
	
		if($successful_validate)
		{
			foreach ($this as $key => $value)
			{
				if(!empty($value) && $key != 'data_updating')
				{
					$stmt = self::$connection->prepare("UPDATE users SET $key = ? WHERE id = '$user_id'");
					$stmt->bind_param('s', $value);
					$stmt->execute();
				}
			}
			header("Location: profile");
		}
		else
			return $error_messege;
	}

	function update_pswd($user_id)
	{
		$error_messege['pswd'] = $this->validatePswd();
		if(empty($error_messege['pswd']))
		{
			$this->pswd_new = password_hash($this->pswd_new, PASSWORD_DEFAULT);
			$stmt = self::$connection->prepare("UPDATE users SET password = ? WHERE id = '$user_id'");
			$stmt->bind_param('s', $this->pswd_new);
			$stmt->execute();
			header("Location: profile");
		}
		else
			return $error_messege;
	}

	// Проверка незанятости login и email во время редактиривания
	function get_exists_user_data($user_id)
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
	function verify_pswd()
	{
		$stmt = self::$connection->prepare("
			SELECT id, password 
				AS 'hash'
			FROM users
			WHERE login = ?
			");
		$stmt->bind_param('s', $this->login);
		$stmt->execute();
		$result_set = $stmt->get_result();
		$row = $result_set->fetch_assoc();

		if(password_verify($this->pswd, $row['hash'])) 
			return $row['id'];
		else
			return false;
	}

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
			return 'Пароль должен содержать не меньше 6 символов!';

		// Код рабочий, временно отключен
		// elseif(!(preg_match('/[a-z]/', $this->pswd_new) &&
		// 	preg_match('/[A-Z]/', $this->pswd_new) &&
		// 	preg_match('/[0-9]/', $this->pswd_new)))
		// 	return 'Пароль должен содержать по одному из символов (a-z), (A-Z), (0-9)';
		elseif($this->pswd_new != $this->pswd_conf)
			return 'Пароли не совпадают!';
		return '';
	}
}