<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\ConvidadosEventos;
use App\Models\Eventos;
use App\Models\Convidados;

class ConvidadosEventosController extends Controller
{
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'convidado' => 'present',
            'convidado.id' => 'required|integer|exists:convidados,id',
            'evento' => 'present',
            'evento.id' => 'required|integer|exists:eventos,id'
        ]);

        $query = ConvidadosEventos::where('evento_id', $request->evento['id'])
            ->where('convidado_id', $request->convidado['id'])->get();
        //echo($query);

        if(count($query) != 0){
            return response(json_encode(['errors' => [
                'Registro duplicado' => 'Este já foi convidado para o evento... Escolha outro(a) para convidar.'
            ]]), 500);
        }

        $query = ConvidadosEventos::create([
            'evento_id' => $request->evento['id'],
            'convidado_id' => $request->convidado['id']
        ]);

        $query = ConvidadosEventos::with(['convidado', 'evento'])->findOrFail($query->id);

        return response(json_encode($query), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $query = ConvidadosEventos::findOrFail($id);
        $evento = $query->evento_id;
        $convidado = $query->convidado_id;
        $query->delete();
        $evento = Eventos::with(['convidados'])->findOrFail($evento);
        $convidado = Convidados::with(['eventos'])->findOrFail($convidado);
        return response(json_encode(['evento' => $evento, 'convidado' => $convidado]), 200);
    }
}
