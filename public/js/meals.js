
var count = 1;
var selectFieldClass="rounded-md shadow-sm mb-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mr-1";
var inputFieldClass="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 inline-block mt-1 w-20 mb-2";
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
function addAnotherIngredientField(ingredientArray){
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
}

function clearShowIngredientsPanel(){
    seeMealCategories.innerHTML = '';
    seeMealIngredients.innerHTML = '';
}

function getMealInfo(mealId, type){
    var url = '/meals/' + mealId;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200){
            if(type === "see"){
                showIngredientsPanel(JSON.parse(this.response));
            } else if(type === "edit"){
                editMeal(JSON.parse(this.response));
            }
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