document.getElementById('generate-button').addEventListener('click', function () {
    var secret_1 = document.getElementById('secret-1').value,
        secret_2 = document.getElementById('secret-2').value,
        password_length = document.getElementById('password-length').value,
        useV2 = document.getElementById('use-generator-v2').checked,
        password;

    if (secret_1.length === 0) return;
    if (secret_2.length === 0) return;

    if (useV2) {
        password = generateFancyPasswordV2(secret_1, secret_2, password_length);
    } else {
        password = generateFancyPassword(secret_1, secret_2, password_length);
    }

    document.getElementById('password').value = password;
});

document.getElementById('show-passwords-checkbox').addEventListener('click', function (e) {
    var type = 'password';

    if (e.toElement.checked) {
        type = 'text';
    }

    document.getElementById('secret-1').setAttribute('type', type);
    document.getElementById('secret-2').setAttribute('type', type);
});