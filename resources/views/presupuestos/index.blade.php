@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Presupuestos</h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 
                Presupuestos
            </a></li>
            <li class="active">Presupuestos</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header">
                <div class="pull-left">
                    <h3 class="box-title">Listado de Presupuestos</h3>
                </div>
                <div class="pull-right">
                    <a href="{{ route('presupuestos.create') }}" class="btn btn-primary">Agregar Presupuesto</a>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Año Fiscal</th>
                            <th>Código</th>
                            <th>Puerto</th>
                            <th>Descripción</th>
                            <th>Costo</th>
                            <th>Responsable</th>
                            <th>Estado</th>
                            <th colspan="3" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presupuestos as $item)    
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->anho_fiscal }}</td>
                            <td>{{ $item->codigo }}</td>
                            <td>{{ $item->puerto->nombre }}</td>
                            <td>{{ $item->descripcion }}</td>
                            <td>{{ number_format($item->costo,0,',','.') }}</td>
                            <td>{{ $item->responsable->nombre.' '.$item->responsable->apellido }}</td>
                            <td>{{ $item->estado->nombre }}</td>
                            <td class="text-center"><a href="{{ route('presupuestos.proyectos.index', $item->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i> Proyectos</a></td>
                            <td class="text-center"><a href="{{ route('presupuestos.edit', $item->id) }}" class="btn btn-warning"><i class="fa fa-pencil"></i> Editar</a></td>
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
    let text = "Está seguro que desea eliminar el presupuesto?";
    if (confirm(text) == true) {
        try {
            let requestBody = { _token: '{{ csrf_token() }}' }
            fetch("/presupuestos/"+id, 
                { method: "DELETE", headers: new Headers( {"Content-Type": "application/json"} ),
                body: JSON.stringify( requestBody )
            })
            .then((response) => response.json())
            .then((data) => {
                if(data.status == "success"){
                    location.href = "{{ route('presupuestos.index') }}";
                }else if(data.status == "error"){
                    alert(data.message);
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