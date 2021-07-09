@extends('layouts.app')
@section('title', 'Productos')

@section('content')
<div class="container">
    <div class="row p-2 justify-content-center">
        <button type="button" class="btn btn-danger" style="margin-bottom: 10px" data-toggle="modal" data-target="#new_product">
          <i class="fas fa-plus"></i>  <b>Agregar</b>
        </button>
        <button type="button" id="update" class="btn btn-success ml-5" style="margin-bottom: 10px" data-toggle="modal" data-target="#update_product" onclick="modal_update();" >
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
                <th scope="col"></th>
                <th scope="col">#</th>
                <th scope="col">Nombre Produto</th>
                <th scope="col">SKU</th>
                <th scope="col">Presentaión</th>
                <th scope="col">Volumen</th>
                <th scope="col">Unidad/caja</th>
                <th scope="col">Imagen Producto</th>
                <th scope="col">Fecha Creación</th>
                <th scope="col">Fecha Actualización</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="data">
            @if(count($products)>0)
              @foreach($products as $product)
                <tr>
                    <th><input type="radio" name="product" class="radio_product" value="{{ $product->idProduct }}"></th>
                    <th scope="row">{{ $product->idProduct }}</th>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->presentation }}</td>
                    <td>{{ $product->volume }}</td>
                    <td>{{ $product->unit }}</td>
                    <td><img src="{{ env('CLOUFINARY_BUCKET_URL').$product->photo }}" width="150" alt="imagen producto"></td>
                    <td>{{ $product->creation_date }}</td>
                    <td>{{ $product->update_date }}</td>
                    <td>
                      <button x-id="{{$product->idProduct}}" class="btn btn-success ml-5 providers" style="margin-bottom: 10px" data-toggle="modal" data-target="#select_providers" onclick="modal_providers({{$product->idProduct}});" >
                        <b>Seleccionar<br>Proveedores</b>
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
                    <input type="number" min="0" class="form-control" id="unit" aria-describedby="unit_text">
                    <small id="unit_text" class="form-text text-muted">Ingresa las U/C.</small>
                </div>
              </div>
              <div class="row">
                <div class="form-group">
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
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="create_product();">Crear</button>
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
              <input type="text" id="idProduct" hidden>
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
                    <input type="number" min="0" class="form-control" id="unit_update" aria-describedby="unit_text">
                    <small id="unit_text" class="form-text text-muted">Ingresa las U/C.</small>
                </div>
              </div>
              <div class="row">
                <div class="form-group">
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
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="update_product();">Actualizar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Providers -->
<div class="modal fade" id="select_providers" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Seleccionar Proveedores</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <form>
              <div class="row">
                <input type="text" id="product_input" value="" hidden>
                @foreach($providers as $provider)
                  <div class="col-lg-4">
                    <div class="form-check">
                      <input class="check_providers" type="checkbox" name="providers" value="{{ $provider->idProvider }}" id="{{ $provider->idProvider }}">
                      <label class="form-check-label" for="defaultCheck1">
                        {{ $provider->name }}
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
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="assign_provider();">Asignar</button>
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
    document.getElementById("idProduct").value = "";
    document.getElementById("name_update").value = "";
    document.getElementById("sku_update").value = "";
    document.getElementById("presentation_update").value = "";
    document.getElementById("volume_update").value = "";
    document.getElementById("unit_update").value = "";
    let check = document.querySelectorAll(".check_providers:checked");
    check.forEach((element) => {
      element.checked = false;
    });
  };

  const modal_update = () => {
    let productID = document.querySelector(".radio_product:checked").value;
    fetch("{{ route('product.getProduct') }}", {
        headers:{
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        method: 'POST',
        body: JSON.stringify({ id: productID })
    }).then((response) => {
            return response.json();
    }).then((data) => {
      document.getElementById("idProduct").value = data.idProduct;
      document.getElementById("name_update").value = data.name;
      document.getElementById("sku_update").value = data.sku;
      document.getElementById("presentation_update").value = data.presentation;
      document.getElementById("volume_update").value = data.volume;
      document.getElementById("unit_update").value = data.unit;
    }).catch(error => {
        console.log(error)
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Comuniquese con el administrador',
            showConfirmButton: false,
            timer: 1500
        })
    });
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

  const update_product = () => {
    let formData = new FormData();
    formData.append("id", document.querySelector(".radio_product:checked").value);
    formData.append("name", document.getElementById("name_update").value);
    formData.append("sku", document.getElementById("sku_update").value);
    formData.append("presentation", document.getElementById("presentation_update").value);
    formData.append("volume", document.getElementById("volume_update").value);
    formData.append("unit", document.getElementById("unit_update").value);
    if(document.getElementById("image_product_update").files[0] !== undefined){
      formData.append("photo", document.getElementById("image_product_update").files[0]);
    }

    fetch("{{ route('product.update') }}", {
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

  const modal_providers = (id) => {
    document.getElementById('product_input').value = id;
  };

  const assign_provider = () => {
    let providers = document.querySelectorAll(".check_providers:checked");
    let product = document.getElementById("product_input").value;
    let selected_providers = [];
    let formData = new FormData();
    providers.forEach((element) => {
      selected_providers.push({ id: element.value });
    });
    formData.append("providers", JSON.stringify(selected_providers));
    formData.append("product", product);

    fetch("{{ route('product.provider.store') }}", {
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