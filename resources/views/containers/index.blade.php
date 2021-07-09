@extends('layouts.app')

@section('title', 'Contenedores')

@section('content')
<div class="container">
    <div class="row p-2 justify-content-center">
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#new_container">
            <i class="fas fa-plus"></i>  <b>Agregar</b>
        </button>
    </div>
    <div class="row">
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Fecha Arrivo</th>
                <th scope="col">Cantidad Productos</th>
                <th scope="col">Fecha Creación</th>
                <th scope="col">Fecha Actualización</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="data">
            @if(count($containers)>0)
                @foreach($containers as $container)
                <tr>
                    <th scope="row">{{ $container->idContainer }}</th>
                    <td>{{ $container->arrival_date }}</td>
                    <td>{{ $container->quantityProducts }}</td>
                    <td>{{ $container->creation_date }}</td>
                    <td>{{ $container->update_date }}</td>
                    <td scope="col">
                        <button class="btn btn-success ml-5 providers"
                            style="margin-bottom: 10px" data-toggle="modal"
                            data-target="#select_products" onclick="modal_products({{$container->idContainer}});">
                            <b>Agregar Productos</b>
                        </button>
                    </td>
                </tr>
                @endforeach
            @else
              <tr>
                <td colspan="11">
                  <span class="text-muted">No hay datos</span>
                </td>
              </tr>
            @endif
            </tbody>
        </table>
        {{ $containers->links() }}
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="new_container" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Agregar Nuevo Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <form>
                <div class="form-group">
                    <label for="name">Fecha de Arrivo</label>
                    <input type="date" class="form-control" id="arrival" aria-describedby="arrival_text">
                    <small id="name_text" class="form-text text-muted">Ingresa la fecha de arrivo.</small>
                </div>
                <div class="form-group">
                    <label for="name">Cantidad de productos</label>
                    <input type="number" min="0" class="form-control" id="quantity" aria-describedby="quantity_text">
                    <small id="name_text" class="form-text text-muted">Ingresa una cantidad de productos.</small>
                </div>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clean();">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="create_container();">Crear</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Providers -->
<div class="modal fade" id="select_products" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Seleccionar Productos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <form>
              <div class="row">
                <input type="text" id="container_input" value="" hidden>
                @foreach($products as $product)
                  <div class="col-lg-4">
                    <div class="form-check">
                      <input class="check_products" type="checkbox" name="products" value="{{ $product->idProduct }}" id="{{ $product->idProduct }}">
                      <label class="form-check-label" for="defaultCheck1">
                        {{ $product->name }}
                      </label>
                    </div>
                  </div>
                @endforeach
              </div>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clean();">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="assign_products();">Asignar</button>
      </div>
    </div>
  </div>
</div>


@endsection

@section('js_script')
<script type="text/javascript">
    const clean = () => {
        document.getElementById("arrival").value = "";
        document.getElementById("quantity").value = "";
    };

    const create_container = () => {
        let date = document.getElementById("arrival").value;
        let quantity_products = document.getElementById("quantity").value;

        fetch("{{ route('container.store') }}", {
            headers:{
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            method: 'POST',
            body: JSON.stringify({
                arrival_date: date,
                quantity_products: quantity_products,
            })
        }).then((response) => {
                return response.json();
        }).then((data) => {
            if(data.response){
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 1500
                })
                location.reload();
            }else{
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 1500
                })
                clean();
            }
        }).catch(error => {
            console.log(error)
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Comuniquese con el administrador',
                showConfirmButton: false,
                timer: 1500
            })
            clean();
        });
    };

    const modal_products = (id) => {
        document.getElementById('container_input').value = id;
    };

    const assign_products = () => {
      let products = document.querySelectorAll(".check_products:checked");
      let container = document.getElementById("container_input").value;
      let selected_products = [];
      let formData = new FormData();
      products.forEach((element) => {
          selected_products.push({ id: element.value });
      });
      formData.append("products", JSON.stringify(selected_products));
      formData.append("container", container);

      fetch("{{ route('container.products.store') }}", {
          headers:{
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          method: 'POST',
          body: formData
      }).then((response) => {
              return response.json();
      }).then((data) => {
          if(data.response){
              Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
              })
              location.reload();
          }else{
              Swal.fire({
                  position: 'top-end',
                  icon: 'error',
                  title: data.message,
                  showConfirmButton: false,
                  timer: 1500
              })
              clean();
          }
      }).catch(error => {
          console.log(error)
          Swal.fire({
              position: 'top-end',
              icon: 'error',
              title: 'Comuniquese con el administrador',
              showConfirmButton: false,
              timer: 1500
          })
          clean();
      });
    };
</script>
@endsection