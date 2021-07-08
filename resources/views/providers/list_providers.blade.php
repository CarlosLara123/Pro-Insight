@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row p-2 justify-content-center">
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#new_provider">
            <i class="fas fa-plus"></i>  <b>Agregar</b>
        </button>
    </div>
    <div class="row">
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre Proveedor</th>
                <th scope="col">Fecha Creación</th>
                <th scope="col">Fecha Actualización</th>
                </tr>
            </thead>
            <tbody id="data">
                @foreach($providers as $provider)
                <tr>
                    <th scope="row">{{ $provider->id_provider }}</th>
                    <td>{{ $provider->name }}</td>
                    <td>{{ $provider->creation_date }}</td>
                    <td>{{ $provider->update_date }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $providers->links() }}
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="new_provider" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                    <input type="text" class="form-control" id="name" aria-describedby="name_text">
                    <small id="name_text" class="form-text text-muted">Ingresa el nombre del proveedor.</small>
                </div>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clean();">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="create_provider();">Crear</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js_script')
<script type="text/javascript">
    const clean = () => {
        document.getElementById("name").value = "";
    };

    const create_provider = () => {
        let provider = document.getElementById("name").value;

        fetch("{{ route('provider.store') }}", {
            headers:{
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            method: 'POST',
            body: JSON.stringify({
                provider: provider
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
                clean();
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