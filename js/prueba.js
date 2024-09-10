const mainArea = document.getElementById("mainArea");
const formCreateH = document.getElementById("formCreateH");

const fCreateGenero = document.querySelector("fCreateGenero");
const fCreateStatus = document.querySelector("fCreateStatus");

document.addEventListener("DOMContentLoaded", function () {
  fetch("./views/puente.php")
    .then((response) => response.json())
    .then((data) => {
      const generos = data.generos;
      const estados = data.estados;
      const autorStory = data.autorStory;

      // Crear Historia.
      if (formCreateH) {
        showCreateHistoria(generos, estados, autorStory);
      }
    })
    .catch((error) => console.error("Error fetching data:", error));
});

// CREAR HISTORIA.

// Mostrar los botones de Crear o Editar Historia.
function showFormHeadCreateStory(generos, estados, autorStory) {
  formCreateH.replaceChildren();
  formCreateH.insertAdjacentHTML(
    "beforebegin",
    `<h1 class="tituloCreateHistoria">Crear/Editar Historia</h1>
    <div id="formHeadStory">
      <button id="btnCreateHistoria" class="btn btnCHistoria" type="button">Crear Historia</button>
      <button id="btnEditHistoria" class="btn btnCHistoria" type="button">Editar Historia</button>
    </div>
    <div id="formMainStory"></div>`
  );

  document
    .getElementById("btnCreateHistoria")
    .addEventListener("click", () => saveStory(generos, estados));
  document
    .getElementById("btnEditHistoria")
    .addEventListener("click", () => editStory(generos, estados, autorStory));
}

// Si le da a crear Historia.
function saveStory(generos, estados) {
  const formMainStory = document.getElementById("formMainStory");

  // Reemplaza el contenido del formMainStory con el formulario
  formMainStory.replaceChildren();

  let formu = `<form name="fCreateStory" role="form" class="container">
      <div id="mainFormStorySave">
          <div class="mb-3">
              <label for="titulo" class="form-label"><h4>Título: </h4></label>
              <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Titulo de la Historia" required>
          </div>

          <div class="mb-3">
              <label for="portada" class="form-label"><h4>Portada: </h4></label>
              <input type="file" id="portada" name="portada" class="form-control">
          </div>

          <div class="mb-3">
              <label for="tituloCap" class="form-label"><h4>Título Capítulo: </h4></label>
              <input type="text" id="tituloCap" name="tituloCap" class="form-control" placeholder="titulo del capítulo">
          </div>

          <div class="mb-3">
            <label for="sinopsis" class="form-label"><h4>Sinopsis:</h4></label>
            <textarea class="form-control" name="sinopsis" id="sinopsis" rows="5"></textarea>
          </div>

          <div class="mb-3">
            <label for="historia" class="form-label"><h4>Historia:</h4></label>
            <textarea class="form-control" name="historia" id="historia" rows="10" required></textarea>
          </div>

          <div class="row mb-3">
            <div class="form-floating col-12 col-md-6 mb-3 mb-md-0">
              <select class="form-select" name='estado' id="estado" aria-label="Etiqueta flotante de estado">`;

  for (const status of estados) {
    formu += `<option value="${status["IdEstado"]}">${status["Nombre"]}</option>`;
  }

  formu += `</select>
              <label for="estado">Selecciona un estado</label>
            </div>

            <div class="form-floating col-12 col-md-6">
              <select name='genero[]' id="generoSelect" class="form-select genSelect" multiple aria-label="Etiqueta flotante de género">`;

  for (const gen of generos) {
    formu += `<option value="${gen["IdGenero"]}">${gen["Nombre"]}</option>`;
  }

  formu += `</select>
              <label for="floatingSelect">Selecciona un género</label>
            </div>
          </div>

          <div id="btnCrearEditarH" class="text-center">
              <button id="btnCreateH" class="btn btnCHistoria" type="submit">Crear Historia</button>
          </div>
      </div>
      </form>`;

  formMainStory.insertAdjacentHTML("beforeend", formu);

  // Agregar el evento de submit al formulario para llamar a la función handleCreateGenero
  const form = document.querySelector("form[name='fCreateStory']");
  form.addEventListener("submit", handleCreateStory);
}

