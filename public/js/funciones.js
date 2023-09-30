//Subir Promociones
function preview(e) {
    const url = e.target.files[0];
    const urlTmp = URL.createObjectURL(url);
    document.getElementById("img-preview").src = urlTmp;
    document.getElementById("icon-image").classList.add("d-none");
    document.getElementById("icon-cerrar").innerHTML = `
    <button class="btn btn-danger" onclick="deleteImg()"><i class="fas fa-times"></i></button>
    ${url['name']}<br>`;
}
function deleteImg(){
    document.getElementById("img-preview").src = '';
    const fileInput = document.getElementById("image");
    fileInput.value = '';
    const fotoActualInput = document.getElementById("foto_actual");
    if (fotoActualInput) {
        fotoActualInput.value = '';
    }
    document.getElementById("icon-cerrar").innerHTML = '';
    document.getElementById("icon-image").classList.remove("d-none");
}

function deleteFile() {
    const elementsToReset = [
        "icon-cerrar",
        "icon-image",
        "img-preview",
        "video-preview",
        "archivo_actual",
        "file-input",
        "delete-button"
    ];

    elementsToReset.forEach((elementId) => {
        const element = document.getElementById(elementId);
        if (element) {
            if (element.tagName === "IMG" || element.tagName === "VIDEO") {
                element.src = "";
                element.style.display = "none";
            } else if (element.tagName === "INPUT") {
                element.value = "";
            } else if (element.tagName === "BUTTON") {
                element.style.display = "none";
            } else {
                element.innerHTML = "";
            }
        }
    });
}

// Prevent users from deleting the custom elements
document.querySelector('.form-control').addEventListener('keydown', function (e) {
    const selection = window.getSelection();
    const range = selection.getRangeAt(0);
    const node = range.commonAncestorContainer;

    // Check if the user attempts to delete a custom element (span with class "br-tag")
    if (node.classList.contains('br-tag')) {
        e.preventDefault();
    }
});
