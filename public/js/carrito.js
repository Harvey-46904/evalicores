let carrito = [];
$(".carrito_count").text(0);


let cliente={
    nombre:"",
    celular:"",
    tipo_orden:"",
    medio_pago:"",
    _token:""
}
let total=0;
let envio_post={
    'precio':"",
    'informacion_cliente':"",
    'lista_productos':"",
    'tipo_orden':"",
    'medio_pago':"",
    'accion':"",
}
function agregarAlCarrito(producto) {
    console.log(producto);
    
    // Verificar si el producto ya está en el carrito
    var encontrado = carrito.find(item => item.producto_id === producto.producto_id);
    
    if (encontrado) { 
        
        // Si el producto ya está en el carrito, puedes incrementar la cantidad si es necesario

        encontrado.cantidad = producto.cantidad+encontrado.cantidad;
    } else {
        // Agregar el nuevo producto al carrito
        carrito.push({ ...producto});
    }
    
    console.log('Producto añadido al carrito:', producto);
    console.log('Carrito:', carrito);
    
    // Opcional: Actualizar la vista del carrito
    actualizar_contador_carrito();
}

function actualizar_contador_carrito(){
    $(".carrito_count").text(carrito.length);
}
function cerrar_carrito() {
    Swal.close(); // Cierra el modal
    abrir_carrito();
}
function eliminarDelCarrito(posicion) {
    if (posicion >= 0 && posicion < carrito.length) {
        carrito.splice(posicion, 1);
        console.log("Producto eliminado. Carrito actualizado:", carrito);
        actualizar_contador_carrito();
        cerrar_carrito();
    } else {
        console.log("Posición inválida");
    }
}

function generarHtmlProductos(productos) {
    console.log(productos);
    let contador=1;
    let productoslist=productos.map(producto => `
         
        <tr>
           <th scope="row">${contador++}</th>
           <td> <img src="${producto.image_url}" class="img-fluid" width="20%" height="20%"></td>
           <td> <b>${producto.producto_nombre}</b></td>
           <td>${producto.precio}</td>
           <td>${producto.cantidad}</td>
            <td>${producto.cantidad*producto.precio}</td>
             <td><button class="btn btn-danger text-light" onclick="eliminarDelCarrito(${contador-2})">
            <i class="fas fa-trash"></i>
        </button></td>
       </tr>
  
`).join('');
// Calcula el total
const subtotal = productos.reduce((acc, producto) => acc + (producto.cantidad * producto.precio), 0);
total=subtotal;
// Agrega la fila de total
productoslist += `
<tr class="fondo_naranja">
    <td colspan="5" class="text-right text-end"><strong>Total</strong></td>
    <td colspan="2">${subtotal}</td>
</tr>
`;

    return productoslist;
}
function operates(incrementar) {
    var button = document.getElementById('cant');
    var currentValue = parseInt(button.textContent, 10);
    if (incrementar) {
        button.textContent = Math.min(currentValue + 1, 9); // Máximo 9
    } else {
        button.textContent = Math.max(currentValue - 1, 1); // Mínimo 1
    }
}
function abrir_carrito(){
    Swal.fire({  
        html: `
          <h3 class="text-dark mb-lg-0 pb-2">Tu mejor opción en licores</h3>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Producto</th>
                <th scope="col">Nombre</th>
                <th scope="col">Precio unitario</th>
                <th scope="col">cantidad</th>
                <th scope="col">sub total</th>
                <th scope="col">Borrar</th>
                </tr>
            </thead>
            <tbody>
            ${generarHtmlProductos(carrito)}
             </tbody>
        <table class="table">
        `,
        showCancelButton: true,
        width: '80%', // Cambia esto según sea necesario
        padding: '1rem', // Aumenta el padding si lo deseas
        confirmButtonText: 'Finalizar Compra',
        cancelButtonText: 'Cerrar',
        customClass: {
            confirmButton: 'custom-confirm', // Aplica la clase personalizada
        }
      }).then((result) => {
        if (result.isConfirmed) {
            ventafinaL();
        } else if (result.isDismissed) {
          // Acción si se cancela

         var $button = $('#cant').text(0);
        }
      });
}

