// js/main.js
document.addEventListener("DOMContentLoaded", function () {
  console.log("main.js se ha cargado correctamente");

  // Seleccionar los formularios de creación y edición
  const createForm = document.querySelector('form[action*="create"]');
  const editForm = document.querySelector('form[action*="edit"]');

  // Función de validación
  function validateForm(form) {
    const title = form.querySelector("#title");
    let valid = true;

    // Validar título
    if (title.value.trim() === "") {
      showError(title, "El título es obligatorio.");
      valid = false;
    } else {
      clearError(title);
    }

    return valid;
  }

  // Mostrar mensaje de error
  function showError(input, message) {
    let error = input.nextElementSibling;
    if (!error || !error.classList.contains("error-message")) {
      error = document.createElement("div");
      error.classList.add("error-message");
      input.parentNode.insertBefore(error, input.nextSibling);
    }
    error.textContent = message;
  }

  // Limpiar mensaje de error
  function clearError(input) {
    let error = input.nextElementSibling;
    if (error && error.classList.contains("error-message")) {
      error.remove();
    }
  }

  // Agregar event listener para validación en submit
  if (createForm) {
    createForm.addEventListener("submit", function (event) {
      if (!validateForm(createForm)) {
        event.preventDefault();
      }
    });
  }

  if (editForm) {
    editForm.addEventListener("submit", function (event) {
      if (!validateForm(editForm)) {
        event.preventDefault();
      }
    });
  }

  // 


  document
    .querySelectorAll("button[id^='btnFavorito-']")
    .forEach(function (button) {
      button.addEventListener("click", function () {
        const titulo = this.id.replace("btnFavorito-", "");
        console.log("Título:", titulo);

        fetch("index.php?action=toggleFavorito", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: `titulo=${encodeURIComponent(titulo)}`,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              const starElement = this.querySelector("i.bi-star-fill");
              starElement.textContent = data.newCount;

              if (data.isFavorited) {
                this.classList.add("favorited");
              } else {
                this.classList.remove("favorited");
              }
            } else {
              alert("Error al actualizar el favorito.");
            }
          })
          .catch((error) => {
            console.error("Error:", error);
          });
      });
    });


    // 
});
