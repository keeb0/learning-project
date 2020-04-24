<?php
class Model_Guest extends Model
{
	public $login;
	public $pswd;
	public $pswd_conf;
	public $email;

	//Конструктор (присвоение свойствам класса элементы массива $user_info)s
	function __construct($user_dates)
	{
		foreach($this as $key => $value)
		{
			list(,$this->$key) = each($user_dates);
		}
	$this->connection = new mysqli('localhost', 'admin', '123456', 'chat');
	}

	// Проверка незанятости login и email другим пользователем	
	function get_login_email()
	{
		$stmt = $this->connection->prepare("
			SELECT login, email
			FROM users
			WHERE login = ?
				OR email = ?");
		$stmt->bind_param('ss', $this->login, $this->email);
		$stmt->execute();
		$result_set = $stmt->get_result();
		$row = $result_set->fetch_assoc(); 

		return $row;
	}

	// Запись нового пользователя
	function create_user()
	{
		$check_coincidence_res = $this->get_login_email();

		if((empty($this->login) or empty($this->email))) 
			return "Заполните обязательные поля!";

		elseif (strlen($this->pswd) < 6)
			return "Пароль должен содержать не меньше 6 символов!";

		elseif($this->pswd != $this->pswd_conf)
			return "Пароли не совпадают!";

		elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
			return "Неверная электронная почта!";

		elseif($check_coincidence_res["login"] == $this->login)
			return "Пользователь с таким логином уже существует!";

		elseif($check_coincidence_res["email"] == $this->email)
			return "Пользователь с таким email уже существует!";

		else
		{
			$this->pswd = password_hash($this->pswd, PASSWORD_DEFAULT);
			$stmt = $this->connection->prepare("
				INSERT INTO users (id, login, email, password) 
				VALUES (NULL , ?, ?, ?)
				");
			$stmt->bind_param('sss', $this->login, $this->email, $this->pswd);
			$stmt->execute();

			$_SESSION['user_id'] = $this->connection->insert_id;
			setcookie('checkIn', true, time() + 3);
			return 1;
		}
	}

	// Проверка введных данных при входе
	function verify()
	{
		$stmt = $this->connection->prepare("
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
		{
			$_SESSION['user_id'] = $row['id'];
			return 1;
		}
		else
			return "Неверный логин или пароль!";
	}
}

class Model_User extends Model_Guest
{
	public $id;
	public $avatar_name;

	// Передача данных по id для заполнения свойств объекта
	function get_user_data()
	{
		$stmt = $this->connection->prepare("
			SELECT login, email, avatar_name
			FROM users 
			WHERE id = '$this->id'
			");
		$stmt->execute();
		$result_set = $stmt->get_result();
		$row = $result_set->fetch_array(MYSQLI_ASSOC);

		foreach ($row as $key => $value)
		{
			$this->$key = $value;
		}
		$this->connection->close();
	}
}

class Model_User_Edit
{
	public $login;
	public $email;
	public $pswd_old;
	public $pswd;
	public $pswd_conf;
	protected $connection;
	
	function __construct($user_dates)
	{
		foreach($this as $key => $value)
		{
			list(,$this->$key) = each($user_dates);
		}
		$this->connection = new mysqli('localhost', 'admin', '123456', 'chat');
	}

	// Проверка незанятости login и email во время редактиривания
	function GetInfoForEdit($user_id)
	{
		$stmt = $this->connection->prepare("
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

	// Редактирование данных пользователем
	function update_info($user_id, $user_login)
	{
		$stmt = $this->connection->prepare("
			SELECT password 
				AS 'hash' 
			FROM users 
			WHERE login = '$user_login'
			");
		$stmt->execute();
		$result_set = $stmt->get_result();
		$row = $result_set->fetch_assoc();

		$check_pswd = true;
		$check_coincidence_res = $this->GetInfoForEdit($user_id);
		if(!empty($this->pswd) or !empty($this->pswd_conf))
		{
			if(!(password_verify($this->pswd_old, $row['hash'])))
				{
					$check_pswd = false;
					return "Неверный пароль! Повторите еще раз";
				}

			elseif (strlen($this->pswd) < 6)
				{
					$check_pswd = false;
					return "Пароль должен содержать не меньше 6 символов!";
				}

			elseif($this->pswd != $this->pswd_conf)
				{
					$check_pswd = false;
					return "Пароли не совпадают!";
				}
		}

		if($check_pswd)
		{
			if(!filter_var($this->email, FILTER_VALIDATE_EMAIL) and !empty($this->email))
				return "Неверная электронная почта!";

			elseif($check_coincidence_res["login"] == $this->login  and !empty($this->login))
				return "Пользователь с таким логином уже существует!";

			elseif($check_coincidence_res["email"] == $this->email and !empty($this->email))
				 return "Пользователь с таким email уже существует!";

			else
			{
				$stmt = $this->connection->prepare("
					SELECT * 
					FROM users
					WHERE id = '$user_id'
					");
				$stmt->execute();
				$result_set = $stmt->get_result();
				$row = $result_set->fetch_assoc();

				if(!empty($this->pswd))
					$this->pswd = password_hash($this->pswd, PASSWORD_DEFAULT);

				else
					$this->pswd = $row['password'];

				foreach ($this as $key => $value)
				{
					if(empty($value) and $key != 'pswd_conf' and $key != 'pswd_old')
						$this->$key = $row[$key];
				}

				$stmt = $this->connection->prepare("
					UPDATE users 
					SET login = ?,
						password = ?, 
						email = ? 
					WHERE id = ?
					");
				$stmt->bind_param('sssi', $this->login, $this->pswd, $this->email, $user_id);
				$stmt->execute();
				return 1;
			}
		}
	}
}