function ventafinaL(){
    Swal.close();
    Swal.fire({  
        html: `
          <h3 class="text-dark mb-lg-0 pb-2">Datos personales</h3>
        <div class="row">
            <div class="col-md-12">
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombres Completos</label>
                        <input type="text" class="form-control nombre_cliente" >
                      
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Número de celular</label>
                        <input type="number" class="form-control celular_cliente" id="exampleInputPassword1">
                        <small id="emailHelp" class="form-text text-muted">El número de celular debe tener whatsapp para la confirmación del proceso</small>
                    </div>
                    
                </form>
            </div>
        <div>
        `,
        showCancelButton: true,
        width: '80%', // Cambia esto según sea necesario
        padding: '1rem', // Aumenta el padding si lo deseas
        confirmButtonText: 'Siguiente',
        cancelButtonText: 'Cerrar',
        customClass: {
            confirmButton: 'custom-confirm', // Aplica la clase personalizada
        }
      }).then((result) => {
        if (result.isConfirmed) {
            cliente.nombre=$(".nombre_cliente").val();
            cliente.celular=$(".celular_cliente").val();
            tipo_orden_pago();
        } else if (result.isDismissed) {
          // Acción si se cancela

         var $button = $('#cant').text(0);
        }
      });
}
function tipo_orden_pago(){
    Swal.close();
    Swal.fire({  
        html: `
          <h3 class="text-dark mb-lg-0 pb-2">Tipo de orden</h3>
        <div class="row justify-content-center">
            <div class="col-md-6">
          
                <form>
                
                  <label>Entrega de la orden</label>
                    <hr>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="Recojer en el lugar" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Ir a recojer al lugar
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="Domicilio">
                        <label class="form-check-label" for="exampleRadios2">
                            Domicilio
                        </label>
                    </div>
                     <hr>
                     <label>medio de pago</label>
                    <hr>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadiosb" id="exampleRadios1" value="Efectivo" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Efectivo
                        </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadiosb" id="exampleRadios2" value="Nequi">
                            <label class="form-check-label" for="exampleRadios2">
                                Nequi
                            </label>
                        </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadiosb" id="exampleRadios2" value="Davivienda">
                            <label class="form-check-label" for="exampleRadios2">
                                Davivienda
                            </label>
                        </div>
                </form>
            </div>
        <div>
        `,
        showCancelButton: true,
        width: '80%', // Cambia esto según sea necesario
        padding: '1rem', // Aumenta el padding si lo deseas
        confirmButtonText: 'Siguiente',
        cancelButtonText: 'Cerrar',
        customClass: {
            confirmButton: 'custom-confirm', // Aplica la clase personalizada
        }
      }).then((result) => {
        if (result.isConfirmed) {
           cliente.tipo_orden= $('input[name="exampleRadios"]').val();
            cliente.medio_pago=$('input[name="exampleRadiosb"]').val();
            cliente.token= $('input[name="_token"]').val();
            
           

            envio_post = {
                lista_productos: carrito.map(item => ({
                    producto_nombre: item.producto_nombre,
                    cantidad: item.cantidad
                }))
            };
            envio_post.informacion_cliente={
                'Nombres_completos':cliente.nombre,
                'Celular':cliente.celular
            }
            envio_post.medio_pago=cliente.medio_pago;
            envio_post.tipo_orden=cliente.tipo_orden;
            envio_post._token=cliente.token;
            envio_post.precio=total;
            //console.log(envio_post);
            Swal.close();
            Swal.fire({ 
                html:`
                   <div class="fullscreen">
        <div class="text-center">
            <div class="loading-circle"></div>
            
        </div>
        
    </div>
    <p class="mt-3">Generando su orden por favor espere...</p>
                `
            }); 

            enviar_orden(envio_post);
        } else if (result.isDismissed) {
          // Acción si se cancela

         var $button = $('#cant').text(0);
        }
      });
}

function enviar_orden(cliente){
    fetch('/post', {
        method: 'POST', // Cambia a 'POST' si es necesario
        headers: {
            'Content-Type': 'application/json',
            // Agrega otros encabezados si es necesario, como Authorization
        },
        body: JSON.stringify(cliente) // Solo se permite en POST
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la red');
        }
        return response.json();
    })
    .then(data => {
       // console.log('Éxito:', data);
        window.location.href = `orden/${data.code_orden}`;
    })
    .catch(error => {
        console.error('Error:', error);
    });
}