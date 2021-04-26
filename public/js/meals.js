var count = 1;
var selectFieldClass="rounded-md shadow-sm mb-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mr-1";
var inputFieldClass="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 inline-block mt-1 w-20 mb-2";
var buttonClass="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150";
var ingredientCount = document.getElementById('ingredientCount');

// Ingredient control panel
function openEditIngredientPanel(ingredient){
    var panel = document.getElementById('edit-ingredient');
    var editNameField = document.getElementById('edit-name');
    var editCategoryField = document.getElementById('edit-category');
    var editId = document.getElementById('edit-id');
    editCategoryField.options[ingredient.category_id - 1].selected = true;
    editNameField.setAttribute('value', ingredient.name);
    editId.setAttribute('value', ingredient.id);
    panel.setAttribute('class', '');
}

// Meal control panel Edit
function openEditMealPanel(meal){
    console.log(meal);
    var panel = document.getElementById('edit-meal');
    var editNameField = document.getElementById('edit-name');
    var editCategoryField = document.getElementById('edit-categories');
    var editId = document.getElementById('edit-id');
    editCategoryField.options[meal.category_id - 1].selected = true;
    editNameField.setAttribute('value', meal.name);
    editId.setAttribute('value', meal.id);
    panel.setAttribute('class', '');
}

// Meal control: adding new ingredient fields to a new meal
function addAnotherIngredientField(){
    var url = '/allingredients';
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200){
            setNewIngredientField(JSON.parse(this.response));
        }
    }
    xhttp.open('GET', url, true);
    xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
    xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhttp.send();
}

function setNewIngredientField(ingredientArray){
    count++;
    ingredientCount.setAttribute('value', count);
    var ingredientsSelect = createSelectField(ingredientArray, 'ingredient'+count);
    var ingredientAmount = createInputField('number', 'ingredientAmount'+count);
    ingredientsSelect.required = true;
    ingredientAmount.required = true;
    var inputDiv = document.createElement('div');
    inputDiv.setAttribute('id', 'field'+count);
    inputDiv.appendChild(ingredientsSelect);
    inputDiv.appendChild(ingredientAmount);
    var ingredientsDiv = document.getElementById('ingredientsDiv');
    ingredientsDiv.appendChild(inputDiv);
}

function removeLastIngredientField(){
    if(count > 1){
        var lastIngredientField = document.getElementById('field'+count);
        lastIngredientField.remove();
        count--;
        ingredientCount.setAttribute('value', count);
    }
}

var seeMealClass="overflow-auto h-auto container bg-gray-50 rounded-md shadow p-3 col-auto";
var seeMealPanel = document.getElementById('seeMealPanel');
var seeMealTitle = document.getElementById('seeMealTitle');
var seeMealIngredients = document.getElementById('seeMealIngredients');
var seeMealCategories = document.getElementById('seeMealCategories');

// Show ingredients when clicking on a meal
function showIngredientsPanel(meal){
    seeMealPanel.setAttribute('class', seeMealClass);
    clearShowIngredientsPanel();
    seeMealTitle.textContent = ucfirst(meal.name);
    for(var i = 0 ; i < meal.ingredients.length ; i++){
        seeMealIngredients.innerHTML += meal.ingredients[i].amount + " " + ucfirst(meal.ingredients[i].name) + "<br />";
    }
    for(var i = 0 ; i < meal.categories.length ; i++){
        seeMealCategories.appendChild(createImageElement(meal.categories[i].icon, 'w-5 h-5 inline'));
    }
    seeMealPanel.appendChild(createLink('/meal/recipe/'+meal.id, 'See recipe'));
}

function clearShowIngredientsPanel(){
    seeMealCategories.innerHTML = '';
    seeMealIngredients.innerHTML = '';
}

function getMealInfo(mealId){
    var url = '/meals/' + mealId;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200){
            showIngredientsPanel(JSON.parse(this.response));
        }
    }
    xhttp.open('GET', url, true);
    xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
    xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhttp.send();
}

function hideMealInfo(){
    seeMealPanel.setAttribute('class', seeMealClass + " hidden");
}

// Helper functions
function ucfirst(string){
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function createSelectField(options, name){
    var inputField = document.createElement("select");
    inputField.setAttribute('class', selectFieldClass);
    inputField.setAttribute('id', name);
    inputField.setAttribute('name', name);
    for(var i = 0 ; i < options.length ; i++){
        var option = document.createElement('option');
        option.value = options[i].id;
        option.text = ucfirst(options[i].name);
        inputField.appendChild(option);
    }
    return inputField;
}

function createInputField(type, name){
    var inputField = document.createElement("input");
    inputField.setAttribute('class', inputFieldClass);
    inputField.setAttribute('type', type);
    inputField.setAttribute('id', name);
    inputField.setAttribute('name', name);
    return inputField;
}

function createLink(src, text){
    var a = document.createElement('a');
    a.setAttribute('href', src);
    a.innerHTML = text;
    return a;
}

// function createTextElement(text){
//     var textElement = document.createElement('p');
//     textElement.textContent = text;
//     return textElement;
// }

function createImageElement(src, classAttr){
    var imageElement = document.createElement('img');
    imageElement.setAttribute('src', src);
    imageElement.setAttribute('class', classAttr)
    return imageElement;
}

function catchIngredientCount(){
    ingredientCountInput = document.getElementById('ingredientCount');
    if(ingredientCountInput){
        count = ingredientCountInput.value;
    }
}

catchIngredientCount();


function toggleEditIngredientSupply(ingredientSupplyId){
    var url = '/ingredientsSupply/' + ingredientSupplyId;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200){
            toggleEditSupply(JSON.parse(this.response));
        }
    }
    xhttp.open('GET', url, true);
    xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
    xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhttp.send();
}

function toggleEditSupply(ingredientSupply){
    var row = document.getElementById('row'+ingredientSupply.id)
    row.innerHTML = '';
    var td = document.createElement('td');
    td.setAttribute('colspan', '4');
    var inputField = createInputField('number', 'ingredientAmount');
    td.appendChild(inputField);
    var submitButton = createButton('submit', 'Save');
    submitButton.setAttribute('onclick', 'updateSupply('+ingredientSupply.id+')');
    td.appendChild(submitButton);
    row.appendChild(td);
}

function createButton(type, text){
    var button = document.createElement('button');
    button.setAttribute('type', type);
    button.setAttribute('class', buttonClass);
    button.innerHTML = text;
    return button;
}

function updateSupply(ingredientSupplyId){
    var url = '/ingredientsSupply/' + ingredientSupplyId;
    var xhttp = new XMLHttpRequest();
    var inputItem = document.getElementById('ingredientAmount');
    xhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200){
            location.reload();
        } else {
            console.log(this.response);
        }
    }
    xhttp.open('PUT', url, true);
    xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
    xhttp.setRequestHeader('Content-type', "application/x-www-form-urlencoded");
    xhttp.send("amount="+inputItem.value);
}
