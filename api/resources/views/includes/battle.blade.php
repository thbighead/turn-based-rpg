<article id="battle_component" class="hidden">
    <section id="characters" data-filled="false">
        <div id="player" class="card hidden">
            <p><span class="name">Player name:</span> (<span class="race"></span>)</p>
            <p>HP: <span class="current-hp"></span>/<span class="max-hp"></span></p>
            <p>Strength: <span class="strength"></span></p>
            <p>Agility: <span class="agility"></span></p>
            <div class="card equipment">
                <p class="name"></p>
                <p>Attack bonus: <span class="attack-bonus"></span></p>
                <p>Defense bonus: <span class="defense-bonus"></span></p>
                <p>Dice: d<span class="dice-faces"></span></p>
            </div>
        </div>
        <button id="fight">Fight!</button>
        <div id="enemy" class="card hidden">
            <p><span class="name">Orc:</span> (<span class="race"></span>)</p>
            <p>HP: <span class="current-hp"></span>/<span class="max-hp"></span></p>
            <p>Strength: <span class="strength"></span></p>
            <p>Agility: <span class="agility"></span></p>
            <div class="card equipment">
                <p class="name"></p>
                <p>Attack bonus: <span class="attack-bonus"></span></p>
                <p>Defense bonus: <span class="defense-bonus"></span></p>
                <p>Dice: d<span class="dice-faces"></span></p>
            </div>
        </div>
    </section>
    <section>
        <button id="play_again" class="hidden">Play Again!</button>
        <small id="battle_errors" class="hidden"></small>
        <p id="log"></p>
    </section>
</article>
