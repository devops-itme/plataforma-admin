function confirmDelete(param) {
    let token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    swal({
        title: "¿Estás seguro?",
        text: "Recuerda que al eliminar esto borrarás todos sus registros",
        icon: "warning",
        buttons: {
            cancel: "Cancelar",
            confirm: "Confirmar",
        },
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: param,
                type: "DELETE",
            });
            location.reload();
            swal("¡Eliminación exitosa!", {
                icon: "success",
            });
        }
    });
}
async function deleteResource(url, reload = false, row_id) {

    let result = await confirmation();

    if (result) {
        let req = await fetch(url, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content") ?? '',
                accept: "application/json",
            },
        })
            .then(response => response.json());
        console.log('req', req)
        if (req.state != 200) {
            error("Error al eliminar");
            return false;
        }
        await correct(req.message ?? "¡Eliminado!");
        if (reload) {
            window.location.reload();
        }
        if (row_id !== 'null') {
            table_row_id = document.getElementById(row_id);
            table_row_id?.remove();
        }
        return true;
    }
}

function confirmation(
    title = "¿Estás seguro?",
    text = "Al eliminar esto se borrarán todos los registros.",
    icon = "info"
) {
    return swal({
        title: title,
        text: text,
        icon: icon,
        buttons: {
            cancel: "Cancelar",
            confirm: "Confirmar",
        },
    });
}

function success(action = "realizar esta operación", message = "") {
    return swal({
        icon: "success",
        title: "Éxito al " + action,
        text: message ? message : "",
        timer: 2300,
    });
}
function error(message) {
    return swal({
        icon: "error",
        title: message,
    });
}
function correct(message) {
    return swal({
        icon: "success",
        title: message,
    });
}

function porDespacharPackagingAlert() {
    return swal("Seleccione el estado de la orden", {
        buttons: {
            delivery: {
                text: "Entrega!",
                value: 3,
            },
            pickup: {
                text: "Recogida!",
                value: 7,
            },
            cancel: "Cancelar",
        },
    })
}

function formatAMPM(data) {
    let date = new Date('2022/03/18 ' + data);
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}
