<?php


abstract class main_shop
{
    public $name;

    public $user;
    public $products = [];

    public function __construct($name, $user)
    {
        $this->name = $name;
        $this->user = $user;
    }

    abstract public function ShowProducts();
    abstract public function BuyProduct($productName); //с проверкой не привысила ли стоимость покупок баланс юзера
    abstract public function CostOfProducts($productName);
    abstract public function CostWithPromo($productName); //применение промокода для рассчёта скидок

    //возможно еще метод создания магазина с новым названием


    public function welcome()
    {
        echo "Добро пожаловать в магазин {$this->name} !";
        echo "Ваш баланс  = {$this->user->balance}";
    }

    public function checkBalance($price)
    {
        return $this->user->balance >= $price;
    }

    protected function processPayment($price)
    {
        $this->user->balance -= $price;
        echo "Списано {$price} рублей. Остаток : {$this->user->balance}\n";
    }

    public static function delivery()
    {
        echo "У нас бесплатная доставка!";
    }


}