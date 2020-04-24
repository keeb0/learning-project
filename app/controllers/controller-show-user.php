<?php
require_once 'app/models/model-profile.php';

class Controller_Show_User extends Controller
{
	public $desired_user;

	function action_index()
	{
		if(isset($_GET['user_id']))
		{
			$this->desired_user = new Model_User($_GET);
			$this->desired_user->get_user_data();
		}
		else
			$this->go_home();

		$user_avatar = new Model_User_Avatar($this->desired_user);
		$user_avatar->get_user_avatar();

		$this->data = array(
			'user' => $this->user,
			'desired_user' => $this->desired_user,
			'avatar' => $user_avatar->path
		);
		$this->view->generate(
			'Профиль пользователя '.$this->desired_user->login,
			'show-user-view.php',
			'template-view.php',
			$this->data
		);
	}
}