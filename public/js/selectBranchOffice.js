async function selectBranchOffice(id) {
    await fetch("/sucursales_cliente/"+id)
    .then(response => response.json())
    .then(data =>{

        //Seleccionar siempre el index 0
        document.getElementById("branchOfficeSlc").selectedIndex = "0";

        let modalSlc = document.getElementById("branchOfficeSlc");

        //Eliminar los demás datos que no existan
        removeOptions(document.getElementById("branchOfficeSlc"));
        for (var i = 0; i < data.length; i++) {
            let element = data[i];
            let branchOffice = '<option value="'+element.id+'"> '+element.name+' </option>';
            modalSlc.insertAdjacentHTML('beforeend', branchOffice);
        }
    });
    $("#selectBranchOffice").modal('show');

    //Set route
    let slcBranchOffices = document.getElementById("branchOfficeSlc");
    slcBranchOffices.addEventListener('change',(event) => {
        document.getElementById("btnContinue").href= "departamentos/"+slcBranchOffices.value;
    })
}

function removeOptions(selectElement) {
    var i, L = selectElement.options.length - 1;
    for(i = L; i > 0; i--) {
        selectElement.remove(i);
    }
}
