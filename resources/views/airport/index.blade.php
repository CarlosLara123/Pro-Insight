@extends('layouts.app')
@section('title', 'Aeropuertos')

@section('content')
<div class="container">
    <div class="row p-2 justify-content-center">
        <button type="button" class="btn btn-danger" style="margin-bottom: 10px" data-toggle="modal" data-target="#new_airport">
          <i class="fas fa-plus"></i>  <b>Agregar</b>
        </button>
    </div>
    <div class="row">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Ubicación</th>
                    <th scope="col">Maritmo</th>
                    <th scope="col">Fecha Creación</th>
                    <th scope="col">Fecha Actualización</th>
                </tr>
            </thead>
            <tbody id="data">
            @if(count($airports)>0)
              @foreach($airports as $airport)
                <tr>
                    <th scope="row">{{ $airport->idAirport }}</th>
                    <td>{{ $airport->name }}</td>
                    <td>{{ $airport->ubication }}</td>
                    <td>{{ $airport->maritime }}</td>
                    <td>{{ $airport->creation_date }}</td>
                    <td>{{ $airport->update_date }}</td>
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
<div class="modal fade" id="new_airport" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name" aria-describedby="arrival_text">
                    <small id="name_text" class="form-text text-muted">Ingresa el nombre del aeropuerto.</small>
                </div>
                <div class="form-group">
                    <label for="name">Ubicación</label>
                    <input type="text" class="form-control" id="ubication" aria-describedby="quantity_text">
                    <small id="name_text" class="form-text text-muted">Ingresa la ubicación.</small>
                </div>
                <div class="form-group">
                <label for="name">Perto Maritimo:</label>
                    <div class="form-check">
                        <input class="form-check-input maritime" type="radio" name="maritime" id="si" value="Si">
                        <label class="form-check-label" for="exampleRadios1">
                            Sí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input maritime" type="radio" name="maritime" id="no" value="No">
                        <label class="form-check-label" for="exampleRadios1">
                            No
                        </label>
                    </div>
                </div>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clean();">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="create_airport();">Crear</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js_script')
<script>
    const create_airport = () => {
    let formData = new FormData();
    formData.append("name", document.getElementById("name").value);
    formData.append("ubication", document.getElementById("ubication").value);
    formData.append("maritime", document.querySelector(".maritime:checked").value);

    fetch("{{ route('airport.store') }}", {
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