<template>
    <div>
        <div class="row">
            <div class="card mb-5">
                <h5 class="card-header">Herzlich Willkommen zu meiner kleinen Webseite</h5>
                <div class="card-body">
                    <p>Ich habe mir gedacht, dass ich mal etwas anderes, als nur einen Lebenslauf mache.
                       Bei der Programmierung habe ich versucht möglichst viel von meinem momentanen Wissensstand
                       abzudecken.
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="w-100 card">
                <h5 class="card-header">Personen Component zum Testen</h5>
                <div class="card-body">
                    <Grid/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Grid from "../../components/persons/Grid";

    export default {
        components: {
            Grid
        }
    }
</script>

<style lang="scss" scoped>
    @import "../../../src/scss/global";

    .checkbox {
        margin-left: 8px;
    }

    .checkbox label input {
        margin-right: 5px;
    }

    .card-title {
        @include cardHeading
    }
</style>
