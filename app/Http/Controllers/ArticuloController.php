<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;



class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articulos = Articulo::all();
        return view('articulos.index', compact('articulos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Articulo $articulo)
    {
        return view('articulos.show', compact('articulo'));
    }


    public function buscar(Request $request)
    {
        $query = $request->input('query');

        $articulos = Articulo::where('nombre', 'LIKE', "%{$query}%")->get();

        return view('articulos.index', compact('articulos'));
    }

    public function busquedaAvanzada(Request $request)
    {
        $categoria = $request->input('categoria');
        $precio_min = $request->input('precio_min');
        $precio_max = $request->input('precio_max');

        $query = Articulo::query();

        if ($categoria) {
            $query->where('categoria', $categoria);
        }

        if ($precio_min) {
            $query->where('precio', '>=', $precio_min);
        }

        if ($precio_max) {
            $query->where('precio', '<=', $precio_max);
        }

        $articulos = $query->get();

        return view('articulos.index', compact('articulos'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Articulo $articulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Articulo $articulo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Articulo $articulo)
    {
        //
    }
}
