@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Importar Excel</div>

                <br>
                <p>En esta sección usted podra importar archivos de excel a la base de datos,
                    debe tener en cuenta las siguientes recomendaciones:
                    <br>
                    1. Todos los campos son requeridos y no pueden estar vacios.
                    <br>
                    2. En caso de que algún campo haga falta no se realizara la importación y debera
                       revisar el archivo.
                    <br>
                    3. El sistema le informará que campo hace falta en el caso de que se presente algún error.     
                </p>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (isset($errors) && $errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif

                    @if (session()->has('failures'))
                        <table class="table table-danger">
                            <tr>
                                <th>Fila</th>
                                <th>Atributo</th>
                                <th>Error</th>
                                <th>Valor</th>
                            </tr>
                            @foreach (session()->get('failures') as $validation)
                                <tr>
                                    <td>{{ $validation->row() }}</td>
                                    <td>{{ $validation->attribute() }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($validation->errors() as $e)
                                                <li>{{ $e }}</li> 
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        {{ $validation->values()[$validation->attribute()] }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>  
                    @endif

                    <form action="import" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-gruop">
                            <input type="file" name="file"/>
                            <hr>
                            <button type="submit" class="btn btn-primary">Importar</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
