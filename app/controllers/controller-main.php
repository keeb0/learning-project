<?php
class Controller_Main extends Controller
{
	function action_index()
	{
		$this->title = 'Главная';
		$this->own_view_path = 'main-view.php';
		
		$this->data = array(
			'user' => $this->user);
		$this->view->generate($this->title, $this->own_view_path, $this->template_view_path, $this->data);
	}

	function show_user()
	{
		
	}
}