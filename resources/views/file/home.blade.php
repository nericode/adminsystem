@extends('layout.app')

@section('container')


<div class="row">
    <div class="col-lg-12">
    	{{-- Panel --}}
        <div class="panel panel-default">
        	{{-- Panel heading --}}
            <div class="panel-heading">
            	<div class="row">
            		<div class="col-md-7">
            			<h3><b>Ficheros</b></h3>
                        @if(substr($path, 37) == "")
                        <b>Principal</b>
                        @else
                        @foreach($paths as $mpath)
                        <form class="form-inline" action="{{ route('open_directorie') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="path" value="{{ $mpath }}">
                            <button type="submit">{{ substr($mpath, 37) }}</button>
                        </form>
                        @endforeach
                        @endif
            		</div>
                    <div class="col-md-5">
                    {{-- For store directory --}}
                    <form action="{{ route('store_directorie') }}" method="post" class="form-inline">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name">Directorio: </label>
                            <input class="form-control" type="text" name="name" placeholder="Nombre del directorio" required>
                        </div>

                        <input type="hidden" name="path" value="{{ $path }}">
                        <button class="btn btn-primary" type="submit" >
                            <span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span> 
                        </button>
                    </form><br>
                    {{-- For upload a new file --}}
                    <form action="{{ route('upload_file') }}" class="form-inline" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <label for="name">Fichero: </label>
                        <input type="hidden" name="path" value="{{ $path }}">
                        <input class="form-control" type="file" name="file" required="required">
                        <button class="btn btn-primary" type="submit" >
                            <span class="glyphicon glyphicon-open-file" aria-hidden="true"></span> 
                        </button>
                    </form>
                    </div>

            	</div>
            </div>
            <div class="row">
            {{-- End panel heading --}}
            <div class="col-md-6" style="border-right: 1px solid #ddd; height: 100%;">
            {{-- Panel body --}}
        	{{-- Table --}}
                <table width="100%" class="table table-striped table-hover">
                	{{-- Table head --}}
                    <thead>
                        <tr>
                            <th>Directorio</th>
                            <th>Ver</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>

                    {{-- Table body --}}
                    <tbody>
                        @foreach($directories as $directorie)
                    	<tr>
                            
                            <td>
                            <span style="padding: 10px;" class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                            {{ $directorie }}
                            </td>
                            <td>
                            <form action="{{ route('open_directorie') }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="path" value="{{ $path . DIRECTORY_SEPARATOR . $directorie }}">
                                <button type="submit" class="btn btn-default btn-small ">
                                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                </button>
                            </form>
                            </td>
                            <td>
                            <form action="{{ route('delete_filemanager') }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="type" value="directory">
                                <input type="hidden" name="name" value="{{ $directorie }}">
                                <input type="hidden" name="path" value="{{ $path }}">
                                <button type="submit" class="btn btn-default btn-small ">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </button> 
                            </form>
                            </td>
                    	</tr>
                        @endforeach
                    </tbody>
                    {{-- End table body --}}
                </table>
            </div>
            {{-- End panel body --}}
            <div class="col-md-6">
                {{-- Table --}}
                <table width="100%" class="table table-striped table-hover">
                    {{-- Table head --}}
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descargar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>

                    {{-- Table body --}}
                    <tbody>
                        @foreach($files as $file)
                        <tr>
                            <td>
                            <span style="padding: 10px;" class="glyphicon glyphicon-duplicate" aria-hidden="true"></span>
                            {{ $file }}
                            </td>
                            <td>
                            <form action="{{ route('download_file') }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="path" value="{{ $path . DIRECTORY_SEPARATOR . $file }}">
                                <button type="submit" class="btn btn-default btn-small ">
                                    <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
                                </button> 
                            </form>
                            </td>
                            <td>
                            <form action="{{ route('delete_filemanager') }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="type" value="file">
                                <input type="hidden" name="name" value="{{ $file }}">
                                <input type="hidden" name="path" value="{{ $path }}">
                                <button type="submit" class="btn btn-default btn-small ">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </button> 
                            </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    {{-- End table body --}}
                </table>
            </div>
        </div>
    </div>
</div>

@endsection