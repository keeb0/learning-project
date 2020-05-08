<?php
<<<<<<< HEAD
define('CORE_DIR', 'core/');
=======
require_once 'core/controller.php';
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/model-image-upload.php';
require_once 'core/model-user.php';
>>>>>>> 9794ce286165c8ad8244a59ea0eee19bb5da1782

require_once CORE_DIR.'controller.php';
require_once CORE_DIR.'model.php';
require_once CORE_DIR.'view.php';
require_once CORE_DIR.'model-image-upload.php';
require_once CORE_DIR.'model-user.php';
require_once CORE_DIR.'route.php';

Route::start();