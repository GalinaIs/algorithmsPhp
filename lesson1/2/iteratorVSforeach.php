<?php

const COUNT = 10000000;
for ($i = 0; $i < COUNT; ++$i) {
    $arr[] = $i;
}

$obj = new ArrayObject($arr);
$iter = $obj->getIterator();

$startForeach = microtime(true);
foreach ($arr as $key => $value) {
    $key.'='.$value."\n";
}
echo 'Время работы foreach: '.(microtime(true) - $startForeach).PHP_EOL;

$startIterator = microtime(true);
while ($iter->valid()) {
    $iter->key().'='.$iter->current()."\n";
    $iter->next();
}
echo 'Время работы iterator: '.(microtime(true) - $startIterator).PHP_EOL;
//у меня получилось, что foreach для версии 7.1 лучше, чем использование итераторов
//Для COUNT = 10000000;
//Время работы foreach: 2.5558459758759
//Время работы iterator: 28.378088951111