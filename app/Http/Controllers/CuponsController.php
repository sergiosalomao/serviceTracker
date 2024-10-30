<?php

namespace App\Http\Controllers;

use App\Models\Cupons;
use Exception;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class CuponsController extends Controller
{
    public function index(Request $request)
    {
       $cupons = Cupons::where('campanha_id',$request->id)->with(['campanha','cliente'])->paginate(env('APP_PAGINATE'));
       return view('cupons.index', ['dados' => $cupons]);
    }

    public function create()
    {
        $cupons  = Cupons::all();
        return view('cupons.create', ['dados' => $cupons]);
    }

    public function edit(Cupons $cupons, Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $cupons = Cupons::find($request->id);
        return view('cupons.edit', ['dados' => $cupons]);
    }

    public function update(Cupons $cupons, Request $request)
    {
        try {
            $data = collect([]);
            $data = $data->merge([
                "cliente_id"          => $request->cliente_id,
                "campanha_id"          => $request->campanha_id,
                "status"          => $request->status,
                "desconto"          => $request->desconto,
            ]);
            Cupons::find($request->id)->update($data->all());
            $cupons = Cupons::paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            $cupons = Cupons::find($request->id);
            return view('cupons.edit', ['dados' => $cupons])->with('message', ['tipo' => 'error', 'texto' => 'Erro ao Editar']);
        }
        return view('cupons.index', ['dados' => $cupons])->with('message', ['tipo' => 'success', 'texto' => 'Registro alterado com sucesso!']);;
    }

    public function store(Cupons $cupons, Request $request)
    {
        try {
            $cupons->titulo = uniqid();
            $cupons->cliente_id = $request['cliente_id'];
            $cupons->campanha_id = $request['campanha_id'];
            $cupons->desconto = $request['desconto'];
            $cupons->status = 'ATIVO';
            $cupons->save();
            $cupons = Cupons::paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            dd($e);
            return view('cupons.create')->with('message', ['tipo' => 'error', 'texto' => 'Erro ao gravar']);
        }
        return view('cupons.index', ['dados' => $cupons])->with('message', ['tipo' => 'success', 'texto' => 'Registro salvo com sucesso!']);;
    }

    public function destroy(Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);

        try {
            $cupons = Cupons::find($request->id)->delete();
            $cupons = Cupons::paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            report($e);
            $cupons = Cupons::paginate(env('APP_PAGINATE'));
            return view('cupons.index', ['dados' => $cupons])->with('message', ['tipo' => 'error', 'texto' => 'Este registro tem relacionamento']);;
        }
        return view('cupons.index', ['dados' => $cupons])->with('message', ['tipo' => 'success', 'texto' => 'Registro excluído com sucesso!']);;
    }

    public function atualizaStatus(Cupons $cupons, Request $request)
    {
        try {
            $selecionado = Cupons::find($request->id);
            $status = ($selecionado->status == 'INATIVO') ? "ATIVO" : "INATIVO";
            $data = collect([]);
            $data = $data->merge([
                "status"          => $status,
            ]);
            Cupons::find($request->id)->update($data->all());
            $campanhas = Cupons::paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            $cupons = Cupons::find($request->id);
            return view('cupons.edit', ['dados' => $cupons])->with('message', ['tipo' => 'error', 'texto' => 'Erro ao Editar']);
        }
        return view('cupons.index', ['dados' => $cupons])->with('message', ['tipo' => 'success', 'texto' => 'Registro alterado com sucesso!']);;
    }

    public function geraQrcode(Request $request){
        $qrcode = QrCode::size(400)->generate($request->id);
        return view('cupons.qrcode',compact('qrcode'));
    }
}
