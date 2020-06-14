import {isEmpty} from "lodash";

export const filterPerson = {
    computed: {
        filteredPerson() {
            const personList = this.getPersons;
            if(isEmpty(personList)) {
                return [];
            }

            let firstname = this.searchedPerson.firstname || '';
            let lastname = this.searchedPerson.lastname || '';

            return personList.filter(
                element => element.firstname.toLocaleLowerCase().includes(firstname.toLocaleLowerCase())
                    && element.lastname.toLocaleLowerCase().includes(lastname.toLocaleLowerCase()));
        }
    }
}
