@extends('layouts.app')
@section('styles')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js" integrity="sha512-/1nVu72YEESEbcmhE/EvjH/RxTg62EKvYWLG3NdeZibTCuEtW5M4z3aypcvsoZw03FAopi94y04GhuqRU9p+CQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('botones')
<a href="{{ route('recetas.index')}}" class="btn btn-outline-primary mr-2 text-uppercase font-weight-bold">
    <svg class="icono" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
    Volver </a>
@endsection
@section('content')

<h2 class="text-center mb-5"> Editar receta: {{$receta->titulo}}</h2>

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <form method="POST"action="{{route('recetas.update',['receta'=>$receta->id])}}" 
        enctype="multipart/form-data" novalidate>
            @csrf
            @method('put')
            <div class="form-group">
                <label for="titulo"> Titulo Receta </label>
                <input type="text"
                name="titulo"
                class="form-control @error('titulo') is-invalid @enderror"      
                id="titulo"
                placeholder="Titulo receta"
                value="{{$receta->titulo}}"
                >
                @error('titulo')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="categoria"> Categoria </label>
                <select 
                    name="categoria"
                    class="form-control @error('categoria') is-invalid @enderror"
                    id="categoria"
                >
                    <option value="">--Seleccione--</option>
                    @foreach($categorias as $categoria)
                        <option 
                        value="{{$categoria->id}}" 
                         {{$receta->categoria_id==$categoria->id ? 'selected':''}}
                         >{{$categoria->nombre}}
                        </option>
                    @endforeach
                </select>
                @error('categoria')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="preparacion">Preparacion</label>
                <input id="preparacion" type="hidden" name="preparacion"
                value="{{$receta->preparacion}}">
                <trix-editor
                class="form-control @error('preparacion') is-invalid @enderror" 
                input="preparacion">
                </trix-editor>
                @error('preparacion')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="ingredientes">Ingredientes</label>
                <input id="ingredientes" type="hidden" name="ingredientes"
                value="{{$receta->ingredientes}}">
                <trix-editor
                class="form-control @error('ingredientes') is-invalid @enderror"
                input="ingredientes"></trix-editor>
                @error('ingredientes')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="imagen">Elige la imagen</label>
                <input
                id="imagen"
                type="file"
                class="form-control @error('imagen') is-invalid @enderror"
                class="form-control"
                name="imagen">
                <div class="mt-4">
                    <p>Imagen Actual:</p>
                    <img src="/storage/{{$receta->imagen}}" style="width: 300px">
                </div>
                @error('imagen')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Editar Receta">
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix-core.min.js" integrity="sha512-lyT4F0/BxdpY5Rn1EcTA/4OTTGjvJT9SxWGxC1boH9p8TI6MzNexLxEuIe+K/pYoMMcLZTSICA/d3y0ColgiKg==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
@endsection
