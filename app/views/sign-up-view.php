<form class="sign_up_block" action="sign-up" method="post">
	<div class="field">
		<label for="user_login" focus="test()">Логин:</label> 
		<input type="text" name="login" id="user_login" value="saddsa">
	</div>
	<div class="field">
<<<<<<< HEAD
		<?php !empty($data['error_message']['login']) ? print $data['error_message']['login'] : '' ; ?>
=======
		<?php !empty($data['error_messege']['login']) ? print $data['error_messege']['login'] : '' ; ?>
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782
	</div>
	<div class="field">
		<label for="user_pswd">Пароль:</label>
		<input type="password" name="pswd_new" id="user_pswd">
	</div>
	<div class="field">
<<<<<<< HEAD
		<?php !empty($data['error_message']['pswd']) ? print $data['error_message']['pswd'] : '' ; ?>
=======
		<?php !empty($data['error_messege']['pswd']) ? print $data['error_messege']['pswd'] : '' ; ?>
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782
	</div>
	<div class="field">
	<div class="field">
		<label for="user_pswd_conf">Подтвердите пароль:</label>
		<input type="password" name="pswd_conf" id="user_pswd_conf">
	</div>
	<div class="field">
		<label for="user_email">Введите e-mail:</label> 
		<input type="text" name="email" id="user_email">
	</div>
	<div class="field">
<<<<<<< HEAD
		<?php !empty($data['error_message']['email']) ? print $data['error_message']['email'] : '' ; ?>
=======
		<?php !empty($data['error_messege']['email']) ? print $data['error_messege']['email'] : '' ; ?>
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782
	</div>
	<div class="field">
		<input class="buttons" type="submit" value="Зарегистрироваться" name="submit" id="user_submit">
	</div>
</form>