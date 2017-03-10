var hash_complexity = 420000;
var password_length = 45;
var dictionary = [
    'Q','W','E','R','T','Y','U','I','O','P','A','S','D',
    'F','G','H','J','K','L','Z','X','C','V','B','N','M',

    'q','w','e','r','t','y','u','i','o','p','a','s','d',
    'f','g','h','j','k','l','z','x','c','v','b','n','m',

    '1','2','3','4','5','6','7','8','9',

    '~','!','@','#','$','%','^','&','*','(',')','_','+',
    ',','.',':',';','?','[',']','-','='
];

function generateFancyPassword(secret_1, secret_2) {
    var password = [],
        hashedSecret_1,
        hashedSecret_2,
        dictionary_size = dictionary.length,
        primitive_root = 2;

    hashedSecret_1 = secret_1;
    hashedSecret_2 = secret_2;

    for (var i=0; i<hash_complexity; i++) {
        hashedSecret_1 = sjcl.codec.hex.fromBits(sjcl.hash.sha256.hash(hashedSecret_1));
        hashedSecret_2 = sjcl.codec.hex.fromBits(sjcl.hash.sha256.hash(hashedSecret_2));
    }

    hashedSecret_1 = hashedSecret_1.split('');
    hashedSecret_2 = hashedSecret_2.split('');

    secret_1 = secret_1.split('');
    secret_2 = secret_2.split('');

    for (i=0; i<password_length; i++) {
        var hashChar_1, hashChar_2,
            secretChar_1, secretChar_2,
            code;

        hashChar_1 = hashedSecret_1[i % hashedSecret_1.length];
        hashChar_2 = hashedSecret_2[i % hashedSecret_2.length];

        secretChar_1 = secret_1[i % secret_1.length];
        secretChar_2 = secret_2[i % secret_2.length];

        code = bigInt(primitive_root)
            .modPow(
                bigInt(hashChar_1.charCodeAt(0) % secretChar_1.charCodeAt(0))
                    .pow(hashChar_2.charCodeAt(0) % secretChar_2.charCodeAt(0)) + i,
                dictionary_size
            );

        password.push(dictionary[code]);
    }

    return password.join('');
}