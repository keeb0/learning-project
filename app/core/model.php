<?php
class Model
{
	protected $connection;
	public $messege = 0;

	function __construct()
	{
		$this->connection = new mysqli('localhost', 'admin', '123456', 'chat');
		$this->connection->query("SET NAMES 'utf8'");
	}

	function __destruct()
	{
		// $this->connection->close();
	}
}
