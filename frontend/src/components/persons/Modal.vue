<template>
    <div class="row">
        <div class="modal" id="personModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-text="modalTitle"></h5>
                        <button type="button" class="close" aria-label="Close" @click="closeModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group text-left">
                            <label for="firstname">Vorname</label>
                            <input type="text"
                                   class="form-control"
                                   id="firstname"
                                   placeholder="Max"
                                   :value="localPerson.firstname"
                                   @input="localPerson.firstname = $event.target.value"
                                   @focus="removeErrorMessage($event.target.id)">
                        </div>
                        <div class="form-group text-left">
                            <label for="lastname">Nachname</label>
                            <input type="text"
                                   class="form-control"
                                   id="lastname"
                                   placeholder="Mustermann"
                                   :value="localPerson.lastname"
                                   @input="localPerson.lastname = $event.target.value"
                                   @focus="removeErrorMessage($event.target.id)">
                        </div>
                        <div class="form-group text-left">
                            <label for="age">Alter</label>
                            <input type="number"
                                   class="form-control"
                                   id="age"
                                   placeholder="30"
                                   min="1"
                                   :value="localPerson.age"
                                   @input="localPerson.age = $event.target.value"
                                   @focus="removeErrorMessage($event.target.id)">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-primary"
                                :disabled="!this.hasFieldsValues || this.inProcess"
                                @click="options.personEdit ? editPerson() : addPerson()">Speichern
                        </button>
                        <button
                                type="button"
                                class="btn btn-secondary"
                                @click="closeModal()">Schließen
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {ADD_PERSON, EDIT_PERSON, SELECTED_PERSON} from '../../store/modules/person/type';
    import {_store, _update} from '../../store/api/urls'
    import {mapActions, mapGetters, mapState} from 'vuex';
    import errorHandler from './../../helper/utils/errorHandler'
    import {flashTypes} from '../utils/flashMessage/flashTypes';
    import {PERSON_MODULE} from '../../store/modules/person';
    import {ERROR_MODULE} from '../../store/modules/error';
    import {GET_FIELD_ERRORS} from '../../store/modules/error/type';
    import {isNil, isEmpty} from 'lodash';

    export default {
        data() {
            return {
                localPerson: {
                    firstname: '',
                    lastname: '',
                    age: null,
                },
                inProcess: false,
            }
        },

        props: {
            options: {
                personEdit: {
                    type: Boolean,
                    default: false,
                },
            },
        },
        computed: {
            ...mapGetters(ERROR_MODULE, [GET_FIELD_ERRORS]),
            ...mapState(PERSON_MODULE, [SELECTED_PERSON]),

            getErrors() {
                const errors = this[GET_FIELD_ERRORS];
                return errorHandler.createErrorMessages(errors);
            },

            getPersonsBasicData() {
                return {
                    firstname: this.localPerson.firstname || '',
                    lastname: this.localPerson.lastname || '',
                    age: parseInt(this.localPerson.age || '0'),
                }
            },

            hasFieldsValues() {
                return this.localPerson.firstname.length > 0
                && this.localPerson.lastname.length > 0
                && (!isNil(this.localPerson.age) && !isEmpty(this.localPerson.age.toString()))
            },

            modalTitle() {
                return this.options.personEdit ? 'Person bearbeiten' : 'Person hinzufügen';
            }
        },
        methods: {
            ...mapActions(PERSON_MODULE, [ADD_PERSON, EDIT_PERSON]),

            closeModal() {
                this.$emit('showModal', false);
            },

            async addPerson() {
                if(!this.hasFieldsValues) {
                    return;
                }

                this.inProcess = true;

                const formData = {
                    person: this.getPersonsBasicData
                };

                this.$emit('showSpinner', true);

                errorHandler.removeAllErrorElements();

                const status = await this[ADD_PERSON]({
                    url: _store,
                    data: formData,
                });

                this.$emit('showSpinner', false);
                this.inProcess = false;

                if (status === 400) {
                    return this.getErrors;
                }

                if (status === 200) {
                    this.sendFlashMessageToParentComponent('Person wurde hinzugefügt');
                }

                this.closeModal();
            },

            async editPerson() {
                if(!this.hasFieldsValues) {
                    return;
                }

                this.inProcess = true;

                const formData = {
                    person: this.getPersonsBasicData,
                    id: this.localPerson.id,
                    index: this.localPerson.index,
                };

                this.lodash.merge(formData.person, this.getPersonsBasicData);
                this.$emit('showSpinner', true);

                errorHandler.removeAllErrorElements();

                const status = await this[EDIT_PERSON]({
                    url: _update,
                    data: formData,
                });

                this.$emit('showSpinner', false);
                this.inProcess = false;

                if (status === 400) {
                    return this.getErrors;
                }

                if (status === 204) {
                    this.sendFlashMessageToParentComponent('Person wurde bearbeitet');
                }

                this.closeModal();
            },

            sendFlashMessageToParentComponent(message) {
                this.$emit(
                    'flashMessage',
                    {
                        flashType: flashTypes.success,
                        message: message
                    }
                )
            },

            removeErrorMessage(element) {
                errorHandler.removeErrorMessage(element);
            },
        },

        created() {
            this.localPerson = this[SELECTED_PERSON];
        }
    }
</script>
