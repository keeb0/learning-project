<?php
class Controller_Search_User extends Controller
{
	public $matching_users = null;
	public function action_index()
	{
		$this->title = 'Поиск пользователя';
		$this->own_view_path = 'search-user-view.php';
		$this->styles[] = 'search-user.css';
		
		$searching_user = new Model_Search_User;

		if (isset($_POST['desired_user_login']))
			$this->matching_users = $searching_user->search($_POST['desired_user_login']);

		$this->error_message = $searching_user->error_message;

		$this->setData(['matching_users' => $this->matching_users]);

		$this->view->generate($this->title, $this->own_view_path, $this->template_view_path, $this->data);
	}
}