<div class="main_content_space">
	<form action="search-user" method="POST">
		<label>Введите логин пользователя:
			<input class="text_field" type="text" name="desired_user_login">
		</label>
		<input class="buttons" type="submit" value="Поиск">
	</form>
</div>
<div></div>
<div class="found_user_block">
	<?php !empty($data['error_messege']) ? print $data['error_messege'] : ''; ?>
	<?php 
	if(!empty($data['logins']))
	{
		$logins_amount = count($data['logins']);
		$id = $data['id'];
		echo "Все найденные совпадения:";
		for($i = 0; $i < $logins_amount; $i++)
		{
			print "<a class='row' href='/profile/show_user?user_id=$id[$i]'>".$data['logins'][$i]."</a>";
			// print_r($data['logins']);
		}
	}
	?>
</div>