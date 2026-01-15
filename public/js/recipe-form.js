// Ajouter un ingrédient
function addIngredient() {
    const div = document.createElement('div');
    div.classList.add('ingredient');

    div.innerHTML = `
        <input type="text" name="name_ingredient[]" placeholder="Nom">
        <input type="number" name="quantity_ingredient[]" placeholder="Quantité">
        <input type="text" name="unity_ingredient[]" placeholder="Unité">
        <button type="button" class="remove-btn" onclick="removeField(this)">Supprimer</button>
    `;

    document.getElementById('ingredients').appendChild(div);
}

// Ajouter une étape
function addStep() {
    const div = document.createElement('div');
    div.classList.add('step');

    div.innerHTML = `
        <input type="number" name="order_step[]" placeholder="Ordre">
        <input type="text" name="description_step[]" placeholder="Description">
        <button type="button" class="remove-btn" onclick="removeField(this)">Supprimer</button>
    `;

    document.getElementById('steps').appendChild(div);
}

// Supprimer un champ (ingrédient ou étape)
function removeField(button) {
    button.parentElement.remove();
}