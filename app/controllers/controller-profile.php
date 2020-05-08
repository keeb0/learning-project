<?php
class Controller_Profile extends Controller
{
	public $view_directory = 'profile/';

	public function __construct()
	{
		parent::__construct();

		$this->scripts[] = 'script.js';
		$this->styles[] ='forms-profile.css';
	}

	public function action_index()
	{
		$this->title = 'Личный кабинет';
		$this->own_view_path = 'profile-edit-view.php';

		if (!isset($_SESSION['user_id']))
			$this->go_home();

		// *********Блок кода с модулем аватарки пользователя*********
		$user_avatar = new Model_User_Avatar($this->user);
		$user_avatar->getAvatar();

		if (!empty($_FILES)) {
			list($file_name, ) = each($_FILES);
			
			if(!empty($_FILES[$file_name]['tmp_name']))
			{
				$this->error_message = $user_avatar->uploadAvatar($_FILES[$file_name],
					$this->user->user_id);
			}
		}
		// *********Блок кода с модулем данных пользователя*********
		if (!empty($_POST)) {
			$user_updating = new Model_User($_POST);

			if(isset($user_updating->login) || isset($user_updating->email))
				$this->error_message = $user_updating->updateData($this->user->user_id);

			elseif (!empty($user_updating->pswd)) {
				$user_updating->login = $this->user->login;

				if ($user_updating->verifyPswd())
					$this->error_message = $user_updating->updatePswd($this->user->user_id);
				else
					$this->error_message['pswd'] = 'Не верный пароль';
			}
			else
				$this->error_message['pswd'] = 'Введите пароль';
		}

		$this->setData(['avatar' => $user_avatar->path]);

		$this->view->generate(
			$this->title,
			$this->own_view_path,
			$this->template_view_path,
			$this->data
		);
	}

	public $desired_user;

	public function action_show_user()
	{
		$this->own_view_path = 'show-user-view.php';
		if (isset($_GET['user_id'])) {
			$this->desired_user = new Model_User($_GET);
			$this->desired_user->getData();
		}
		else
			$this->go_home();

		$this->title = 'Профиль пользователя '.$this->desired_user->login;

		$user_avatar = new Model_User_Avatar($this->desired_user);
		$user_avatar->getAvatar();

		$this->setData(
			['avatar' => $user_avatar->path,
			'desired_user' => $this->desired_user]);

		$this->view->generate(
			$this->title,
			$this->own_view_path,
			$this->template_view_path,
			$this->data
		);
	}
}