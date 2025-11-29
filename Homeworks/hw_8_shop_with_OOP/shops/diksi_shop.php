<?php


class diksi_shop extends main_shop implements check_age
{
    use Dislocation;
    public function __construct($user)
    {
        parent::__construct("Дикси", $user);
        $this->products = [
            'Кофе' => 550,
            'Арбуз' => 200,
            'Молоко' => 70,
            'Хлеб' => 45,
            'Шоколадка'=> 99,
            'Сигареты' => 165,
            'Вода' => 35,
            'Водка' => 350
        ];
    }

    public function ShowProducts()
    {
        echo "Товары магазина Дикси\n";
        foreach ($this->products as $product => $price) {
            echo "- {$product}: {$price} руб.";
        } if ($product == 'Сигареты' || $product == 'Водка') {
        echo "Для данного товара необходимо предъявить документ";
    }
    }

    public function BuyProduct($productName)
    {
        if (!isset($this->products[$productName])) {
            echo "Товар {$productName} не найден!";
        }

        $price = $this->products[$productName];

        if ($this->checkBalance($price)) {
            $this->processPayment($price);
            echo "Вы купили {$productName}!\n";
        } else {
            echo "Недостаточно средств для покупки {$productName}!\n}";
        }
    }



    public function CostOfProducts($productName)
    {
        return $this->products[$productName] ?? 0;
    }

    public function CostWithPromo($productName)
    {
        $price = $this->CostOfProducts($productName);

        if (!empty($this->user->promocode)) {
            $discount = $this->user->getPromoDiscount();
            $finalPrice = $price * (1 - $discount);
            echo "Цена со скидкой: {$finalPrice} руб. (скидка " . ($discount * 100) . "%\n";
            return $finalPrice;
        }

        return $price;
    }

    public function welcome()
    {
        parent::welcome();
    }

    public function checkBalance($price)
    {
        $result = parent::checkBalance($price);
        if ($result) {
            echo "Денег хватает!";
        } else {
            echo "Недостаточно средств!";
        }
        return $result;
    }

    public function checkAge()
    {
        echo 'Введите ваш возраст';
        $input = trim(fgets(STDIN));
        if ($input<18){
            echo 'Вам нет 18';
        } else {
            echo 'Возраст подтверждён';
        }
    }
}