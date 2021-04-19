

function openEditPanel(ingredient){
    var panel = document.getElementById('edit-ingredient');
    var editNameField = document.getElementById('edit-name');
    var editCategoryField = document.getElementById('edit-category');
    var editId = document.getElementById('edit-id');
    editCategoryField.options[ingredient.category_id - 1].selected = true;
    editNameField.setAttribute('value', ingredient.name);
    editId.setAttribute('value', ingredient.id);
    panel.setAttribute('class', '');
}