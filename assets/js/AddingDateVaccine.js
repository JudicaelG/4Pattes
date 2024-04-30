let checkboxes = document.getElementById("vaccine");

console.log(checkboxes);

function addingDateInput(checkboxe){

    var getNameOfVaccineRegex = new RegExp("[^_]+$");
    var monTableau = getNameOfVaccineRegex.exec(checkboxe.getAttribute('id'))
    var $displayDateInput = document.getElementById('date_'+monTableau[0])

    if(checkboxe.checked){        
        $displayDateInput.classList.remove('hidden');
        
    }else{
        $displayDateInput.classList.add('hidden');
    }
}
