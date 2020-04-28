<?php
class Controller_Profile extends Controller
{
	public $view_directory = 'profile/';

	function __construct()
	{
		parent::__construct();

		$this->scripts[] = 'script.js';
		$this->styles[] ='forms-profile.css';
	}

	function action_index()
	{
		$this->title = 'Личный кабинет';
		$this->own_view_path = 'profile-edit-view.php';
		$error_messege = null;

		if(!isset($_SESSION['user_id']))
			$this->go_home();

		// *********Блок кода с модулем аватарки пользователя*********
		$user_avatar = new Model_User_Avatar($this->user);
		$user_avatar->get_user_avatar();

		if (!empty($_FILES)) 
		{
			list($file_name, ) = each($_FILES);
			
			if(!empty($_FILES[$file_name]['tmp_name']))
			{
				$error_messege = $user_avatar->upload_user_avatar($_FILES[$file_name], $this->user->user_id);
			}
		}
		
		// *********Блок кода с модулем данных пользователя*********
		if(!empty($_POST))
		{
			$user_updating = new Model_User($_POST);

			if(isset($user_updating->login) || isset($user_updating->email))
				$error_messege = $user_updating->update_data($this->user->user_id);

			elseif(!empty($user_updating->pswd))
			{
				$user_updating->login = $this->user->login;

				if($user_updating->verify_pswd())
					$error_messege = $user_updating->update_pswd($this->user->user_id);
				else
					$error_messege['pswd'] = 'Не верный пароль';
			}
			else
				$error_messege['pswd'] = 'Введите пароль';
		}
		
		$this->data = array(
			'styles' => $this->styles,
			'scripts' => $this->scripts,
			'user' => $this->user,
			'avatar' => $user_avatar->path,
			'error_messege' => $error_messege
		);

		$this->view->generate($this->title, $this->own_view_path, $this->template_view_path, $this->data);
	}

	public $desired_user;

	function action_show_user()
	{
		$this->own_view_path = 'show-user-view.php';
		if(isset($_GET['user_id']))
		{
			$this->desired_user = new Model_User($_GET);
			$this->desired_user->get_user_data();
		}
		else
			$this->go_home();

		$this->title = 'Профиль пользователя '.$this->desired_user->login;

		$user_avatar = new Model_User_Avatar($this->desired_user);
		$user_avatar->get_user_avatar();

		$this->data = array(
			'styles' => $this->styles,
			'user' => $this->user,
			'avatar' => $user_avatar->path,
			'desired_user' => array(
				'login' => $this->desired_user->login,
				'email' => $this->desired_user->email));

		$this->view->generate($this->title, $this->own_view_path, $this->template_view_path, $this->data);
	}
}