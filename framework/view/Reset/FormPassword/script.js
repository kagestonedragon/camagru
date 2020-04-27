function sendAjaxRequest(username, token, password, password_confirm, url) {
    const errorText = document.getElementById('js-error-text');
    const preloader = document.getElementById('js-preloader');
    const submitButton = document.getElementById('js-submit-button');

    const request = new XMLHttpRequest();
    request.open('POST', url);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send('username=' + username + '&token=' + token + '&password=' + password + '&password-confirm=' + password_confirm);

    errorText.style.visibility = 'hidden';
    preloader.style.display = 'block';
    submitButton.style.display = 'none';
    request.addEventListener('readystatechange', function() {
        if (request.readyState === 4 && request.status === 200) {
            const result = JSON.parse(request.responseText);
            const statusCode = parseInt(result['STATUS']['CODE']);
            const statusText = result['STATUS']['TEXT'];

            if (statusCode >= 500) {
                errorText.innerHTML = statusText;
                errorText.style.visibility = 'visible';
                preloader.style.display = 'none';
                submitButton.style.display = 'block';
            } else {
                const successText = document.getElementById('js-success-text');
                const formInner = document.getElementById('js-form-inner');

                successText.style.display = 'block';
                formInner.style.display = 'none';
            }
        }
    });
}

function reset() {
    const url = document.getElementById('js-form').action;
    const submitButton = document.getElementById('js-submit-button');

    submitButton.addEventListener('click', function(e) {
        e.preventDefault();

        const username = document.getElementById('js-username').value;
        const password = document.getElementById('js-password').value;
        const password_confirm = document.getElementById('js-password-confirm').value;
        const token = document.getElementById('js-token').value;

        sendAjaxRequest(username, token, password, password_confirm, url);
    });
}

document.onreadystatechange = function() {
    if (document.readyState === 'complete') {
        reset();
    }
};