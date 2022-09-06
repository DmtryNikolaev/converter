<?php

require_once './vendor/autoload.php';

$request = $_SERVER['REQUEST_URI'];
$loader = new \Twig\Loader\FilesystemLoader('./src/views');
$twig = new \Twig\Environment($loader);
$url = 'http://api.coinlayer.com/api/live?access_key=c12708446dcc574db47b3ff6908b2650&symbols=BTC,ETH,AIDOC,AIB,AGI,AE,ADZ,ADX,ADL,ADCN,ADA,USD';

switch ($request) {
    case '/':
        echo $twig->render('form.html');
        break;
    case '/listOfCurrency':
        $listOfCurrency = (array)((array) json_decode(file_get_contents($url)))['rates'];

        echo $twig->render('curency.html', compact('listOfCurrency'));
        break;
}