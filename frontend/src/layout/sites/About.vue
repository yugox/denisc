<template>
    <div class="row">
        <div class="media">
            <img class="mr-3" src="../../assets/deniscosic.jpg" alt="Denis Cosic">
            <div class="media-body">
                <h5 class="mt-0">Über mich - Privates</h5>
                <p>Mein Name ist Denis Cosic und ich bin 31 Jahre alt.</p>
                <p>Geboren und bis zum 6. Lebensjahr aufgewachsen bin ich in Bosnien und Herzegowina. Ich lebe nun seit
                25 Jahre in Deutschland, bin hier zur Schule gegangen und habe auch meine Ausbildungen erfolgreich abgeschlossen.</p>
                <p>Ich bin eine zielstrebige und engagierte Person, die etwas im Leben und auch beruflich erreichen möchte.</p>
                <p>Ich habe mir mit meiner Verlobten vor 2 Jahren eine Doppelhaushälfte in Geesthacht gekauft und die Arbeit und Beschäftigung am Haus endet nie, es gibt immer etwas zu tun.</p>
                <p>Meine Freizeit besteht aus Haus-/Gartenarbeit, Playstation spielen, unsere zwei Kater unterhalten, mich in meinem Hauptbereich PHP weiterzuentwickeln und mich mit neuen
                Bereichen auseinanderzusetzen, darunter VueJs, Android Studio und evtl. bald auch Unity. In Zeiten von nicht Corona wird auch viel mit der
                Familie unternommen.</p>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import "../../scss/global";
    @include aboutMe();

@media (max-device-width: 500px) {
    .media {
        display: block;
    }
    img {
        margin-bottom: 10px;
    }
}
</style>