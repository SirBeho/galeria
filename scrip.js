
  document.getElementById("openModalButton").addEventListener("click", function () {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
    
    var cartData = <?= json_encode($_SESSION['cart']); ?>;
    var cartList = document.getElementById("cartData");
    cartList.innerHTML = ""; // Limpiar la lista
    
    // Recorrer los datos del carrito y mostrarlos en la lista
    for (var i = 0; i < cartData.length; i++) {
      var item = cartData[i];
      var listItem = document.createElement("li");
      listItem.textContent = "Código: " + item.codigo + ", Cantidad: " + item.cantidad + ", Comentario: " + item.comentario;
      cartList.appendChild(listItem);
    }
  });

  document.getElementById("closeModalButton").addEventListener("click", function () {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
  });

