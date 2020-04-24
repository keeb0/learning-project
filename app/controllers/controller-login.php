<?php
class Controller_Login extends Controller
{
	function __construct()
	{
		parent::__construct();

		$this->meta_files = "<link rel='stylesheet' type='text/css' href='/web/css/forms-login-sign-up.css'>";
	}
	function action_index()
	{
		$this->title = 'Вход';
		$this->own_view_path = 'login-view.php';
		if(isset($_SESSION['user_id']))
			$this->go_home();

		$messege = NULL;
		if(!empty($_POST))
		{
			$guest = new Model_Guest($_POST);
			$messege = $guest->verify();

			// Успешная авторизация
			if($messege == 1)
			{
				$this->go_home();
			}
		}

		$this->data = array(
			'meta_files' => $this->meta_files,
			'messege' => $messege
		);
		$this->view->generate($this->title, $this->own_view_path, $this->template_view_path, $this->data);
	}

	function action_logout()
	{
		session_destroy();
		header("Location: /");
	}
}