function confirmDelete(param) {
    swal({
        title: "¿Estás seguro?",
        text: "Recuerda que al eliminar un usuario borrarás todos sus registros",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: param,
                type: 'DELETE',
            });
            location.reload();
            swal("Eliminación exitosa!", {
                icon: "success",
            });
        }
      });
}
