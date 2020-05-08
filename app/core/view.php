<?php
class View
{
	public function generate($title, $content_view, $template_view, $data = null)
	{
		require_once 'app/views/'.$template_view;
	}
}