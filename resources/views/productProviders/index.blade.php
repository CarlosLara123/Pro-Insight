@extends('layouts.app')

@section('title', 'Productos Precio')

@section('content')
<div class="container">
    <div class="row">
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Producto</th>
                <th scope="col">Proveedor</th>
                <th scope="col">Precio</th>
                <th scope="col">Fecha Creación</th>
                <th scope="col">Fecha Actualización</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="data">
                @if(count($productProviders)>0)
                    @foreach($productProviders as $product_provider)
                        <tr>
                            <td>{{ $product_provider->idProductProviders }}</td>
                            <td>{{ $product_provider->product->name }}</td>
                            <td>{{ $product_provider->provider->name }}</td>
                            <td>{{ "Q.".$product_provider->price }}</td>
                            <td>{{ $product_provider->creation_date }}</td>
                            <td>{{ $product_provider->update_date }}</td>
                            <td>
                                <button class="btn btn-success ml-5 providers"
                                    style="margin-bottom: 10px" data-toggle="modal"
                                    data-target="#update_price" onclick="modal_price({{$product_provider->idProductProviders}});">
                                        <b>Modificar Precio</b>
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
<div class="modal fade" id="update_price" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                    <label for="name">Precio</label>
                    <input type="number" min="0" class="form-control" id="price" aria-describedby="arrival_text">
                    <small id="name_text" class="form-text text-muted">Ingresa el precio del producto.</small>
                </div>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clean();">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="update_price();">Crear</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js_script')
<script type="text/javascript">
    const clean = () => {
        document.getElementById("id_product").value = "";
        document.getElementById("price").value = "";
    };

    const modal_price = (id) => {
        document.getElementById('id_product').value = id;
        fetch("{{ route('product.provider.getProduct') }}", {
            headers:{
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            method: 'POST',
            body: JSON.stringify({ id: id })
        }).then((response) => {
                return response.json();
        }).then((data) => {
            document.getElementById("price").value = data.price;
        }).catch(error => {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Comuniquese con el administrador',
                showConfirmButton: false,
                timer: 1500
            })
        });
    };

    const update_price = () => {
        let product = document.getElementById("id_product").value;
        let price = document.getElementById("price").value;

        fetch("{{ route('product.provider.price') }}", {
            headers:{
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            method: 'POST',
            body: JSON.stringify({
                id: product,
                price: price,
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
</script>
@endsection