<form class="login_block" action="login" method="post">
	<div class="field">
		<label for="user_login">Логин:</label>
		<input type="text" name="login" id="user_login">
	</div>

	<div class="field">
		<label for="user_pswd">Пароль:</label>
		<input type="password" name="pswd" id="user_pswd">
	</div>
	
	<div class="field">
		<input class="buttons" type="submit" name="submit" value="Войти">
		<a href="sign-up">Регистрация</a>
	</div>

	<div class="field">
<<<<<<< HEAD
		<?php !empty($data) ? print $data['error_message'] : ""; ?>
=======
		<?php !empty($data) ? print $data['error_messege'] : ""; ?>
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782
	</div>
</form>