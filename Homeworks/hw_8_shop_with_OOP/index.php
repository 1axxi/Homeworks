<?php


require_once __DIR__ . '/interface/check_age.php';
require_once __DIR__ . '/trait/Dislocation.php';
require_once __DIR__ . '/shops/main_shop.php';
require_once __DIR__ . '/classUser.php';
use hw_8_shop_with_OOP\User;
require_once __DIR__ . '/shops/ashan_shop.php';
require_once __DIR__ . '/shops/diksi_shop.php';
require_once __DIR__ . '/shops/lenta_shop.php';


//function autoloader_check_age($check_age)       тут я попытался без композера сделать автолоад но не работает
//{
//    include 'interface/' . $check_age . '.php';
//}
//spl_autoload_register('autoloader_check_age');
//
//function Dislocation($Dislocation)
//{
//    include 'trait/' . $Dislocation . '.php';
//}
//spl_autoload_register('autoloader_ForAgeOfUser');

//echo " Добро пожаловать в систему магазинов!\n\n";


$user = new User(1000, '');








// Создаем двух покупателей:
// - У Васи много денег и есть промокод
// - У Пети мало денег и нет промокода
$vasya = new User(5000, 'SUMMER2024'); // Василий с промокодом
$petya = new User(300);               // Петя без промокода


// Создаем три магазина, передаем им покупателей
$ashan = new ashan_shop($vasya);  // Вася идет в Ашан
$diksi = new diksi_shop($vasya);  // Вася заходит в Дикси
$lenta = new lenta_shop($petya);  // Петя идет в Ленту




// Каждый магазин приветствует покупателя
echo "Ашан: ";
$ashan->welcome();
echo "\nДикси: ";
$diksi->welcome();
echo "\nЛента: ";
$lenta->welcome();


// Показываем все товары в каждом магазине
echo "АШАН - большой выбор:\n";
$ashan->ShowProducts();

echo "\nДИКСИ - районный магазин:\n";
$diksi->ShowProducts();

echo "\nЛЕНТА - гипермаркет:\n";
$lenta->ShowProducts();


// Сравниваем цены в разных магазинах
echo "Сравнение цен:\n";
echo "Кофе в Ашане: " . $ashan->CostOfProducts('Кофе') . " руб.\n";
echo "Кофе в Дикси: " . $diksi->CostOfProducts('Кофе') . " руб.\n";
echo "Кофе в Ленте: " . $lenta->CostOfProducts('Кофе') . " руб.\n";

echo "Арбуз в Ашане: " . $ashan->CostOfProducts('Арбуз') . " руб.\n";
echo "Арбуз в Дикси: " . $diksi->CostOfProducts('Арбуз') . " руб.\n";
echo "Арбуз в Ленте: " . $lenta->CostOfProducts('Арбуз') . " руб.\n";


// Вася с промокодом видит цены со скидкой
echo "Вася (с промокодом) видит цены со скидкой:\n";
echo "Кофе в Ашане: ";
$ashan->CostWithPromo('Кофе');
echo "Водка в Ашане: ";
$ashan->CostWithPromo('Водка');

// Петя без промокода видит обычные цены
echo "Петя (без промокода) видит обычные цены:\n";
echo "Кофе в Ленте: ";
$lenta->CostWithPromo('Кофе');


// Проверяем достаточно ли денег у покупателей

$ashan->checkBalance(1000); // Хватит ли 1000 рублей?


$lenta->checkBalance(500); // Хватит ли 500 рублей?


// Вася делает покупки в Ашане

$ashan->BuyProduct('Молоко');    // Покупаем молоко
$ashan->BuyProduct('Хлеб');      // Покупаем хлеб
$ashan->BuyProduct('Шоколадка'); // Покупаем шоколад

// Вася продолжает покупки в Дикси

$diksi->BuyProduct('Вода');      // Покупает воду
$diksi->BuyProduct('Арбуз');     // Покупает арбуз

// Петя пытается купить в Ленте

$lenta->BuyProduct('Вода');      // Покупает воду
$lenta->BuyProduct('Хлеб');      // Пытается купить хлеб




//Проверка возраста
 $diksi->checkAge();
$ashan->checkAge();

// Узнаем про доставку (статический метод)
main_shop::delivery();



// Пытаемся купить товары 18+

$ashan->BuyProduct('Водка');


$diksi->BuyProduct('Сигареты');


// Смотрим сколько денег осталось у покупателей
echo "Остаток денег:\n";
echo "У Васи: " . $vasya->balance . " руб.\n";
echo "У Пети: " . $petya->balance . " руб.\n";


echo "Спасибо за использование  системы!\n";

