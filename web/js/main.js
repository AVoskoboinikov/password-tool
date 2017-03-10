document.getElementById('generate-button').addEventListener('click', function () {
    var secret_1 = document.getElementById('secret-1').value,
        secret_2 = document.getElementById('secret-2').value,
        password;

    password = generateFancyPassword(secret_1, secret_2);

    document.getElementById('password').value = password;
});
