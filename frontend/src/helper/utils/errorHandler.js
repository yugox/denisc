import {isEmpty, indexOf} from 'lodash';

let elements = [];

function createErrorMessages(errors) {
    if (isEmpty(errors)) {
        return;
    }

    for (const error in errors) {
        if (Object.prototype.hasOwnProperty.call(errors, error)) {
            const inputErrors = errors[error];
            for (const inputError in inputErrors) {
                if (Object.prototype.hasOwnProperty.call(inputErrors, inputError)) {
                    const elementKey = removeCharacter(inputError);

                    if(indexOf(elements, elementKey) !== -1) {
                        return;
                    }

                    elements.push(elementKey);

                    const referenceElement = document.querySelector('#' + elementKey);

                    let element = document.createElement('small');
                    element.className = 'text-danger';
                    element.innerText = inputErrors[inputError];

                    referenceElement.after(element);
                }
            }
        }
    }
}

function removeCharacter(word) {
    return word.match(/\w+/gm)[0];
}

function removeErrorMessage(element) {
    const referenceElement = document.querySelector('#' + element);
    const childElements = referenceElement.nextSibling;

    if (childElements === null) {
        return;
    }

    childElements.remove();
}

function removeAllErrorElements() {
    elements.forEach((element) => {
        const referenceElement = document.querySelector('#' + element);
        const childElements = referenceElement.nextSibling;

        if (childElements === null) {
            return;
        }

        childElements.remove();
    });

    elements = [];
}

function exctractErrorMessages(array) {
    const errors = [];

    for(const key in array) {
        if(Object.prototype.hasOwnProperty.call(array, key)) {
            const splitted = key.match(/\w+/gm);
            const objectName = splitted[0];
            const ObjKey = splitted[1];

            const err = {
                [objectName]: {
                    [ObjKey]: array[key]
                }
            }
            errors.push(err);
        }
    }

    return errors;
}

export default {
    exctractErrorMessages,
    createErrorMessages,
    removeErrorMessage,
    removeAllErrorElements
}
