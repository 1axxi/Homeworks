<?php

namespace controller;

use BadWords;
use model\BadWordModel;

class badWordsController{
private $model;

public function __construct(BadWordModel $model) {
    $this->model = $model;
}

public function showWordsPage() {
   return $this->model->getBadWords();
}

}