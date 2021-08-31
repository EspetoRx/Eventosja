<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Eventos;

class EventosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $eventos = Eventos::with(['convidados'])->get();
        return response(json_encode($eventos), 200);
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
            'data_evento' => 'required|date|unique:eventos,data_evento',
            'descricao' => 'required|string|min:3'
        ], [
            'data_evento.required' => 'A data do evento é obrigatória.',
            'date' => 'A data do evento deve ser uma data',
            'unique' => 'Já existe um evento nesta data. Escolha outra data...',
            'descricao.required' => 'O campo descri&ccedil;ão é obrigatório.',
            'descricao.min' => 'O campo descrição deve possuir no mínimo :min caracteres.'
        ]);

        $evento = Eventos::create([
            'data_evento' => $request->data_evento,
            'descricao' => $request->descricao
        ]);

        $evento = $evento->with(['convidados']);

        return response(json_encode($evento), 200);
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
        $evento = Eventos::with(['convidados'])->findOrFail($id);
        return response(json_encode($evento), 200);
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
        $evento = Eventos::with(['convidados'])->findOrFail($id);

        $this->validate($request, [
            'data_evento' => 'required|date|unique:eventos,data_evento,'.$id.',id',
            'descricao' => 'required|string|min:3',
        ],  [
            'data_evento.required' => 'A data do evento é obrigatória.',
            'date' => 'A data do evento deve ser uma data',
            'unique' => 'Já existe um evento nesta data. Escolha outra data...',
            'descricao.required' => 'O campo descrição é obrigatório.',
            'descricao.min' => 'O campo descrição deve possuir no mínimo :min caracteres.'
        ]);

        if(count($evento->convidados) > 0 && $request->data_evento != $evento->data_evento){
            return response(json_encode(['errors' => [
                'data_evento' => 'Não é possível alterar a data de um evento que possua convidados.'
            ]]), 500);
        }

        $evento->update([
            'data_evento' => $request->data_evento,
            'descricao' => $request->descricao
        ]);

        $evento = Eventos::with(['convidados'])->findOrFail($evento->id);

        return response(json_encode($evento), 200);
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
        $evento = Eventos::with(['convidados'])->findOrFail($id);
        if(count($evento->convidados) > 0){
            return response(json_encode(['errors' => [
                'impossivel_excluir' => 'Impossível excluir um evento com convidados.'
            ]]), 500);
        }
        $evento->delete();
        return response(json_encode('HTTP_OK'), 200);
    }
}