function handleCreateStory() {
  // Agrega el event listener para manejar el botón "Crear Historia"
  const historiaElement = document.getElementById("historia");

  const formData = new FormData();
  formData.append("titulo", document.getElementById("titulo").value);
  formData.append("portada", document.getElementById("portada").files[0]);
  formData.append("tituloCap", document.getElementById("tituloCap").value);
  formData.append("sinopsis", document.getElementById("sinopsis").value);
  formData.append("historia", historiaElement ? historiaElement.value : "");

  // Convertir los géneros seleccionados a JSON
  const selectedGeneros = [...document.getElementById("generoSelect").options]
    .filter((option) => option.selected)
    .map((option) => option.value);
  formData.append("genero", JSON.stringify(selectedGeneros));

  formData.append("estado", document.getElementById("estado").value);

  fetch("./views/puente.php?crearHistoriaCompleta", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Historia creada con éxito");

        // Llamar a la función para limpiar el formulario
        limpiarFormularioHistoria();
      } else {
        alert("Error: " + data.error);
      }
    })
    .catch((error) => console.error("Error:", error));
}

// Limpiar el formulario de Crear Historia.
function limpiarFormularioHistoria() {
  document.getElementById("titulo").value = "";
  document.getElementById("portada").value = "";
  document.getElementById("tituloCap").value = "";
  document.getElementById("sinopsis").value = "";
  document.getElementById("historia").value = "";
  document.getElementById("generoSelect").selectedIndex = 0; // Deseleccionar todas las opciones
  document.getElementById("estado").selectedIndex = 1; // Restablecer a la opción predeterminada
}

function editStory(generos, estados, autorStory) {
  const formMainStory = document.getElementById("formMainStory");

  // Si ya existe el select 'autorStory', lo eliminamos para no duplicar
  let existingSelect = document.getElementById("autorStory");
  if (existingSelect) {
    existingSelect.remove();
  }

  // Limpia el contenido del área principal del formulario para evitar duplicados
  formMainStory.replaceChildren();

  // Crear y agregar el select de historias
  let formu = `<form name="fSelectStory" role="form" class="container">
    <div class="mb-3">
      <select id='autorStory' name='autorStory' class="form-select">
        <option value='' selected>Seleccione una historia</option>`;

  for (const story of autorStory) {
    formu += `<option value="${story["IdHistoria"]}">${story["Titulo"]}</option>`;
  }
  formu += `</select></div>

    <div class="text-center">
      <button id="btnCreateH" class="btn btnCHistoria" type="button">Buscar Historia</button>
    </div>

    <div id="formuEditStory"></div>
    </form>`;

  formMainStory.insertAdjacentHTML("beforeend", formu);

  document
    .getElementById("btnCreateH")
    .addEventListener("click", () => selecStory(generos, estados));
}

// Mostrar los datos de la historia seleccionada y despegable de capítulos para elegir editar si quiere el usuario.
function selecStory(generos, estados) {
  const selecHistoria = document.getElementById("autorStory").value;
  const formuEditStory = document.getElementById("formuEditStory");

  if (selecHistoria != "") {
    fetch("./views/puente.php?selecStory=" + encodeURIComponent(selecHistoria))
      .then((response) => response.json())
      .then((data) => {
        formuEditStory.replaceChildren();

        if (data.selectStoryData.Titulo != null) {
          let selectCap = `
          <div class="mb-3">
              <label for="tituloEdit" class="form-label"><h4>Título: </h4></label>
              <input type="text" class="form-control" id="tituloEdit" name="tituloEdit" value="${data.selectStoryData.Titulo}" required>
            </div>
            <div class="mb-3">
              <label for="sinopsisEdit" class="form-label"><h4>Sinopsis: </h4></label>
              <textarea class="form-control" id="sinopsisEdit" name="sinopsis" rows="3" required>${data.selectStoryData.Sinopsis}</textarea>
            </div>
            <div class="mb-3">
              <label for="portadaEdit" class="form-label"><h4>Cambiar o Añadir(si no tiene) Portada: </h4></label>
              <input type="file" id="portadaEdit" name="portadaEdit" class="form-control">`;

          if (data.selectStoryData.Imagen != null) {
            selectCap += `<img src="data:image/jpeg;base64,${data.selectStoryData.Imagen}" alt="Portada de la historia" class="img-thumbnail" style="max-width: 200px;">`;
          }

          selectCap += `</div>`;

          if (data.selectStoryCaps.length != 0) {
            selectCap += `
            <div class="mb-3">
              <select id='capStory' name='capStory' class="form-select">
                <option value=''>Seleccione un capítulo</option>`;

            data.selectStoryCaps.forEach((cap) => {
              selectCap += `<option value="${cap.IdCapitulo}">${cap.NumCapitulo} - '${cap.TituloCap}'</option>`;
            });

            selectCap += `</select></div>
              <div class="d-flex justify-content-center gap-2">
                <div>
                  <button id="btnEditCap" class="btn btnCHistoria" type="button">Editar Capítulo</button>
                </div>
                <div>
                  <button id="btnAddCap" class="btn btnCHistoria" type="button">Añadir Capítulo</button>
                </div>
                <div>
                  <button id="btnDeleteCap" class="btn btnCHistoria" type="button">Eliminar Capítulo</button>
                </div>
              </div>
              <div id="formuCapitulo"></div>`;

            formuEditStory.insertAdjacentHTML("beforeend", selectCap);
          }

          formuEditStory.insertAdjacentHTML(
            "beforeend",
            ` <div class="mb-3"></div>
              <div class="text-center">
                <button id="btnEditStory" class="btn btnCHistoria" type="button">Editar Historia</button>
              </div>`
          );
          document
            .getElementById("btnEditCap")
            .addEventListener("click", () => editStoryCap(generos, estados));
        } else {
          formuEditStory.textContent =
            "No se encontraron datos de esa historia.";
        }
      })
      .catch((error) =>
        console.error("Error al seleccionar historias:", error)
      );
  } else {
    formuEditStory.textContent = "Tienes que seleccionar alguna Historia.";
  }
}

