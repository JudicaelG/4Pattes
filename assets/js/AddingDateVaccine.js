let checkboxes = document.getElementById("vaccine");

console.log(checkboxes);

function addingDateInput(div){


    var checkboxe = div.querySelector("input[type='checkbox']");
    if(checkboxe.checked){
        var inputElement = document.createElement("input");

        // Définissez les attributs de l'input
        inputElement.setAttribute("type", "text");
        inputElement.setAttribute("name", "newInput");
        inputElement.setAttribute("id", "newInputId");
    
        // Obtenez une référence à la div où vous souhaitez ajouter l'input
    
        // Ajoutez l'input à la div
        div.appendChild(inputElement); 
    }
    /*var inputElement = document.createElement("input");

    // Définissez les attributs de l'input
    inputElement.setAttribute("type", "text");
    inputElement.setAttribute("name", "newInput");
    inputElement.setAttribute("id", "newInputId");

    // Obtenez une référence à la div où vous souhaitez ajouter l'input

    // Ajoutez l'input à la div
    div.appendChild(inputElement);*/
}
