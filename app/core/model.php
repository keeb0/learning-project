<?php
class Model
{
	static $connection;
	public $error_messege = 0;

	function __construct()
	{
		self::$connection = new mysqli('localhost', 'admin', '123456', 'chat');
		self::$connection->query("SET NAMES 'utf8'");
	}

	function __destruct()
	{
		// self::$connection->close();
	}
}
