<?php
class Model
{
	static $connection;
<<<<<<< HEAD
	public $error_message = null;
=======
	public $error_messege = 0;
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782

	public function __construct()
	{
		self::$connection = new mysqli('localhost', 'admin', '123456', 'chat');
		self::$connection->query("SET NAMES 'utf8'");
	}

	public function __destruct()
	{
		// self::$connection->close();
	}
}
