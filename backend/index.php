<?php

require_once __DIR__ . '/vendor/autoload.php';

// Feito primeiramente para testar a função e o retorno da api do Ulvis
use App\Ulvis\EncurtadorUrl;

$url = 'http://youtube.com/teste';

$short = EncurtadorUrl::encurtar($url);

echo $url . "\n";
echo $short . "\n";