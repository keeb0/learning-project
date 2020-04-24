<?php
class Controller_Profile extends Controller
{
	public $view_directory = 'profile/';

	function __construct()
	{
		parent::__construct();

		$this->meta_files = "<script type='text/javascript' src='/web/js/script.js' defer></script>
			<link rel='stylesheet' type='text/css' href='/web/css/forms-profile.css'>";
	}

	function action_index()
	{
		$this->title = 'Личный кабинет';
		$this->own_view_path = 'profile-edit-view.php';

		if(!isset($_SESSION['user_id']))
			$this->go_home();

		$user_avatar = new Model_User_Avatar($this->user);
		$user_avatar->get_user_avatar();

		if(!isset($_SESSION['user_id']))
			go_home();

		$messege = null;
		if(!empty($_POST))
		{
			$user_edit = new Model_User_Edit($_POST);

			$messege = $user_edit->update_info($this->user->id, $this->user->login);
		}
		
		if (!empty($_FILES)) 
		{
			list($file_name, ) = each($_FILES);
			
			if(!empty($_FILES[$file_name]['tmp_name']))
			{
				$messege = $user_avatar->upload_user_avatar($_FILES[$file_name], $this->user->id);
			}
		}

		$messege == 1 ? header("Location: profile") : 0;

		$this->data = array(
			'meta_files' => $this->meta_files,
			'user' => $this->user,
			'avatar' => $user_avatar->path,
			'messege' => $messege
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
			'meta_files' => $this->meta_files,
			'user' => $this->user,
			'avatar' => $user_avatar->path,
			'desired_user' => array(
				'login' => $this->desired_user->login,
				'email' => $this->desired_user->email));

		$this->view->generate($this->title, $this->own_view_path, $this->template_view_path, $this->data);
	}
}