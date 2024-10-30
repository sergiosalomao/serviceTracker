<?php

namespace App\Http\Controllers;

use App\Models\Campanhas;
use App\Models\Clientes;
use App\Models\Cupons;
use App\Models\Lavagens;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Exists;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CampanhaController extends Controller
{

    public function index()
    {
        $campanhas = Campanhas::with(['cupom'])->orderBy('id', 'desc')->paginate(env('APP_PAGINATE'));
        return view('campanhas.index', ['dados' => $campanhas]);
    }

    public function create()
    {
        $campanhas  = Campanhas::all();
        return view('campanhas.create', ['dados' => $campanhas]);
    }

    public function edit(Campanhas $campanhas, Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $campanhas = Campanhas::find($request->id);
        return view('campanhas.edit', ['dados' => $campanhas]);
    }

    public function links(Campanhas $campanhas, Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $campanhas = Campanhas::find($request->id);
        $dominio = env('APP_URL');
        $path = env('APP_LINK_FOTO_CAMPANHA');
        $arquivo = $campanhas->foto_path;
        $link = $this->encurtador($dominio . $path . $arquivo);
        //  dd($dominio.$path.$arquivo);
        //  $link = $dominio.$path.$arquivo;
        return view('campanhas.links', ['link' => $link]);
    }

    public function update(Campanhas $campanhas, Request $request)
    {
        try {
            $data = collect([]);


            if ($request->image) {
                $imageName = time() . '.' . $request->image->extension();
                // Public Folder
                $request->image->move(public_path('fotoscampanha'), $imageName);
            }

            $data = $data->merge([
                "titulo"          => $request->titulo,
                "descricao"          => $request->descricao,
                "foto_path"          => $imageName,
            ]);

            Campanhas::find($request->id)->update($data->all());
            $campanhas = Campanhas::orderBy('id', 'desc')->paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {

            $campanhas = Campanhas::find($request->id);
            return redirect()->back()->with(['dados' => $campanhas]);
        }

        return redirect()->back()->with(['dados' => $campanhas]);
    }

    public function store(Campanhas $campanhas, Request $request)
    {

        if ($request['gera_cupom'] == 'NAO') {
        }
        try {
            /*    $request->validate([
            'image' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);
 */
            if ($request->image) {
                $imageName = time() . '.' . $request->image->extension();
                // Public Folder
                $request->image->move(public_path('fotoscampanha'), $imageName);
                $campanhas->foto_path =  $imageName;
            }


            $campanhas->titulo = $request['titulo'];
            $campanhas->desconto = $request['desconto'];
            $campanhas->descricao = $request['descricao'];
            $campanhas->limite = $request['limite'];
            $campanhas->qtd_cupons = $request['qtd_cupons'];

            if ($request['gera_cupom'] == 'NAO') {

                $campanhas->qtd_cupons = 0;
                $campanhas->desconto = 0;
            }

            $campanhas->gera_cupom = $request['gera_cupom'];
            $campanhas->status = 'ATIVO';
            $campanhas->save();
            $this->geraCupons($campanhas);
            $campanhas = Campanhas::orderBy('id', 'desc')->paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {

            return redirect()->back()->with(['dados' => $campanhas]);
        }

        return redirect()->route('campanhas.index')->with(['dados' => $campanhas]);
    }

    public function destroy(Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);

        try {
            $campanhas = Campanhas::find($request->id)->delete();
            $campanhas = Campanhas::orderBy('id', 'desc')->paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {

            session()->flash('message-warning', 'Occorreu um Erro');
            $campanhas = Campanhas::orderBy('id', 'desc')->paginate(env('APP_PAGINATE'));
            return redirect()->back()->with(['dados' => $campanhas]);
        }
        return redirect()->back()->with('campanhas.index', ['dados' => $campanhas]);
    }

    public function atualizaStatus(Campanhas $campanhas, Request $request)
    {
        try {
            $selecionado = Campanhas::find($request->id);
            $status = ($selecionado->status == 'INATIVO') ? "ATIVO" : "INATIVO";
            $data = collect([]);
            $data = $data->merge([
                "status" => $status,
            ]);
            Campanhas::find($request->id)->update($data->all());
            $campanhas = Campanhas::orderBy('id', 'desc')->paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            $campanhas = Campanhas::find($request->id);
            return redirect()->back()->with(['dados' => $campanhas]);
        }
        return redirect()->back()->with(['dados' => $campanhas]);
    }

    public function geraCupons($dados)
    {

        if ($dados->gera_cupom == 'SIM') {
            try {

                for ($i = 1; $i <= $dados->qtd_cupons; $i++) {
                    $cupons = new Cupons();
                    $cupons->codigo = uniqid();
                    $cupons->campanha_id = $dados->id;
                    $cupons->desconto = $dados->desconto;
                    $cupons->limite = $dados->limite;
                    $cupons->status = 'DISPONIVEL';
                    $cupons->save();
                }
            } catch (Exception $e) {
                session()->flash('message-warning', 'Occorreu um Erro');
            }
        }
    }

    public function encurtador($link)
    {
        $data = [
            'url' => $link,
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.encurtador.dev/encurtamentos",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                // Set here requred headers
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: application/json",
            ),
        ));
        $response = curl_exec($curl);
        $linkEncurtado = trim($response, '{}"');
        $linkEncurtado = substr($linkEncurtado, 15, 14);
        return $linkEncurtado;
        // $err = curl_error($curl);
        curl_close($curl);
        /*  if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        print_r(json_decode($response));
    } */
    }

    public function enviaCupom(Request $request)
    {

        $campanhas = Campanhas::find($request->id);

        $clientes = Clientes::find($request->cliente);

        $cupom = Cupons::where('campanha_id', $request->id)->Where('status', 'DISPONIVEL')->WhereDate('limite', '>=', date(now()))->get();
        if (!isset($cupom[0]) && $campanhas->gera_cupom == 'SIM')
            return view('layouts.close', ['dados' => Campanhas::with(['cupom'])->paginate(env('APP_PAGINATE'))])->with('message', ['tipo' => 'error', 'texto' => 'Essa Campanha não tem mais cupons Disponiveis ou expirou']);;

        if ($campanhas->gera_cupom == 'SIM') {
            $codigo = $cupom[0]->codigo;
            $qrcode = QrCode::size(200)->generate($codigo);
            $html = view('cupons.link', ['campanhas' => $campanhas, 'clientes' => $clientes, 'qrcode' => $qrcode, 'cupom' => $codigo])->render();
            $dominio = env('APP_URL');
            $path = env('APP_LINK_CUPOM');
            $filename = $codigo . '.html';
            $link = "$dominio$path$filename";
            $linkEncurtado = $this->encurtador($link);
            //copia o arquivo com numero do codigo
            file_put_contents('public/cupom/' . $codigo . '.html', $html);

            //quando for testar  //  file_put_contents('cupom/' . $codigo . '.html', $html);
            $url = "https://api.whatsapp.com/send?phone='.$clientes->telefone .'&text=Olá, $clientes->nome, $campanhas->descricao $linkEncurtado";
            //atualiza o status do cupom como entregue
            try {
                $data = collect([]);
                $data = $data->merge([
                    "status"          => 'ENTREGUE',
                    "cliente_id" => $clientes->id
                ]);
                Cupons::findOrFail($cupom[0]->id)->update($data->all());
            } catch (Exception $e) {
                session()->flash('message-warning', 'Occorreu um Erro');
            }
            return redirect()->to($url);
        }

        if ($campanhas->gera_cupom == 'NAO') {
            //quando for testar  //  file_put_contents('cupom/' . $codigo . '.html', $html);
            $url = "https://api.whatsapp.com/send?phone='.$clientes->telefone .'&text=Olá, $clientes->nome, $campanhas->descricao ";


            return redirect()->to($url);
        }
    }


    public function envios()
    {
        $clientes = Clientes::orderBy('updated_at', 'asc')->paginate(env('APP_PAGINATE'));
        $campanhas = Campanhas::with(['cupom'])->where('campanhas.status', 'ATIVO')->get();

        return view('campanhas.envios', ['dados' => $clientes, 'campanhas' => $campanhas]);
    }


    public function pesquisaenvios(Request $request)
    {
        $clientes = Clientes::where('nome', 'LIKE', '%' . $request->pesquisa . '%')
            ->orWhere('telefone', 'LIKE', '%' . $request->pesquisa . '%')

            ->orderBy('updated_at')
            ->paginate(env('APP_PAGINATE'));
        $campanhas = Campanhas::with(['cupom'])->where('campanhas.status', 'ATIVO')->get();
        return view('campanhas.envios', ['dados' => $clientes, 'campanhas' => $campanhas]);
    }
}
