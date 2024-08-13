<?php

namespace App\Http\Controllers;

use App\Models\empresas;
use Illuminate\Http\Request;

class EmpresasController extends Controller
{
    private $empresas;

    public function __construct(empresas $empresas)
    {
        $this->empresas = $empresas;
    }

    public function create(Request $request) 
    {
        try {
            $query = $this->empresas->create([
                'razaoSocial' => $request->get('razaoSocial'),
                'cnpj' => $request->get('cnpj'),
                'nomeInscrito' => $request->get('nomeInscrito'),
                'telefone' => $request->get('telefone'),
                'email' => $request->get('email'),
            ]);

            return response()->json([
                'error' => false,
                'mensagem' => 'Empresa cadastrada com sucesso',
                'query' => $query
            ]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getEmpresas(Request $request)
    {
        $query = $this->empresas->with('empresa')
                ->when($request->get('page'), function ($query) use ($request) {
                    if ($request->get('page') < 0) {
                        return $query->get();
                    }

                    return $query->where('mes', '=', 'Disponivel')->paginate(7);
                }, function ($query) {
                    return $query->where('status', '=', 'Disponivel')->get();
                });

            return response()->json($query);
    }
}
