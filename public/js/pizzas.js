import * as utils from './utils.js';

window.onload = () => {
    init();

};


function init() {
    'use strict';

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            const pizzaData = JSON.parse(this.responseText);
            getPizzas(pizzaData);
            getToppings(pizzaData.toppings)
            getPizzaCrust(pizzaData.crusts)

        }
    };

    const url = '/js/pizzas.json';
    xhr.open('GET', url, true);
    xhr.send();
}


const getPizzas = (pizzasData) => {

    let pizzaDropdown = document.querySelector('#pizza');
    let option = document.createElement("option");
    utils.defaultSelectOption(option, 'select pizza')
    pizzaDropdown.add(option);
    utils.populateDropdown(pizzasData.pizzas, pizzaDropdown)

}

const getPizzaCrust = (pizzaData) => {

    let crustDropdown = document.querySelector('#crust');
    let option = document.createElement("option");
    utils.defaultSelectOption(option, 'select pizza crust')
    crustDropdown.add(option);
    utils.populateDropdown(pizzaData, crustDropdown)

}


const getToppings = toppings => {

    let toppingsDiv = document.querySelector('#toppingsDiv');

    toppings.forEach(topping => {

        let toppingOutput = `
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="toppings[]" value="${topping.type}" id="${topping.type}">
                <label class="form-check-label text-capitalize" for="${topping.type}">
                    ${topping.type} ${utils.formatMoney(topping.cost)}
                </label>
            </div>
        `;

        toppingsDiv.insertAdjacentHTML("beforeend", toppingOutput);

    });
}





