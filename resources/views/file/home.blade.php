@extends('layout.app')

@section('container')

@include('file.alert')

{{-- @if($errors->has())
   @foreach ($errors->all() as $error)
      <div>{{ $error }}</div>
  @endforeach
@endif --}}

<div class="row">
    <div class="col-lg-12">
    	{{-- Panel --}}
        <div class="panel panel-default">
        	{{-- Panel heading --}}
            <div class="panel-heading">
            	<div class="row">
            		<div class="col-md-10">
                        {{-- List of paths --}}
                        <ul class="breadcrumb">
                        <li><a class="btn btn-primary btn-path" href="{{ route('files') }}">Principal</a></li>
                        @foreach($paths as $currentPath)
                        
                            <li>
                                <form action="{{ route('open_directorie') }}" method="get">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="path" value="{{ $currentPath["pathName"] }}">
                                    <button class="btn btn-primary btn-path" type="submit">{{ $currentPath["name"] }}</button>
                                </form>
                            </li>
                        
                        @endforeach
                        </ul>
            		</div>
                    <div class="col-md-2" >
                    {{-- For store directory --}}
                    <form action="{{ route('store_directorie') }}" method="post" class="form-inline pull-right">
                        {{ csrf_field() }}
                        <input type="hidden" name="path" value="{{ $path }}">
                        <button class="btn btn-primary btn-path" type="button" data-toggle="modal" data-target="#modalDirectory" title="Crear directorio">
                            <span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span> 
                        </button>
                        @include('modals.modal_create_directory')
                    </form>
                    {{-- For upload a new file --}}
                    <form action="{{ route('upload_file') }}" class="form-inline pull-right" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="path" value="{{ $path }}">
                        <button class="btn btn-primary btn-path" type="button" data-toggle="modal" data-target="#modalFile" title="Subir archivo">
                            <span class="glyphicon glyphicon-open-file" aria-hidden="true"></span> 
                        </button>
                        @include('modals.modal_upload_file')
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
                            <th>Usuario</th>
                            <th>Fecha</th>
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
                                {{ $directorie["name"] }}
                            </td>
                            <td>
                                {{ $directorie["user"] }}
                            </td>
                            <td>
                                {{ $directorie["filemtime"] }}
                            </td>
                            <td>
                            <form action="{{ route('open_directorie') }}" method="get">
                                {{ csrf_field() }}
                                <input type="hidden" name="path" value="{{ $path . DIRECTORY_SEPARATOR . $directorie["name"] }}">
                                <button type="submit" class="btn btn-default btn-small ">
                                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                </button>
                            </form>
                            </td>
                            @if(Auth::user()->name == $directorie["user"])
                            <td>
                            <form action="{{ route('delete_filemanager') }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="type" value="directory">
                                <input type="hidden" name="name" value="{{ $directorie["name"] }}">
                                <input type="hidden" name="path" value="{{ $path }}">
                                <button type="submit" class="btn btn-default btn-small ">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </button> 
                            </form>
                            </td>
                            @else 
                            <td>
                                <button type="submit" class="btn btn-default btn-small" disabled="true">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </button> 
                                </td>
                            @endif
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