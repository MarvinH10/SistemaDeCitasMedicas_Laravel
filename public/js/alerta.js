// public/js/custom-scripts.js

window.TrackJS &&
  TrackJS.install({
    token: "ee6fab19c5a04ac1a32a645abde4613a",
    application: "argon-dashboard-free"
  });

function openConfirmPopup(button) {
  const employerId = button.getAttribute('data-id');
  const confirmPopup = document.getElementById('confirm-popup');
  const confirmYes = document.getElementById('confirm-yes');
  const confirmNo = document.getElementById('confirm-no');
  const deleteForm = document.getElementById('delete-form-' + employerId);

  confirmPopup.style.display = 'block';

  confirmYes.addEventListener('click', function() {
      deleteForm.submit();
  });

  confirmNo.addEventListener('click', function() {
      confirmPopup.style.display = 'none';
  });
}