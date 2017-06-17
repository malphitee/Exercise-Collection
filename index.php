<?php

require __DIR__.'/vendor/autoload.php';


$orders = [
    [
    'id'                =>  1,
    'user_id'           =>  1,
    'number'            =>  '123456789',
    'status'            =>  0,
    'order_products'    =>  [
        ['order_id'=>1,'price'=>100],
        ['order_id'=>2,'price'=>200]
    ]
    ],
    [
        'id'                =>  2,
        'user_id'           =>  2,
        'number'            =>  '123456789',
        'status'            =>  0,
        'order_products'    =>  [
            ['order_id'=>1,'price'=>300],
            ['order_id'=>2,'price'=>400]
        ]
    ]
];

//需求：求出order的总价，即所有元素price之和
//常规解法
$price = 0;
foreach ($orders as $order){
    foreach ($order['order_products'] as $order_product){
        $price += $order_product['price'];
    }
}


//进阶解法
$result = collect($orders)->map(function ($order){
   return $order['order_products'];
})->flatten(1)->map(function ($order){
    return $order['price'];
})->sum();


//改进版本1
$result = collect($orders)->flatMap(function ($order){
    return $order['order_products'];
})->pluck('price')->sum();


//改进版本2
$result = collect($orders)->flatMap(function ($order){
    return $order['order_products'];
})->sum('price');


//改进版本3
$result = collect($orders)->pluck('order_products.*.price')->flatten(1)->sum();

//改进版本4
$result = collect($orders)->pluck('order_products')->flatten(1)->sum('price');



echo(json_encode($result));
