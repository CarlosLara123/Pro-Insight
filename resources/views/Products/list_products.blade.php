@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row p-2 justify-content-center">
        <button type="button" class="btn btn-danger" style="margin-bottom: 10px" data-toggle="modal" data-target="#new_product">
          <i class="fas fa-plus"></i>  <b>Agregar</b>
        </button>
        <button type="button" class="btn btn-success ml-5" style="margin-bottom: 10px" onclick="modal_update();" >
          <i class="fas fa-pencil-alt"></i>  <b>Editar</b>
        </button>
        <div class="form-group ml-5">
            <input type="text" class="form-control" id="search" placeholder="Busca un producto">
        </div>
    </div>
    <div class="row">
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre Proveedor</th>
                <th scope="col">Fecha Creación</th>
                <th scope="col">Fecha Actualización</th>
                <th scope="col">Nombre Proveedor</th>
                <th scope="col">Fecha Creación</th>
                <th scope="col">Fecha Actualización</th>
                <th scope="col">Nombre Proveedor</th>
                <th scope="col">Fecha Creación</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="data">
            @if(count($products)>0)
              @foreach($products as $product)
                <tr>
                    <th scope="row">{{ $product->id_product }}</th>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->presentation }}</td>
                    <td>{{ $product->valume }}</td>
                    <td>{{ $product->unit }}</td>
                    <td><img src="{{ env('CLOUFINARY_BUCKET_URL').$product->photo }}" width="150" alt="imagen producto"></td>
                    <td>{{ $product->creation_date }}</td>
                    <td>{{ $product->update_date }}</td>
                    <th><input type="checkbox" class="chek_product" value="{{ $product->id_product }}"></th>
                </tr>
              @endforeach
            @else
            <tr>
              <td colspan="10">
                <span class="text-muted">No hay datos</span>
              </td>
            </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="new_product" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Agregar Nuevo Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <form>
              <div class="row">
                <div class="form-group col-lg-8">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name" aria-describedby="name_text">
                    <small id="name_text" class="form-text text-muted">Ingresa el nombre del producto.</small>
                </div>
                <div class="form-group col-lg-4">
                    <label for="name">SKU</label>
                    <input type="text" class="form-control" id="sku" aria-describedby="sku_text">
                    <small id="sku_text" class="form-text text-muted">Ingresa el codigo SKU.</small>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-lg-6">
                    <label for="name">Presentación</label>
                    <input type="text" class="form-control" id="presentation" aria-describedby="presentation_text">
                    <small id="presentation_text" class="form-text text-muted">Ingresa el tipo de presentación.</small>
                </div>
                <div class="form-group col-lg-3">
                    <label for="name">Volumen</label>
                    <input type="text" class="form-control" id="volume" aria-describedby="volume_text">
                    <small id="volume_text" class="form-text text-muted">Ingresa el volumen.</small>
                </div>
                <div class="form-group col-lg-3">
                    <label for="name">Unidad/caja</label>
                    <input type="text" class="form-control" id="unit" aria-describedby="unit_text">
                    <small id="unit_text" class="form-text text-muted">Ingresa las U/C.</small>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-lg-6">
                  <label for="providers">Selecciona un proveedor</label>
                  <select class="selectpicker">
                    @foreach($providers as $key => $provider)
                      <option value="{{ $provider->id_provider }}">{{ $provider->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-lg-6">
                  <label for="image_product">Imagen Producto</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="image_product" aria-describedby="image_product_01" accept=".jpg,.jpeg,.png">
                      <label class="custom-file-label" for="image_product">Choose file</label>
                    </div>
                  </div>
                </div>
              </div>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clean();">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="create_product();">Crear</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Update -->
<div class="modal fade" id="update_product" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Actaulizar Nuevo Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <form>
              <div class="row">
                <div class="form-group col-lg-8">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name_update" aria-describedby="name_text">
                    <small id="name_text" class="form-text text-muted">Ingresa el nombre del producto.</small>
                </div>
                <div class="form-group col-lg-4">
                    <label for="name">SKU</label>
                    <input type="text" class="form-control" id="sku_update" aria-describedby="sku_text">
                    <small id="sku_text" class="form-text text-muted">Ingresa el codigo SKU.</small>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-lg-6">
                    <label for="name">Presentación</label>
                    <input type="text" class="form-control" id="presentation_update" aria-describedby="presentation_text">
                    <small id="presentation_text" class="form-text text-muted">Ingresa el tipo de presentación.</small>
                </div>
                <div class="form-group col-lg-3">
                    <label for="name">Volumen</label>
                    <input type="text" class="form-control" id="volume_update" aria-describedby="volume_text">
                    <small id="volume_text" class="form-text text-muted">Ingresa el volumen.</small>
                </div>
                <div class="form-group col-lg-3">
                    <label for="name">Unidad/caja</label>
                    <input type="text" class="form-control" id="unit_update" aria-describedby="unit_text">
                    <small id="unit_text" class="form-text text-muted">Ingresa las U/C.</small>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-lg-6">
                  <label for="providers">Selecciona un proveedor</label>
                  <select class="selectpicker">
                    @foreach($providers as $key => $provider)
                      <option value="{{ $provider->id_provider }}">{{ $provider->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-lg-6">
                  <label for="image_product">Imagen Producto</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="image_product_update" aria-describedby="image_product_01" accept=".jpg,.jpeg,.png">
                      <label class="custom-file-label" for="image_product_update">Choose file</label>
                    </div>
                  </div>
                </div>
              </div>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clean();">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="update_product();">Actualizar</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js_script')
<script type="text/javascript">
  const clean = () =>{
    document.getElementById("name").value = "";
    document.getElementById("sku").value = "";
    document.getElementById("presentation").value = "";
    document.getElementById("volume").value = "";
    document.getElementById("unit").value = "";
    document.getElementById("image_product").value = "";
  };

  const modal_update = () => {
    console.log(document.querySelector(".check_product:checked"))
  };

  const create_product = () => {
    let formData = new FormData();
    formData.append("name", document.getElementById("name").value);
    formData.append("sku", document.getElementById("sku").value);
    formData.append("presentation", document.getElementById("presentation").value);
    formData.append("volume", document.getElementById("volume").value);
    formData.append("unit", document.getElementById("unit").value);
    formData.append("photo", document.getElementById("image_product").files[0]);

    fetch("{{ route('product.store') }}", {
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