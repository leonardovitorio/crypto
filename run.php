<?php

require './Alphabet.php';
require './Cypher.php';
require './Noise.php';
require './CircleListJumper.php';
require './Crypto.php';

use stools\Crypto\Crypto;

$senha = 'Leonardo Stuginski';
$contra_chave = '';

$c  = Crypto::convertToCrypto($senha, $characters);

echo "valor de origem: " . $senha . PHP_EOL;
echo "Alfabeto aleatório: " . $c->getAlphabet() . PHP_EOL;
echo "Valor codificado: " . $c->getValue() . PHP_EOL;
echo "Valor chave1: " . $c->getKey1() . PHP_EOL;
echo "Valor chave2: " . $c->getKey2() . PHP_EOL;
echo "Valor decodificado: " . $c->getDecoded() . PHP_EOL;
