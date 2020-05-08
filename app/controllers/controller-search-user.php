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

<<<<<<< HEAD
		if (isset($_POST['desired_user_login']))
			$this->matching_users = $searching_user->search($_POST['desired_user_login']);

		$this->error_message = $searching_user->error_message;

		$this->setData(['matching_users' => $this->matching_users]);
=======
		if(isset($_POST['desired_user_login']))
		{
			$searching_user->search_user($_POST['desired_user_login']);
		}
// print_r($searching_user);
		// $searching_user->connection->close();
		$this->data = array(
			'styles' => $this->styles,
			'user' => $this->user,
			'error_messege' => $searching_user->error_messege,
			'logins' => $searching_user->logins,
			'id' => $searching_user->id);
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782

		$this->view->generate($this->title, $this->own_view_path, $this->template_view_path, $this->data);
	}
}