function editStoryCap(generos, estados) {
  const capStory = document.getElementById("capStory").value;
  const formuEditCap = document.getElementById("formuCapitulo");

  if (capStory != "") {
    fetch("./views/puente.php?selecCapitulo=" + encodeURIComponent(capStory))
      .then((response) => response.json())
      .then((data) => {
        formuEditCap.replaceChildren();

        console.log(data);

        if (data.selecCapData.TituloCap != null) {
          formuEditCap.insertAdjacentHTML(
            "beforeend",
            `<div class="mb-3">
              <label for="tituloCapEdit" class="form-label"><h4>Título Capítulo: </h4></label>
              <input type="text" class="form-control" id="tituloCapEdit" name="tituloCapEdit" value="${data.selecCapData.TituloCap}" required>
            </div>
            <div class="mb-3">
              <label for="historia" class="form-label"><h4>Historia:</h4></label>
              <textarea class="form-control" name="historia" id="historia" rows="10" required>${data.selecCapData.Historia}</textarea>
            </div>`
          );

          let selectCap = `
            <div class="row mb-3">
              <div class="form-floating col-12 col-md-6 mb-3 mb-md-0">
                <select class="form-select" name='estadoEdit' id="estadoEdit" aria-label="Etiqueta flotante de estado">`;

          for (const status of estados) {
            if (status["IdEstado"] != data.selecCapData.EstadoId) {
              selectCap += `<option value="${status["IdEstado"]}">${status["Nombre"]}</option>`;
            } else {
              selectCap += `<option value="${status["IdEstado"]}" selected>${status["Nombre"]}</option>`;
            }
          }

          selectCap += `</select>
                <label for="estadoEdit"><h5>Editar el estado</h5></label>
              </div>
              <div class="form-floating col-12 col-md-6">
                <select name='generoEdit[]' id="generoSelectEdit" class="form-select genSelect" multiple aria-label="Etiqueta flotante de género" size="5">`;

          for (const gen of generos) {
            selectCap += `<option value="${gen["IdGenero"]}">${gen["Nombre"]}</option>`;
          }

          selectCap += `</select>
                <label for="floatingSelect"><h5>Editar los géneros</h5></label>
              </div>
            </div>`;

          formuEditCap.insertAdjacentHTML("beforeend", selectCap);
        } else {
          formuEditCap.textContent = "No se encontraron datos de ese capítulo.";
        }
      })
      .catch((error) =>
        console.error("Error al seleccionar capítulos:", error)
      );
  } else {
    formuEditCap.textContent = "Tienes que seleccionar algún Capítulo.";
  }
}

function showCreateHistoria(generos, estados, autorStory) {
  showFormHeadCreateStory(generos, estados, autorStory);
}


  const form = document.querySelector('form');
  if (form) {
      form.addEventListener('submit', function(event) {
          // Obtener los valores de los campos
          const nameUser = document.getElementById('nameUser').value.trim();
          const clave = document.getElementById('clave').value.trim();

          // Validar nombre de usuario
          if (nameUser === '') {
              alert('El nombre de usuario es requerido.');
              event.preventDefault(); // Evitar el envío del formulario
              return;
          }

          // Validar contraseña
          if (clave === '') {
              alert('La contraseña es requerida.');
              event.preventDefault(); // Evitar el envío del formulario
              return;
          }

          // Puedes agregar más validaciones aquí si es necesario
      });
  }