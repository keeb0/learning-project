<?php
class Controller_Search_User extends Controller
{
	function action_index()
	{
		$this->title = 'Поиск пользователя';
		$this->own_view_path = 'search-user-view.php';
		$this->style_files .= "search-user.css'>";
		
		$searching_user = new Model_Search_User;

		if(isset($_POST['desired_user_login']))
		{
			$searching_user->search_user($_POST['desired_user_login']);
		}
// print_r($searching_user);
		// $searching_user->connection->close();
		$this->data = array(
			'meta_files' => $this->style_files,
			'user' => $this->user,
			'messege' => $searching_user->messege,
			'logins' => $searching_user->logins,
			'id' => $searching_user->id);

		$this->view->generate($this->title, $this->own_view_path, $this->template_view_path, $this->data);
	}
}