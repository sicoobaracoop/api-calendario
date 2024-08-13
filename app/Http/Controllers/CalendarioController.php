<?php

namespace App\Http\Controllers;

use App\Models\calendario;
use App\Models\empresas;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    private $calendario, $empresa;

    public function __construct(calendario $calendario, empresas $empresa)
    {
        $this->calendario = $calendario;
        $this->empresa = $empresa;
    }

    public function create(Request $request)
    {
        $this->calendario->create([
            'tipo' => $request->get('tipo'),
            'horarios' => $request->get('horarios'),
            'mes' => $request->get('mes'),
            'data' => $request->get('data'),
            'periodo' => $request->get('periodo'),
            'status' => 'Disponivel',
        ]);

        return response()->json([], 200);
    }

    public function update(Request $request, int $id)
    {
        try {
            $empresa = $this->empresa->create([
                'razaoSocial' => $request->get('razaoSocial'),
                'cnpj' => $request->get('cnpj'),
                'nomeInscrito' => $request->get('nomeInscrito'),
                'telefone' => $request->get('telefone'),
                'email' => $request->get('email'),
            ]);

            $reserva = $this->calendario->where('id', $id);
            $reserva->update([
                'status' => 'Reservado',
                'empresaId' => $empresa->id
            ]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getReservas(Request $request)
    {
        try {
            $query = $this->calendario->with('empresa')
                ->when($request->get('tipo'), function ($query) use ($request) {
                    return $query->where('tipo', '=', $request->get('tipo'));
                })
                ->when($request->get('page'), function ($query) use ($request) {
                    if ($request->get('page') < 0) {
                        return $query->get();
                    }

                    return $query->where('status', '=', 'Disponivel')->where('mes', '=', 'Agosto')->paginate(7);
                }, function ($query) {
                    return $query->where('status', '=', 'Disponivel')->get();
                });

            return response()->json($query);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
