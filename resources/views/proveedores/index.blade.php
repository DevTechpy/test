@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Proveedores</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 
                Proveedores
            </a></li>
            <li class="active">Proveedores</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">Listado de proveedores</h3>
                </div>
                <div class="pull-right">
                    <a href="{{ route('proveedores.create') }}" class="btn btn-primary">Agregar proveedor</a>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre Fantasía</th>
                            <th>Razón Social</th>
                            <th>RUC</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th colspan="2" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proveedores as $item)    
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nombre_fantasia }}</td>
                            <td>{{ $item->razon_social }}</td>
                            <td>{{ $item->ruc }}</td>
                            <td>{{ $item->telefono }}</td>
                            <td>{{ $item->direccion }}</td>
                            <td class="text-center"><a href="{{ route('proveedores.edit', $item->id) }}" class="btn btn-warning"><i class="fa fa-pencil"></i> Editar</a></td>
                            <td class="text-center"><button onclick="eliminateHandle({{ $item->id }})" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
function eliminateHandle(id){
    let text = "Está seguro que desea eliminar el proveedor?";
    if (confirm(text) == true) {
        try {
            let requestBody = { _token: '{{ csrf_token() }}' }
            fetch("/proveedores/"+id, 
                { method: "DELETE", headers: new Headers( {"Content-Type": "application/json"} ),
                body: JSON.stringify( requestBody )
            })
            .then((response) => response.json())
            .then((data) => {
                if(data.status == "success"){
                    location.href = "{{ route('proveedores.index') }}";
                }
            });
        } catch (error) {
            alert("Advertencia: Ocurrio un error intentado resolver la solicitud, por favor complete todos los campos o recargue de vuelta la pagina");
            console.log(error);
        }
    }
}
</script>
@endpush