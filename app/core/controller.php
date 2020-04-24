<?php
class Controller
{
	public $view;
	public $model;
	public $user;
	public $data;
	public $title;
	public $template_view_path = 'template-view.php';
	public $own_view_path;
	public $style_files = "<link rel='stylesheet' type='text/css' href='/web/css/";
	public $meta_files;

	function __construct()
	{
		$this->view = new View;
		if(isset($_SESSION['user_id']))
		{
			$this->user = new Model_User($_SESSION);
			$this->user->get_user_data();
		}
	}

	function go_home()
	{
		header("Location: /");
	}
}