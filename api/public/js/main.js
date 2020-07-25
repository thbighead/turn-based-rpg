var loginComponent = document.getElementById('login_component');
var loginFormElement = document.getElementById('login_form');
var loginPlaySection = document.getElementById('play_section')
var loginGreetings = document.getElementById('player_greetings');
var loginPlayButton = document.getElementById('play_button');

var battleComponent = document.getElementById('battle_component');

var playerName = '';

loginPlayButton.addEventListener('click', function () {
    if (playerName.length > 0) {
        loginComponent.classList.add('hidden');
        battleComponent.classList.remove('hidden');
    }
})

var http = ajax({
    headers: {
        'content-type': 'application/json'
    }
});

loginFormElement.addEventListener('submit', function (e) {
    e.preventDefault();
    var errorBoxElement = this.querySelector('#errors');
    errorBoxElement.classList.add('hidden');

    http.post('/login', {
        nickname: this.querySelector('#player_name').value
    }).then(function (response) {
        playerName = response.nickname;
        if (response.is_new_player) {
            loginGreetings.textContent = 'Welcome ' + playerName + '! Prepare yourself to live a great adventure!';
        } else {
            loginGreetings.textContent = 'Welcome back ' + playerName + ', ready for another battle?';
        }
        loginPlaySection.classList.remove('hidden');
    }).catch(function (responseError) {
        loginPlaySection.classList.add('hidden');
        errorBoxElement.textContent = responseError.nickname.reduce(function (finalText, error) {
            return finalText + error;
        }, '');
        errorBoxElement.classList.remove('hidden');
    });
});
