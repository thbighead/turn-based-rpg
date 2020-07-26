var loginComponent = document.getElementById('login_component');
var loginFormElement = document.getElementById('login_form');
var loginPlaySection = document.getElementById('play_section')
var loginGreetings = document.getElementById('player_greetings');
var loginPlayButton = document.getElementById('play_button');

var battleComponent = document.getElementById('battle_component');
var battleFightButton = document.getElementById('fight');
var battleLogElement = document.getElementById('log');
var battlePlayAgainButton = document.getElementById('play_again');
var battleCharactersContainerElement = document.getElementById('characters');
var battlePlayerCardElement = document.getElementById('player');
var battleEnemyCardElement = document.getElementById('enemy');

var playerName = '';
var gameId = '';
var isGameOver = false;
var isFirstTurn = true;
var fillCharacterCard = function (cardElement, characterData) {
    cardElement.querySelector('.race').innerText = characterData.race;
    cardElement.querySelector('.max-hp').innerText = characterData.hit_points;
    cardElement.querySelector('.strength').innerText = characterData.strength;
    cardElement.querySelector('.agility').innerText = characterData.agility;
    cardElement.querySelector('.equipment .name').innerText =
        characterData.equipment.name;
    cardElement.querySelector('.equipment .attack-bonus').innerText =
        characterData.equipment.bonus_attack;
    cardElement.querySelector('.equipment .defense-bonus').innerText =
        characterData.equipment.bonus_defense;
    cardElement.querySelector('.equipment .dice-faces').innerText =
        characterData.equipment.dice_faces;
};
var battleNextTurn = function (ajaxSendData, errorBoxElement, buttonElement) {
    http.post('/next_turn', ajaxSendData).then(function (response) {
        var areCharactersFilled = battleCharactersContainerElement.dataset.filled === 'true';
        var game;

        isGameOver = response.message === 'Game Over';
        if (isGameOver) {
            game = response.game;
        } else {
            game = response;
        }

        var playerCharacter = game.player.character;
        var enemyCharacter = game.battle.character;
        var damagesTaken = game.battle.damages;

        if (!areCharactersFilled) {
            battlePlayerCardElement.querySelector('.name').innerText = playerName + ':';
            fillCharacterCard(battlePlayerCardElement, playerCharacter);
            fillCharacterCard(battleEnemyCardElement, enemyCharacter);
            battleCharactersContainerElement.dataset.filled = 'true';
        }

        battlePlayerCardElement.querySelector('.current-hp').innerText =
            '' + (playerCharacter.hit_points - damagesTaken.player);
        battleEnemyCardElement.querySelector('.current-hp').innerText =
            '' + (enemyCharacter.hit_points - damagesTaken.enemy);

        battlePlayerCardElement.classList.remove('hidden');
        battleEnemyCardElement.classList.remove('hidden');

        battleLogElement.innerHTML = textAfter(
            battleLogElement.innerText.replace(/\n/g, '<br>'),
            game.log.replace(/\n/g, '<br>')
        );

        if (game.battle.finished) {
            var logTextArrayLineByLine = battleLogElement.innerText.split(/\r?\n/);
            battleFightButton.innerText = logTextArrayLineByLine[logTextArrayLineByLine.length - 1].substr(3);
            battleFightButton.disabled = true;
        }
    }).catch(function (responseError) {
        errorBoxElement.textContent = responseError.nickname.reduce(function (finalText, error) {
            return finalText + error;
        }, '');
        errorBoxElement.textContent = responseError.game_id.reduce(function (finalText, error) {
            return finalText + '. ' + error;
        }, '');
        errorBoxElement.classList.remove('hidden');
    }).always(function () {
        buttonElement.disabled = false;
    });
};
var textAfter = function (searchText, text) {
    if (text.length <= 0) return searchText;

    if (searchText.length <= 0) return text;

    return text.substring(text.indexOf(searchText) + searchText.length);
};

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

loginPlayButton.addEventListener('click', function () {
    var errorBoxElement = document.getElementById('errors');
    errorBoxElement.classList.add('hidden');

    http.post('/play', {
        nickname: playerName
    }).then(function (response) {
        gameId = response._id;
        loginComponent.classList.add('hidden');
        battleComponent.classList.remove('hidden');
    }).catch(function (responseError) {
        loginPlaySection.classList.add('hidden');
        errorBoxElement.textContent = responseError.nickname.reduce(function (finalText, error) {
            return finalText + error;
        }, '');
        errorBoxElement.classList.remove('hidden');
    });
});

battleFightButton.addEventListener('click', function () {
    var errorBoxElement = document.getElementById('battle_errors');
    var buttonElement = this;
    var ajaxSendData = {
        nickname: playerName,
        game_id: gameId
    };
    errorBoxElement.classList.add('hidden');

    if (!isGameOver) {
        buttonElement.disabled = true;
        if (isFirstTurn) {
            http.post('/battle', ajaxSendData).then(function () {
                isFirstTurn = false;
                battleNextTurn(ajaxSendData, errorBoxElement, buttonElement);
            }).catch(function (responseError) {
                errorBoxElement.textContent = responseError.nickname.reduce(function (finalText, error) {
                    return finalText + error;
                }, '');
                errorBoxElement.textContent = responseError.game_id.reduce(function (finalText, error) {
                    return finalText + '. ' + error;
                }, '');
                errorBoxElement.classList.remove('hidden');
            });
        } else {
            battleNextTurn(ajaxSendData, errorBoxElement, buttonElement);
        }
    }
});

battlePlayAgainButton.addEventListener('click', function () {
    var errorBoxElement = document.getElementById('battle_errors');
    errorBoxElement.classList.add('hidden');
    battleLogElement.innerText = '';
    isGameOver = false;

    http.post('/play', {
        nickname: playerName
    }).then(function (response) {
        gameId = response._id;
        battlePlayerCardElement.classList.add('hidden');
        battleEnemyCardElement.classList.add('hidden');
        battleCharactersContainerElement.dataset.filled = 'false';
    }).catch(function (responseError) {
        errorBoxElement.textContent = responseError.nickname.reduce(function (finalText, error) {
            return finalText + error;
        }, '');
        errorBoxElement.textContent = responseError.game_id.reduce(function (finalText, error) {
            return finalText + '. ' + error;
        }, '');
        errorBoxElement.classList.remove('hidden');
    });
});
