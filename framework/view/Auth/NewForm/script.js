function sendAjaxRequest(username, password, url) {
    const errorText = document.getElementById('js-error-text');
    const preloader = document.getElementById('js-preloader');
    const submitButton = document.getElementById('js-submit-button');

    const request = new XMLHttpRequest();
    request.open('POST', url);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send('username=' + username + '&password=' + password);

    errorText.style.visibility = 'hidden';
    submitButton.style.display = 'none';
    preloader.style.display = 'block';
    request.addEventListener('readystatechange', function() {
        if (request.readyState === 4 & request.status === 200) {
            const result = JSON.parse(request.responseText);
            const statusCode = parseInt(result['STATUS']['CODE']);
            const statusText = result['STATUS']['TEXT'];

            if (statusCode >= 500) {
                errorText.innerHTML = statusText;
                errorText.style.visibility = 'visible';
                submitButton.style.display = 'block';
                preloader.style.display = 'none';
            } else {
                document.location.href = 'https://kagestonedragon.tech';
            }
        }
    });
}

function authorization() {
    const url = document.getElementById('js-form').action;
    const submitButton = document.getElementById('js-submit-button');

    submitButton.addEventListener('click', function(e) {
        e.preventDefault();

        const username = document.getElementById('js-username').value;
        const password = document.getElementById('js-password').value;

        sendAjaxRequest(username, password, url);
    });
}

document.onreadystatechange = function() {
    if (document.readyState === 'complete') {
        authorization();
    }
};