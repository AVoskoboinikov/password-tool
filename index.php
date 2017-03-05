<?php

$secret1 = null;
$secret2 = null;
$passwordLength = '12';

$dictionary = [
    'Q','W','E','R','T','Y','U','I','O','P','A','S','D',
    'F','G','H','J','K','L','Z','X','C','V','B','N','M',

    'q','w','e','r','t','y','u','i','o','p','a','s','d',
    'f','g','h','j','k','l','z','x','c','v','b','n','m',

    '1','2','3','4','5','6','7','8','9','0',

    '~','!','@','#','$','%','^','&','*','(',')','_','+',
    ',','.',':',';','?','[',']','<','>','-','='
];

$options = getopt('', ['s1:','s2:']);

if (empty($options['s1']) || empty($options['s2'])) {
    die('Provide secret words');
}

$secret1 = $options['s1'];
$secret2 = $options['s2'];

$password = [];
$secret1 = str_split(hash('sha256', $secret1));
$secret2 = str_split(hash('sha256', $secret2));

$dictionarySize = gmp_init(count($dictionary)); // 86
$primitiveRoot = gmp_init(3); // primitive root for 86

for ($i=0; $i<$passwordLength; $i++) {
    $char1 = $secret1[$i];
    $char2 = $secret2[$i];

    $code = (int) gmp_powm(
        $primitiveRoot,
        gmp_pow(ord($char1), ord($char2)),
        $dictionarySize
    );

    $password[] = $dictionary[$code];
}

echo implode('', $password);
