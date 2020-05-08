<?php
class Controller_Main extends Controller
{
	public function action_index()
	{
		$this->title = 'Главная';
		$this->own_view_path = 'main-view.php';
		
		$this->setData(null);
		
		$this->view->generate($this->title, $this->own_view_path, $this->template_view_path, $this->data);
	}

	public function show_user()
	{
		
	}
}