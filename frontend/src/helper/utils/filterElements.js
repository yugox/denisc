export function byIndexes(array, indexes) {
    let filteredElements = [];

    for (const key in array) {
        if(Object.prototype.hasOwnProperty.call(array, key)) {
            if(!indexes.includes(parseInt(key))) {

                filteredElements.push(array[key]);
            }
        }
    }

    return filteredElements;
}

export function byKeyValue(array, key, value) {
    let filteredElements = [];

    array.forEach(function(element) {
        if(element[key] !== value) {
            filteredElements.push(element);
        }
    });

    return filteredElements;
}

export default {
    byIndexes,
    byKeyValue,
}
