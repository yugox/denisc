<template>
    <div>
        <div class="row">
            <FlashMessage
                    v-if="flashMessages.showFlashMessage"
                    @showFlashMessage="flashMessages.showFlashMessage = $event"
                    :flash-type="flashMessages.flashType"
                    :message="flashMessages.message">
            </FlashMessage>
        </div>
        <div class="row">
            <div class="col text-left p-0 mx-2"
                 v-text="'Anzahl Personen:' + getPersonCount"
                 style="font-weight: bold"/>

            <div class="col text-right p-0">
                <button class="btn btn-outline-primary mx-2"
                        @click="addPersonModal()">
                    <i class="fa fa-plus"></i>
                    Hinzufügen
                </button>

                <button class="btn btn-outline-primary mx-2"
                        :disabled="selectedPersons.length <= 0"
                        @click="deletePerson()"
                >
                    <i class="fa fa-trash"></i>
                    Löschen
                </button>
            </div>
        </div>

        <div class="row">
            <input class="form-control my-3"
                   type="search"
                   placeholder="Vorname Nachname"
                   :disabled="getPersonCount <= 0"
                   @input="splitname($event.target.value)"
            />
        </div>

        <div class="row mt-2">
            <div class="col"></div>
            <div class="col font-weight-bold">Vorname</div>
            <div class="col font-weight-bold">Nachname</div>
            <div class="col font-weight-bold">Alter</div>
            <div class="col"></div>
        </div>

        <div v-if="options.isLoading"
             class="row justify-content-center">
            <div class="col col-8">
                <b-spinner variant="primary" label="Text Centered"></b-spinner>
            </div>
        </div>

        <template v-if="!options.isLoading">
            <Person v-for="(person, index) in filteredPerson" :key="person.id">
                <div class="col">
                    <label>
                        <input type="checkbox"
                               :value="{index: index, id: person.id}"
                               v-model="selectedPersons">
                    </label>
                </div>
                <div class="col"
                     v-text="person.firstname"/>
                <div class="col"
                     v-text="person.lastname"/>
                <div class="col"
                     v-text="formatAge(person.age)"/>
                <div class="col">
                    <div
                            style="cursor: pointer"
                            @click="editPersonModal(person, index)">
                        <i class="text-primary fa fa-edit"></i>
                    </div>
                </div>
            </Person>
        </template>

        <Modal v-if="options.showModal"
               @showSpinner="options.isLoading = $event"
               :options="options"
               @showModal="options.showModal = $event"
               @flashMessage="setFlashMessageFromEvent($event)"/>
    </div>
</template>

<script>
    import formatAge from '../../helper/formatter/formatAge'
    import {
        DELETE_PERSON,
        FETCH_PERSONS,
        GET_PERSONS,
        GET_TOTAL,
        SET_SELECTED_PERSON
    } from '../../store/modules/person/type';
    import {filterPerson} from '../../helper/mixins/filterPerson';
    import {mapActions, mapGetters} from 'vuex';
    import Modal from './Modal.vue';
    import Person from './Person.vue';
    import {_delete, _index} from '../../store/api/urls'
    import FlashMessage from '../utils/flashMessage/FlashMessage';
    import {flashTypes} from '../utils/flashMessage/flashTypes';
    import {PERSON_MODULE} from "../../store/modules/person";

    export default {
        data() {
            return {
                flashMessages: {
                    showFlashMessage: false,
                    flashType: '',
                    message: '',
                },
                selectedPersons: [],
                searchedPerson: {
                    firstname: '',
                    lastname: '',
                },
                options: {
                    personEdit: false,
                    showModal: false,
                    isLoading: false,
                },
            }
        },

        computed: {
            ...mapGetters(PERSON_MODULE, [GET_PERSONS, GET_TOTAL]),

            getPersons() {
                return this[GET_PERSONS] || [];
            },

            getPersonCount: function () {
                return this[GET_TOTAL] || 0;
            },
        },
        components: {
            FlashMessage,
            Person,
            Modal,
        },
        methods: {
            ...mapActions(PERSON_MODULE, [DELETE_PERSON, FETCH_PERSONS, SET_SELECTED_PERSON]),

            addPersonModal() {
                this[SET_SELECTED_PERSON]({...this.searchedPerson, age: null});
                this.options.personEdit = false;
                this.options.showModal = true;
            },

            async deletePerson() {
                if (this.selectedPersons.length <= 0) {
                    return false;
                }

                const formData = {
                    url: _delete,
                    data: this.selectedPersons,
                };

                this.options.isLoading = true;

                await this[DELETE_PERSON](formData);

                const personNoun = this.selectedPersons.length > 1 ? 'Personen' : 'Person'

                this.flashMessage(flashTypes.success, personNoun + ' wurde gelöscht');
                this.options.isLoading = false;
                this.selectedPersons = [];
            },

            editPersonModal(person, index) {
                this[SET_SELECTED_PERSON]({
                    ...person,
                    index: index
                });

                this.options.personEdit = true;
                this.options.showModal = true;
            },

            async fetchPersons() {
                this.options.isLoading = true;
                this[FETCH_PERSONS]({
                    url: _index
                });
                this.options.isLoading = false;
            },

            formatAge,

            flashMessage(type, message) {
                this.flashMessages.showFlashMessage = true;
                this.flashMessages.flashType = type;
                this.flashMessages.message = message;
            },

            setFlashMessageFromEvent(event) {
                this.flashMessage(event.flashType, event.message);
            },

            splitname(name) {
                [this.searchedPerson.firstname, this.searchedPerson.lastname] = name.split(/[\s,]+/);
            },
        },

        mixins: [filterPerson],

        async created() {
            if (this[GET_PERSONS] !== undefined
                && this[GET_PERSONS].length <= 0) {
                this.options.isLoading = true;
                await this.fetchPersons();
                this.options.isLoading = false;
            }
        },
    }
</script>

<style lang="scss">
    @import '../../scss/global.scss';

    @include modal;
</style>
