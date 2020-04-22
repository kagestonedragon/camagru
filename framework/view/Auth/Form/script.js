function sendAjax(url, login, password) {
    const errorText = document.getElementById('js-error');
    const request = new XMLHttpRequest();
    request.open('POST', url);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send('username=' + login + '&password=' + password);
    request.addEventListener('readystatechange', function () {
        if (request.readyState === 4 && request.status === 200) {
            const resultAjax = JSON.parse(request.responseText);
            if (parseInt(resultAjax['STATUS']['CODE']) >= 500) {
                errorText.style.display = 'block';
                errorText.innerHTML = resultAjax['STATUS']['TEXT'];
            } else {
                document.location.href = 'https://kagestonedragon.tech';
            }
        }
    });
}

function authAction() {
    const submitButton = document.getElementById('js-button');
    submitButton.addEventListener('click', function(e){
        e.preventDefault();
        const errorText = document.getElementById('js-error');
        const url = document.getElementById('js-form').action;
        const login = document.getElementById('js-login').value;
        const password = document.getElementById('js-password').value;
        errorText.style.display = 'none';

        const resultAjax = sendAjax(url, login, password);
    });
}

document.onreadystatechange = function() {
    if (document.readyState === 'complete') {
        authAction();
    }
};
