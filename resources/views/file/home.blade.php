@extends('layout.app')

@section('container')

@include('file.alert')

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
                <div class="col-md-12">
                {{-- Table --}}
                <table width="100%" class="table table-striped table-hover">
                    {{-- Table head --}}
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Tamaño</th>
                            <th>Fecha</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>

                    {{-- Table body --}}
                    <tbody>
                        @foreach($files as $file)
                            @if($file["type"] == "directory")
                                <tr>
                                    <td>
                                        <a href="{{ route('open_directorie') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('open-directorie-{{ $file["name"] }}').submit();">
                                        <span style="padding: 10px;" class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                                        {{ $file["name"] }}
                                        </a>
                                        <form id="open-directorie-{{ $file["name"] }}" action="{{ route('open_directorie') }}" method="get">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="path" value="{{ $path . DIRECTORY_SEPARATOR . $file["name"] }}">
                                        </form>
                                    </td>
                                    <td>
                                        {{ $file["user"] }}
                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        {{ $file["filemtime"] }}
                                    </td>
                                    @if(Auth::user()->name == $file["user"])
                                    <td>
                                    <form action="{{ route('delete_filemanager') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="type" value="directory">
                                        <input type="hidden" name="name" value="{{ $file["name"] }}">
                                        <input type="hidden" name="path" value="{{ $path }}">
                                        <button type="submit" class="btn btn-default btn-small ">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                        </button>
                                    </form>
                                    </td>
                                    @else
                                    <td>
                                    </td>
                                    @endif
                                </tr>
                            @else
                                <tr>
                                    <td>
                                        <a href="{{ route('download_file') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('download-file').submit();">
                                        <span style="padding: 10px;" class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
                                        {{ $file["name"] }}
                                        </a>
                                        <form id="download-file" action="{{ route('download_file') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="path" value="{{ $path . DIRECTORY_SEPARATOR . $file["name"] }}">
                                    </form>
                                    </td>
                                    <td>
                                        {{ $file["user"] }}
                                    </td>
                                    <td>
                                        {{ $file["size"] }}
                                    </td>
                                    <td>
                                        {{ $file["filemtime"] }}
                                    </td>
                                    <td>
                                    <form action="{{ route('delete_filemanager') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="type" value="file">
                                        <input type="hidden" name="name" value="{{ $file["name"] }}">
                                        <input type="hidden" name="path" value="{{ $path }}">
                                        <button type="submit" class="btn btn-default btn-small ">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                        </button>
                                    </form>
                                    </td>
                                </tr>
                            @endif

                        @endforeach
                    </tbody>
                    {{-- End table body --}}
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
