@extends('layouts.app')

@section('title', 'Productos Precio')

@section('content')
<div class="container">
    <div class="row p-2 justify-content-center">
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#new_order">
            <i class="fas fa-plus"></i>  <b>Agregar</b>
        </button>
    </div>
    <div class="row">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Contenedor</th>
                    <th scope="col">Aeropuerto Destino</th>
                    <th scope="col">Fecha Creación</th>
                    <th scope="col">Fecha Actualización</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="data">
              @if(count($orders)>0)
                @foreach($orders as $order)
                  <tr>
                      <td>{{ $order->idOrder }}</td>
                      <td>{{ $order->container->arrival_date }}</td>
                      <td>{{ $order->airport->name }}</td>
                      <td>{{ $order->creation_date }}</td>
                      <td>{{ $order->update_date }}</td>
                      <td>
                          <button class="btn btn-success ml-5 providers"
                              style="margin-bottom: 10px" data-toggle="modal"
                              data-target="#update_price" onclick="modal_datail({{$order->idOrder}});">
                                  <b>Detalle</b>
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
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="new_order" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
            <input id="id_product" hidden>
                <div class="form-group">
                    <label for="name">Contenedor</label>
                    <select class="form-control form-control-sm" id="container">
                      <option selected>-----------</option>
                      @foreach($containers as $contanier)
                        <option value="{{ $contanier->idContainer }}">{{ $contanier->arrival_date }}</option>
                      @endforeach
                    </select>
                    <small id="name_text" class="form-text text-muted">Selecciona un contenedor.</small>
                </div>
                <div class="form-group">
                    <label for="name">Aeropuerto</label>
                    <select class="form-control form-control-sm" id="airport">
                      <option selected>-----------</option>
                      @foreach($airports as $airport)
                        <option value="{{ $airport->idAirport }}">{{ $airport->name }}</option>
                      @endforeach
                    </select>
                    <small id="name_text" class="form-text text-muted">Selecciona un contenedor.</small>
                </div>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clean();">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="new_order();">Crear</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js_script')
<script>

  const new_order = () => {
    let select_container = document.getElementById("container");
    let container = select_container.options[select_container.selectedIndex].value;

    let select_airport = document.getElementById("airport");
    let airport = select_airport.options[select_airport.selectedIndex].value;

    fetch("{{ route('order.store') }}", {
            headers:{
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            method: 'POST',
            body: JSON.stringify({
                container: container,
                airport: airport
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
                location.reload();
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
            location.reload();
        });
  }
</script>
@endsection