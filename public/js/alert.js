function confirmDelete(param) {
    let token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    swal({
        title: "¿Estás seguro?",
        text: "Recuerda que al eliminar un usuario borrarás todos sus registros",
        icon: "warning",
        buttons: true,
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
            swal("Eliminación exitosa!", {
                icon: "success",
            });
        }
    });
}
async function deleteResource(url) {
    let result = await confirmation();
    if (result == true) {
        let req = await fetch(url, {
            method: "delete",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                accept: "application/json",
            },
        });
        if (req.ok) {
            correct("Eliminado!");
            return true;
        } else {
            error("Error al eliminar");
            return false;
        }
    }
}

function confirmation(
    title = "¿Estas Seguro?",
    text = "Se eliminara esto",
    icon = "info"
) {
    return swal({
        title: title,
        text: text,
        icon: icon,
        buttons: {
            cancel: 'Cancelar',
            confirm: 'Confirmar'
        }
    });
}

function success(action = "realizar esta operacion", message = "") {
    return swal({
        icon: "success",
        title: "Exito al " + action,
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
