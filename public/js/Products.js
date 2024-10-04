function producto(key){
    if (productos[key]) {
// Obtiene los productos para la clave dada
var productosFiltrados = productos[key];

// Obtiene el contenedor donde se añadirán los productos
var container = document.getElementById('productos-container');

// Limpia el contenedor antes de agregar nuevos productos (opcional)
container.innerHTML = '';

// Recorre los productos y crea los elementos HTML
productosFiltrados.forEach(producto => {
    // Crea un nuevo div para el producto
    var productDiv = document.createElement('div');
    productDiv.className = 'col-lg-3 col-12 ';
    var objetoJson = encodeURIComponent(JSON.stringify(producto));

    
    // Crea el HTML para el producto
    productDiv.innerHTML = `
        <div class="artists-thumb py-5">
            <div class="artists-image-wrap">
                <img src="${producto.image_url}"
                    class="artists-image img-fluid">
            </div>
            <div class="artists-hover">
                <p>
                    <strong>Nombre:</strong>
                    ${producto.producto_nombre}
                </p>
                <p>
                    <strong>Precio:</strong>
                    ${producto.precio || 'No disponible'}  <!-- Asumiendo que tienes un campo precio en el producto -->
                </p>
                <hr>
                <p class="mb-0">
                    <a onclick="agregar_venta('${objetoJson}')" data-product='${objetoJson}' class="text-danger">Pedirlo Ahora</a>
                </p>
            </div>
        </div>
    `;
    
    // Añade el div del producto al contenedor
    container.appendChild(productDiv);
});
}else {
console.log('No hay productos para la clave ' + key);
}
}


function agregar_venta(objetos){
    event.preventDefault();
    var productoJsonEscapado = event.target.getAttribute('data-product');

        // Decodificar la cadena JSON
        var productoJson = decodeURIComponent(productoJsonEscapado);

        // Parsear el JSON a un objeto
        var producto = JSON.parse(productoJson);

    Swal.fire({  
        html: `
          <div class="row">
            <div class="col-md-6">
                 ${producto.producto_nombre}
                <img src="${producto.image_url}"
                    class="artists-image img-fluid">
            </div>
            <div class="col-md-6 align-self-center">
            Precio<br> <b>$</b><b id="precio">${producto.precio}</b><br>
            Cantidad
                <div class="row justify-content-center align-items-center text-center">
                    <div class="col-md-2 col-2">
                        <button type="button" class="btn btn-outline-success" id="menos" onclick="operate(false)">-</button>
                    </div>
                    <div class="col-md-2  col-2">
                      <button type="button" class="btn btn-outline-secondary "  id="cant">1</button>
                    </div>
                    <div class="col-md-2 col-2">
                        <button type="button" class="btn btn-outline-success"  id="mas"  onclick="operate(true)">+</button>
                    </div>
                    
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
            Sub total
            </div>
            <div class="col-md-6">
            <b>$</b><b id="subtotales">${producto.precio}</b>
            </div>
          </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Agregar al carrito',
        cancelButtonText: 'Cancelar',
        customClass: {
          confirmButton: 'custom-confirm', // Aplica la clase personalizada
      }
      }).then((result) => {
        if (result.isConfirmed) {
            var button = $('#cant').text()
            producto.cantidad=parseInt(button, 10);
          
          agregarAlCarrito(producto);
        } else if (result.isDismissed) {
          // Acción si se cancela

         var $button = $('#cant').text(0);
        }
      });
}

function operate(condicional){

    updateButtonValue(condicional)
}
function updateButtonValue(increment) {
    var $button = $('#cant');
    var currentValue = parseInt($button.text(), 10); // Convierte el texto a número
    var valor=parseInt($("#precio").text(), 10);
    
    if (increment) {
        // Incrementar
        if (currentValue < 9) {
          var newValue = currentValue + 1; // Incrementa el valor
          $button.text(newValue); // Actualiza el texto del botón
          var sub=newValue*valor;
          $("#subtotales").text(sub);
        }
      } else {
        // Decrementar
        if (currentValue > 1) {
          var newValue = currentValue - 1; // Decrementa el valor
          $button.text(newValue); // Actualiza el texto del botón
          var sub=newValue*valor;
          $("#subtotales").text(sub);
        }
      }
     
      
  }
$(document).ready(function() {
    // Función para obtener el valor actual del botón y actualizarlo
    

    // Evento para el botón "menos"
    $('#menos').on('click', function() {
        console.log("menos");
        
      updateButtonValue(false); // Llama a la función para decrementar
    });

    // Evento para el botón "más"
    $('#mas').on('click', function() {
      updateButtonValue(true); // Llama a la función para incrementar
    });
  });

producto(1);