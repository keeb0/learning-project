<form class="sign_up_block" action="sign-up" method="post">
	<div class="field">
		<label for="user_login">Логин:</label> 
		<input type="text" name="login" id="user_login" required="required">
	</div>
	<div class="field">
		<label for="user_pswd">Пароль:</label>
		<input type="password" name="pswd" id="user_pswd" required="required">
	</div>
	<div class="field">
		<label for="user_pswd_conf">Подтвердите пароль:</label>
		<input type="password" name="pswd_conf" id="user_pswd_conf" required="required">
	</div>
	<div class="field">
		<label for="user_email">Введите e-mail:</label> 
		<input type="text" name="email" id="user_email" required="required">
	</div>
	<div class="field">
		<input class="buttons" type="submit" value="Зарегистрироваться" name="submit" id="user_submit">
	</div>
	<div class="field">
		<?php !empty($data) ? print $data['messege'] : 0; ?>
	</div>
</form>