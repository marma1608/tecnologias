<?php

namespace App\Http\Controllers;

use App\Perfil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Receta;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except'=>'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function show(Perfil $perfil)
    {
        //obtener las recetas con paginacion
        $recetas=Receta::where('user_id',$perfil->user_id)->paginate(3);
        return view ('perfiles.show',compact('perfil','recetas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function edit(Perfil $perfil)
    {
        // ejecutar el policy
        $this->authorize('view',$perfil);

        return view('perfiles.edit', compact('perfil','recetas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perfil $perfil)
    {
        //ejecutar el policy
        $this->authorize('update', $perfil);
        //validar
        $data=request()->validate([
            'nombre'=>'required',
            'url'=>'required',
            'biografia'=>'required'
        ]);
        //si el usuario sub una imagen
        if($request['imagen']){
            //obtener la ruta de la imagen 
            $ruta_imagen=$request['imagen']->store('upload-perfiles','public');
            //rezize de la imagen
            //$img=Image::make(public_path("storage/{$ruta_imagen}"))->fit(600,600);
            //$img->save();
            //crear arreglo de imagen
            $array_imagen=['imagen'=>$ruta_imagen];
        }
        //asignar nombre y url
        auth()->user()->url=$data['url']; 
        auth()->user()->name=$data['nombre'];
        auth()->user()->save();
        //eliminar url y name de $data
        unset($data['url']);
        unset($data['nombre']);
        
        //asignar biografia e imagen 
        auth()->user()->perfil()->update(array_merge(
            $data,
            $array_imagen ?? []
        ));
        //guardar informacion redireccionar
        //redireccionar
        
        return redirect()->action('RecetaController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perfil $perfil)
    {
        //
    }
}
