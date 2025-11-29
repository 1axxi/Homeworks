<?php

namespace hw_8_shop_with_OOP;

class User
{
    public $balance;
    public $promocode;


    private $promocodes = [
        'SUPER2024' => 0.50,
        'SALE20' => 0.20,
        'WELCOME' => 0.10
        ];

    public function __construct($balance = 0, $promocode = '')
    {
        $this->balance = $balance;
        $this->promocode = $promocode;
    }

    public function getBalance()
    {
        echo 'Привет,сколько выделишь денег на покупку?';
        $input = trim(fgets(STDIN));
        //Проверка что не ноль
        if (!is_numeric($input)) {
            echo "Нужно ввести число. Баланс установлен в 0.\n";
            $this->balance = 0;
        } // Проверяем, что баланс положительный
        elseif ($input < 0) {
            echo " Баланс не может быть отрицательным! Установлен 0.\n";
            $this->balance = 0;
        } // Если баланс 0
        elseif ($input == 0) {
            echo "Бесплатный сыр только в мышеловке\n";
        } // Если баланс маленький
        elseif ($input < 500) {
            echo "Будем искать недорогие товары!\n";
        } // Если баланс нормальный
        else {
            echo "Отлично,твой баланс = {$this->balance}";
        }
    }

    public function getPromo()
    {
        echo 'Какой у тебя промокод?';
        $input = trim(fgets(STDIN));

        if (empty($input)) {
            $this->promocode = '';
            echo "Покупка без промокода\n";
            return $this;
        }

        if (isset($this->promocodes[$input])) {
            $this->promocode = $input;
            echo $this->promocodes[$input] . "\n";
        } else {
            echo " Такого промокода нет. Покупка без промокода.\n";
            $this->promocode = '';
        }


//        echo "Отлично,твой твой промокод : {$this->promocode}";
    }

    public function showInfo()
    {
        echo" Уважаемый юзер,твой баланс составляет : {$this->balance} рублей, а промокод : {$this->promocode} ";
    }

    public function getPromoDiscount($promoCode = null)
    {
        $code = $promoCode ?? $this->promocode;
        return $this->promocodes[$code] ?? 0;
    }


}

