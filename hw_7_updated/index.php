<?php

use controller\badWordsController;
use model\BadWordModel;

require_once 'config/database.php';
require_once 'model/BadWordModel.php';
require_once 'controller/badWordsController.php';

$model = new BadWordModel($pdo);
$controller = new badWordsController($model);

$words = $controller->showWordsPage();

require_once 'views/index.php';