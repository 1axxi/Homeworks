<?php

namespace model;

use PDO;

class BadWordModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getBadWords() {
        $stmt= $this->pdo->query("SELECT id, words FROM bad_words");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

