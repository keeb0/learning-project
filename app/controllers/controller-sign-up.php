<?php
class Controller_Sign_Up extends Controller
{
	function __construct()
	{
		parent::__construct();

		$this->styles[] = 'forms-login-sign-up.css';
		$this->scripts[] = 'script-sign-up.js';
	}
	function action_index()
	{
		$this->title = 'Регистрация';
		$this->own_view_path = 'sign-up-view.php';
		
		if(isset($_SESSION['user_id']))
			$this->go_home();

		$error_messege = NULL;
		if(!empty($_POST))
		{
			$new_user = new Model_User($_POST);
			$error_messege = $new_user->create_user();

			// Успешная регистрация
			if($error_messege === 1)
				$this->go_home();
		}

		$this->data = array(
			'styles' => $this->styles,
			'scripts' => $this->scripts,
			'error_messege' => $error_messege
		);
		$this->view->generate($this->title, $this->own_view_path, $this->template_view_path, $this->data);
	}
}