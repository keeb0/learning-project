<div class="user_photo_block">
	<img src="<?php echo $data['avatar']; ?>">
	
	<form action="profile" method="post" enctype="multipart/form-data" class="new_photo_form">
		<label for="photo_new" class="new_photo_elements">
			Сменить фото пользователя
		</label>
		<input id="photo_new"  type="file" name="photo">
		<button class="buttons commit">Сохранить фото</button>
		<span class="messege"><?php if(!empty($_FILES)) echo $data['messege']; ''?></span>
	</form>
</div>

<form method="post" action="profile" id="user_edit" enctype="multipart/form-data"></form>
<div class="user_dates_block">
	<div class="field">
		<div id="login">
			Логин: <?php echo $data['user']->login; ?>
			<button class="buttons" onclick="hide('login', 'login_edit', '', '', '')"> ✎ </button>
		</div>

		<div  hidden id='login_edit'>
			<label for="login_user">Логин:</label>
			<input name="login" type="text" form="user_edit" id="login_user" value="<?php echo $data['user']->login; ?>">
			<button class="buttons" onclick="hide('login_edit', 'login', 'login_user', '', '')"> ✖ </button>
		</div>
	</div>

	<div class="field">
		<div id="email">
			e-mail: <?php echo $data['user']->email; ?>
			<button class="buttons" onclick="hide('email', 'email_edit', '','', '')"> ✎ </button>
		</div>

		<div  hidden id='email_edit'>
			<label for="email_user">e-mail:</label>
			<input name="email" type="text" form="user_edit" id="email_user" value="<?php echo $data['user']->email; ?>">
			<button class="buttons" onclick="hide('email_edit', 'email', 'email_user', '', '')"> ✖ </button>
		</div>
	</div>
	
	<div hidden="" id="pswd">
		<div class="field">
			<label for="pswdOld_user">Текущий пароль: </label>
			<input name="pswdOld" type="password" form="user_edit" id="pswdOld_user">
			<button class="buttons" onclick="hide('pswd', 'pswd_edit', 'pswdOld_user', 'pswdNew_user', 'pswdNew2_user')"> ✖ </button>
		</div>
		<div class="field">
			<label for="pswdNew_user">Новый пароль:</label>
			<input class="pswd_inputs" name="pswdNew" type="password" form="user_edit" id="pswdNew_user">
		</div>
		<div class="field">
			<label for="pswdNew2_user">Подтвердите пароль:</label>
			<input class="pswd_inputs" name="pswdNew2" type="password" form="user_edit" id="pswdNew2_user">
			
		</div>
	</div>

	<div id="pswd_edit">
		<div class="field">
			Изменить пароль <button class="buttons"  onclick="hide('pswd_edit', 'pswd', '','', '')"> ✎ </button>
		</div>
	</div>
	
	<div class="field">
		<button  class="buttons commit" value="submit" form="user_edit">Сохранить данные</button>
	</div>
	<div class="field">
		<?php if(!empty($_POST)) echo $data['messege']; ?>
	</div>
</div>