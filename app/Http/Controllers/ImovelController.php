<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Imovel;
use Illuminate\Support\Facades\DB;
use Validator;

class ImovelController extends Controller
{
    protected function validarImovel($request)
    {
        $validator = Validator::make($request->all(), [
            "descricao" => "required",
            "logradouroEndereco"=> "required",
            "bairroEndereco" => "required",
            "numeroEndereco" => "required | numeric",
            "cepEndereco" => "required",
            "cidadeEndereco" => "required",
            "preco" => "required | numeric",
            "qtdQuartos" => "required | numeric ",
            "tipo" => "required",
            "finalidade" => "required"
        ]);
        return $validator;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buscar = $request['buscar'];
        $tipo = $request['tipo'];

        if($buscar)
        {
            $imoveis = DB::table('imoveis')->where('cidadeEndereco', '=', $buscar)->paginate(15);
        }
        elseif($tipo)
        {
            $imoveis = DB::table('imoveis')->where('tipo', '=', $tipo)->paginate(15);
        }
        else
        {
            $imoveis = DB::table('imoveis')->paginate(15);
        }

        return view('imoveis.index', compact('imoveis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('imoveis.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validarImovel($request);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }
        
        \App\Imovel::create($request->all());
        return redirect()->route('imoveis.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $imovel = \App\Imovel::find($id);

        return view('imoveis.show', compact('imovel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $imovel = \App\Imovel::find($id);

        return view('imoveis.edit', compact('imovel'));
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
        $validator = $this->validarImovel($request);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }

        $imovel = \App\Imovel::find($id);
        $dados = $request->all();
        $imovel->update($dados);

        return redirect()->route('imoveis.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove($id)
    {
        $imovel =\App\Imovel::find($id);
        $imovel->delete();

        return redirect()->route('imoveis.index');
    }
}
