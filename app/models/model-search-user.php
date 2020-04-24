<?php
class Model_Search_User extends Model
{
	public $logins = [];
	public $id = [];
	function search_user($desired_user_data)
	{
		$desired_user_data .= '%';

		$stmt = $this->connection->prepare("
			SELECT login, id
			FROM users
			WHERE login LIKE ?");
		$stmt->bind_param('s', $desired_user_data);
		$stmt->execute();
		$result_set = $stmt->get_result();
		$amount_of_users = $result_set->num_rows;
		$this->connection->close();

		for($i = 0; $i < $amount_of_users; $i++)
		{
			$this->row[$i] = $result_set->fetch_assoc();
			$this->logins[$i] = $this->row[$i]['login'];
			$this->id[$i] = $this->row[$i]['id'];
		}
		if(empty($this->logins))
			$this->messege = 'Не найдено совпадений по вашему запросу';

	}
}