<?php
class Controller_404 extends Controller
{
	function action_index()
	{
		$this->view->generate('404 Not Found','', '404-view.php', NULL);
	}
}