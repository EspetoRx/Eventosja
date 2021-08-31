<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Convidados;

class ConvidadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $query = Convidados::with(['eventos'])->get();
        return response(json_encode($query), 200);
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
            'nome' => 'required|string|min:3',
            'email' => 'required|email|unique:convidados,email',
        ], [
            'email.unique' => 'Já existe um convidado com este e-mail',
        ]);

        $convidado = Convidados::create([
            'nome' => $request->nome,
            'email' => $request->email
        ]);

        $convidado = $convidado->with(['eventos']);

        return response(json_encode($convidado), 200);
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
        $convidado = Convidados::with(['eventos'])->findOrFail($id);
        return response(json_encode($convidado), 200);
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
        $convidado = Convidados::findOrFail($id);

        $this->validate($request, [
            'nome' => 'required|string|min:3',
            'email' => 'required|email|unique:convidados,email,'.$id.',id',
        ], [
            'email.unique' => 'Já existe um convidado com este e-mail',
        ]);

        $convidado->update([
            'nome' => $request->nome,
            'email' => $request->email,
        ]);

        $convidado = Convidados::with(['eventos'])->findOrFail($convidado->id);

        return response(json_encode($convidado), 200);
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
        $convidado = Convidados::findOrFail($id);
        $convidado->delete();
        return response(json_encode('HTTP_OK'), 200);
    }
}
