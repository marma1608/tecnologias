<?php

namespace App\Http\Controllers;

use App\Receta;
use App\CategoriaReceta;
use Illuminate\Http\Request;
use Intervention\Image\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RecetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['show','search']]);
    }
    public function index()
    {
        //Auth::user()->recetas->dd();
        //$recetas = auth()->user()->recetas->paginate(2);
        $usuario=auth()->user();
        //$meGusta=auth()->user()->meGusta;
        //recetas con paginacion
        $recetas=Receta::where('user_id',$usuario->id)->paginate(2);
        //$recetas=auth()->user()->recetas;
        return view('recetas.index')
        ->with('recetas', $recetas)
        ->with('usuario', $usuario);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$categorias=DB::table('categoria_recetas')->get()->pluck('nombre','id');
        //Obtener la categoria sin modelo
        //obtener con modelo
        $categorias=CategoriaReceta::all(['id','nombre']);
        return view('recetas.create')->with('categorias',$categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request['imagen']->store('upload-recetas','public'));
        $data=request()->validate([
            'titulo'=>'required|min:6',
            'preparacion'=>'required',
            'ingredientes'=>'required',
            'imagen'=>'required|image',
            'categoria'=>'required',
        ]);
        //obtener ruta de la imagen
        $ruta_imagen=$request['imagen']->store('upload-recetas','public');
        //rezize de la imagen
        //$img=Image::make(public_path("storage/{$ruta_imagen}"))->fit(1200,500);
        //$img->save();
        //dd($request->all());
        //almacenar sin modelo
        //DB::table('recetas')->insert([
            /*'titulo'=>$data['titulo'],
            'preparacion'=>$data['preparacion'],
            'ingredientes'=>$data['ingredientes'],
            'imagen'=>$ruta_imagen,
            'user_id'=>Auth::user()->id,
            'categoria_id'=>$data['categoria']

        ]);*/
        //almacenar con el modelo
        
        //$recetas=Receta::all();
        auth()->user()->recetas()->create([
            'titulo'=>$data['titulo'],
            'preparacion'=>$data['preparacion'],
            'ingredientes'=>$data['ingredientes'],
            'imagen'=>$ruta_imagen,
            'categoria_id'=>$data['categoria']

        ]);
        //Redireccionar
        return redirect()->action('RecetaController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
        //obtener si el usuario actual le gusta la receta y esta autenticado
        $like=(auth()->user()) ? auth()->user()->meGusta->contains($receta->id) :false;
        //pasa la cantidad de likes a la vista
        $likes=$receta->likes->count();
        //algunos metodos para obtener una receta
        //$receta=Receta::findOrFail($receta);
        return view('recetas.show', compact('receta','like','likes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        $categorias=CategoriaReceta::all(['id','nombre']);
        return view('recetas.edit',compact('categorias','receta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {
        //revisar la policy
        $this->authorize('view', $receta);
        //return $receta;
        //validacion
        $data=request()->validate([
            'titulo'=>'required|min:6',
            'preparacion'=>'required',
            'ingredientes'=>'required',
            'categoria'=>'required',
        ]);
        //asignar valores
        $receta->titulo=$data['titulo'];
        $receta->preparacion=$data['preparacion'];
        $receta->ingredientes=$data['ingredientes'];
        $receta->categoria_id=$data['categoria'];
//si el usuario sube una nueva imagen
if (request('imagen')){
    //obtener la ruta de la imagen 
    $ruta_imagen=$request['imagen']->store('upload-recetas','public');
    //rezize de la imagen
        //$img=Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000,500);
        //$img->save();
        //asignar objeto
        $receta->imagen=$ruta_imagen;
}

        $receta->save();
        //redireccionar
        return redirect()->action('RecetaController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        
        //revisar la policy
        $this->authorize('delete',$receta);
        //eliminar la receta
        $receta->delete();
        return redirect()->action('RecetaController@index');
    }
    public function search(Request $request){
        //$busqueda=$request['buscar'];
        $busqueda=$request->get('buscar');
        $recetas=Receta::where('titulo','like','%' . $busqueda. '%')->paginate(10);
        $recetas->appends(['buscar'=>$busqueda]);
        return view('busquedas.show',compact('recetas','busqueda'));
    }
}
