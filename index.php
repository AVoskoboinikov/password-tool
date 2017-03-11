<?php

$secret1 = null;
$secret2 = null;
$passwordLength = 15;

$dictionary = [
    '=',

    'Q','W','E','R','T','Y','U','I','O','P','A','S','D',
    'F','G','H','J','K','L','Z','X','C','V','B','N','M',

    'q','w','e','r','t','y','u','i','o','p','a','s','d',
    'f','g','h','j','k','l','z','x','c','v','b','n','m',

    '1','2','3','4','5','6','7','8','9',

    '~','!','@','#','$','%','^','&','*','(',')','_','+',
    ',','.',':',';','?','[',']','-'
];

$options = getopt('', ['s1:','s2:']);

if (empty($options['s1']) || empty($options['s2'])) {
    die('Provide secret words');
}

$secret1 = $options['s1'];
$secret2 = $options['s2'];

$password = [];
$hashedSecret1 = str_split(hash('sha256', $secret1));
$hashedSecret2 = str_split(hash('sha256', $secret2));

$secret1 = str_split($secret1);
$secret2 = str_split($secret2);

$dictionarySize = gmp_init(count($dictionary)); // 83
$primitiveRoot = gmp_init(2); // primitive root for 83

for ($i=0; $i<$passwordLength; $i++) {
    $hashChar1 = $hashedSecret1[$i % count($hashedSecret1)];
    $hashChar2 = $hashedSecret2[$i % count($hashedSecret2)];

    $secretChar1 = $secret1[$i % count($secret1)];
    $secretChar2 = $secret2[$i % count($secret2)];

    $code = (int) gmp_powm(
        $primitiveRoot,
        gmp_pow(
            ord($hashChar1) % ord($secretChar1),
            ord($hashChar2) % ord($secretChar2)
        ),
        $dictionarySize
    );

    $password[] = $dictionary[$code];
}

echo implode('', $password);
