// public/js/custom-scripts.js

window.TrackJS &&
  TrackJS.install({
    token: "ee6fab19c5a04ac1a32a645abde4613a",
    application: "argon-dashboard-free"
  });

function openConfirmPopup(button) {
  const deleteatributes = button.getAttribute('data-id');
  const confirmPopup = document.getElementById('confirm-popup');
  const confirmYes = document.getElementById('confirm-yes');
  const confirmNo = document.getElementById('confirm-no');
  const deleteForm = document.getElementById('delete-form-' + deleteatributes);

  confirmPopup.style.display = 'block';

  confirmYes.addEventListener('click', function() {
      deleteForm.submit();
  });

  confirmNo.addEventListener('click', function() {
      confirmPopup.style.display = 'none';
  });
}

function btnInactivatePromotion(id, event) {
    event.preventDefault();

    Swal.fire({
        title: '¿Estás seguro?',
        text: 'La promoción pasará a estado inactivo.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, inactivarla',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.get(`/promociones/inactivate/${id}`)
                .then(response => {
                    if (response.status === 200) {
                        Swal.fire(
                            'Mensaje',
                            'Promoción desactivada con éxito.',
                            'success'
                        ).then(() => {
                            window.location.reload();
                        });
                    }
                })
                .catch(error => {
                    if (error.response && error.response.status === 500) {
                        Swal.fire(
                            'Mensaje',
                            'Error al inactivar la promoción',
                            'error'
                        );
                    }
                });
        }
    });
}

function btnReactivatePromotion(id, event) {
    event.preventDefault();

    Swal.fire({
        title: '¿Estás seguro de reactivarla?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, reactivarla',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.get(`/promociones/reactivate/${id}`)
                .then(response => {
                    if (response.status === 200) {
                        Swal.fire(
                            'Mensaje',
                            'Promoción reactivada con éxito.',
                            'success'
                        ).then(() => {
                            window.location.reload();
                        });
                    }
                })
                .catch(error => {
                    if (error.response && error.response.status === 500) {
                        Swal.fire(
                            'Mensaje',
                            'Error al reactivar la promoción',
                            'error'
                        );
                    }
                });
        }
    });
}

