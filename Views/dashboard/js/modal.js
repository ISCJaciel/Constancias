function openEditModal(usuarioId, nombreActual, apellidoPaternoActual, apellidoMaternoActual) {
    document.getElementById('editUsuarioId').value = usuarioId;
    document.getElementById('nuevoNombre').value = nombreActual;
    document.getElementById('nuevoApellidoPaterno').value = apellidoPaternoActual;
    document.getElementById('nuevoApellidoMaterno').value = apellidoMaternoActual;

    var editNameModal = new bootstrap.Modal(document.getElementById('editNameModal'));
    editNameModal.show();
}
