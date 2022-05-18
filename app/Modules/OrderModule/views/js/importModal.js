export const importModal = () => {
    let btnImportGuide = document.getElementById("btnImportGuide");
    if (btnImportGuide == null) {
        return;
    }
    btnImportGuide.addEventListener('click', async () => {
        let formData = new FormData();
        let file = document.getElementById("file_import_guide");
        let order_id = document.getElementById("order_id").value;

        if (!file.files[0]) {
            return error('Debe cargar el archivo para proceder con la importación')
        }

        formData.append('file', file.files[0]);
        formData.append('order_id', order_id);

        let response = await sendImportModalData(formData);
        if (response.state == 200) {
            correct(response.message);
            location.reload()
        } else {
            error('Error al importar guías.')
            console.log('Error: ' + response.error);
        }
    });
}

const sendImportModalData = async (formData) => {
    let response = {
        'state': 500
    };

    let token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    let myHeaders = new Headers();
    myHeaders.append("accept", "application/json");
    myHeaders.append("Access-Control-Allow-Origin", "*");
    myHeaders.append("X-CSRF-TOKEN", token);
    let requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: formData,
    };

    response = await fetch(`/guias/import`, requestOptions)
    return response.json();
}