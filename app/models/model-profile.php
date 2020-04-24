<?php
class Model_User_Avatar extends Model_Image
{
	public $default_path = '/web/user-photos/avatars/default-avatar/avatar.png';
	public $directory;
	public $path;
	public $user;
	public $temp_avatar_name;

	function __construct($user_data)
	{
		parent::__construct();

		$this->user = clone $user_data;
		//photos_main_path - свойство родителя
		$this->directory_upload = 'web/user-photos/avatars/avatar-'.$this->user->id;
		$this->directory_get = '/web/user-photos/avatars/avatar-'.$this->user->id;
		
	}

	function get_user_avatar()
	{
		// Указываем путь к существующей аватарке иначе к дефолтному аватару всех пользователей
		if(!empty($this->user->avatar_name))
			$this->path = $this->directory_get.'/'.$this->user->avatar_name;
		else
			$this->path = $this->default_path;
	}

	function upload_user_avatar($image_dates)
	{
		// Создаём директорию аватарки если таковой нет
		if(!file_exists($this->directory_upload))
			mkdir($this->directory_upload);

		// Задаем хэш имя аватарке
		$this->temp_avatar_name = hash('md5', rand().$this->user->id);

		$success_upload = $this->upload_image($image_dates, $this->temp_avatar_name, $this->directory_upload);

		if($success_upload)
		{
			// Запись нового имени аватара в БД
			$this->temp_avatar_name .= '.'.$this->image_type; // image_type - свойство родителя
			$stmt = $this->connection->prepare("
				UPDATE users
				SET avatar_name = ?
				WHERE id = ?
				");
			$stmt->bind_param('si', $this->temp_avatar_name,  $this->user->id);
			$stmt->execute();

			// Удаление старой аватарки если она существует
			if(!empty($this->user->avatar_name))
				unlink($this->directory_upload.'/'.$this->user->avatar_name);

			// Обновляем страницу
			header("Location: /profile");
		}
		else
			return 'Вы отправили файл недопустимого типа (поддерживаемые файлы: PNG, JPEG, GIF)';
	}
}