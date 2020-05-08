<?php
class Controller_Login extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->styles[] = 'forms-login-sign-up.css';
	}
	public function action_index()
	{
		$this->title = 'Вход';
		$this->own_view_path = 'login-view.php';
		
		if(isset($_SESSION['user_id']))
			$this->go_home();

<<<<<<< HEAD
=======
		$error_messege = NULL;
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782
		if(!empty($_POST))
		{
			if(!empty($_POST['login'])
				&& !empty($_POST['pswd']))
			{
				$guest = new Model_User($_POST);
<<<<<<< HEAD
				$successful_query = $guest->verifyPswd();

				if($successful_query['id'] !== false)
					{
						$_SESSION['user_id'] = $successful_query['id'];
						$_SESSION['role'] = $successful_query['role'];
						$this->go_home();
					}
				else
					$this->error_message = 'Не верный логин или пароль';
			}
			else
				$this->error_message = 'Заполните все поля';
		}

		$this->setData(null);

=======
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
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782
		$this->view->generate($this->title, $this->own_view_path, $this->template_view_path, $this->data);
	}

	public function action_logout()
	{
		session_destroy();
		header("Location: /");
	}
}