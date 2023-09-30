

function openModal(articuloData, file) {
  $("#detalleModal").modal("show");
  $("#modal-image").attr("src", "fotos/" + file);
  $("#modal-codigo").text(articuloData.codigo);

  $("#form-file").val(file);
  $("#form-codigo").val(articuloData.codigo);
}

function actualizarContenidoCarrito() {
  // Obtiene y actualiza el contenido del carrito utilizando AJAX
  fetch("./php/carrito.php")
    .then((response) => response.json())
    .then((data) => {
      // Actualiza el contenido del carrito en el encabezado
      document.getElementById("cart-container").innerHTML = data.cartContent;

      // Actualiza el contador de elementos en el carrito
      document.getElementById("cart-count").textContent = data.elementosEnCarrito;

      console.log(data);
    })
    .catch((error) => {
      console.error("Error al actualizar el contenido del carrito:", error);
    });
}

function subir() {
  window.scrollTo(0, 0);

  console.log("hola");
}

function eliminarFila(index) {
  // Realizamos una solicitud AJAX para eliminar la fila en el servidor
  $.ajax({
    type: "POST",
    url: "./php/eliminar.php", // Cambia esto a la URL correcta en tu servidor
    data: {
      index: index,
    }, // Enviamos el índice de la fila a eliminar
    success: function (response) {
      // La solicitud se completó con éxito
      if (response === "OK") {
        // Eliminamos la fila del DOM
        $("#fila" + index).remove();
        actualizarContenidoCarrito();
      } else {
        // Manejar cualquier error que pueda ocurrir en el servidor
        alert("Error al eliminar la fila.");
      }
    },
    error: function () {
      // Manejar errores de conexión o solicitud
      alert("Error de conexión.");
    },
  });
}

function verificarPosicionDeDesplazamiento() {
  var currentScrollPosition = window.scrollY;

  window.scrollTo(0, scrollPosition);

  if (currentScrollPosition >= scrollPosition) {
    clearInterval(intervalo);
  }
}

document.addEventListener("DOMContentLoaded", function () {

 

  // Obtiene el valor de scrollPosition de la URL (si existe)
  var scrollPosition = parseInt(window.location.hash.substring(1));
  if (!isNaN(scrollPosition)) {
    var intervalo = setInterval(function () {
      verificarPosicionDeDesplazamiento();
    }, 500);
  }

  const boton1 = document.getElementById("reenvia");
  if (boton1) {
    boton1.addEventListener("click", function () {
      document.getElementById("formresumit").submit();
    });
  }

  const boton2 = document.getElementById("asumit");
  if (boton2) {
    boton2.addEventListener("click", function () {
      alert("Su pedido se enviara en una ventata de Wathapp");
      document.getElementById("formulario").submit();
    });
  }

  const form = document.getElementById("add_form");
  if (form) {
    form.addEventListener("submit", function (e) {
      document.querySelector("#scrollPosition").value = window.scrollY;

      e.preventDefault();
      const successModal = document.getElementById("successModal"); // The modal for "Producto Agregado" message

      const formData = new FormData(form);
      console.log(form);
      fetch("./php/add.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          if (data.success) {
            // Close the current modal (assuming you have code to hide the current modal)
            // For example, if you're using Bootstrap modal:
            $("#detalleModal").modal("hide");
            form.reset();

            successModal.querySelector(".modal-body").textContent = data.message;
            console.log(successModal);

            $(successModal).modal("show");
            actualizarContenidoCarrito();
          } else {
            successModal.querySelector(".modal-body").textContent = data.message;
            $(successModal).modal("show");
            console.error("Error:", data.message);
          }
        })
        .catch((error) => {
          $("#detalleModal").modal("hide");
          console.error("Error:", error);
        });
    });
  }
});
