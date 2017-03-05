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
    ',','.',':',';','?','[',']','<','>','{','}'
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

for ($i=0; $i<$passwordLength; $i++) {
    $char1 = $secret1[$i];
    $char2 = $secret2[$i];

    $power = gmp_pow(
        ord($char1),
        ord($char2)
    );

    $code = gmp_powm(
        gmp_init(3),
        gmp_pow(ord($char1), ord($char2)),
        gmp_init(count($dictionary))
    );

    $password[] = $dictionary[(int) $code];
}

echo implode('', $password);
