<?php
class Controller
{
	public $view;
	public $model;
	public $user;
	public $template_view_path = 'template-view.php';
	public $own_view_path;
	public $title;
	public $data;
<<<<<<< HEAD
	public $error_message = null;
	public $styles = null;
	public $scripts = null;

	const USER_MODEL_DIR = 'app/models/user-models/';
=======
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782

	public function __construct()
	{
		$this->view = new View;
		if (!empty($_SESSION))
		{
			switch ($_SESSION['role']) {
				case 'admin':
					require_once self::USER_MODEL_DIR.'model-admin.php';
					$this->user = new Model_Admin($_SESSION);
					break;
				
				case 'teacher':
					require_once self::USER_MODEL_DIR.'model-teacher.php';
					$this->user = new Model_Teacher($_SESSION);
					break;

				case 'student':
					require_once self::USER_MODEL_DIR.'model-student.php';
					$this->user = new Model_Student($_SESSION);
					break;
			}
			$this->user->getData();
		}
	}

	public function setData($specialData)
	{
		$this->data = array(
			'styles' => $this->styles,
			'scripts' => $this->scripts,
			'user' => $this->user,
			'error_message' => $this->error_message
		);

		if (!empty($specialData)) {
			foreach ($specialData as $key => $value) {
				$this->data[$key] = $value;
			}
		}
	}

	public function go_home()
	{
		header("Location: /");
	}
}