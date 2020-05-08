<?php
class Model_Search_User extends Model
{
	public function search($desired_user_data)
	{
		$desired_user_data .= '%';

		$stmt = self::$connection->prepare("
			SELECT login, id
			FROM users
			WHERE login LIKE ?");
		$stmt->bind_param('s', $desired_user_data);
		$stmt->execute();
		$result_set = $stmt->get_result();
		$amount_of_users = $result_set->num_rows;
		self::$connection->close();

		for($i = 0; $i < $amount_of_users; $i++)
<<<<<<< HEAD
			$matching_users[$i] = $result_set->fetch_assoc();
=======
		{
			$this->row[$i] = $result_set->fetch_assoc();
			$this->logins[$i] = $this->row[$i]['login'];
			$this->id[$i] = $this->row[$i]['id'];
		}
		if(empty($this->logins))
			$this->error_messege = 'Не найдено совпадений по вашему запросу';
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782

		if(!empty($matching_users))
			return $matching_users;

		$this->error_message = 'Не найдено совпадений по вашему запросу';
	}
}