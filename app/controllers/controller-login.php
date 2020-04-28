<?php
class Controller_Login extends Controller
{
	function __construct()
	{
		parent::__construct();

		$this->styles[] = 'forms-login-sign-up.css';
	}
	function action_index()
	{
		$this->title = 'Вход';
		$this->own_view_path = 'login-view.php';
		if(isset($_SESSION['user_id']))
			$this->go_home();

		$error_messege = NULL;
		if(!empty($_POST))
		{
			if(!empty($_POST['login'])
				&& !empty($_POST['pswd']))
			{
				$guest = new Model_User($_POST);
				$successful_query = $guest->verify_pswd();

				if($successful_query)
					{
						$_SESSION['user_id'] = $successful_query;
						$this->go_home();
					}
				else
					$error_messege = 'Не верный логин или пароль';
			}
			else
				$error_messege = 'Заполните все поля';
			
			// Успешная авторизация
			if($successful_query == true)
				$this->go_home();
		}

		$this->data = array(
			'styles' => $this->styles,
			'error_messege' => $error_messege
		);
		$this->view->generate($this->title, $this->own_view_path, $this->template_view_path, $this->data);
	}

	function action_logout()
	{
		session_destroy();
		header("Location: /");
	}
}