<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Fotos;
use App\Models\Marcas;
use App\Models\Produtos;
use Illuminate\Http\Request;

class FotosController extends Controller
{
    public function index()
    {
        $dados = Fotos::orderBy('id', 'desc')->paginate(env('APP_PAGINATE'));
        return view('fotos.index')->with(compact('dados'));
    }

    public function create()
    {
        $dados = Fotos::all();
        $produtos = Produtos::all();
        return view('fotos.create')->with(compact('dados', 'produtos'));
    }

    public function fotos(Request $request)
    {
        $dados = Fotos::where('produto_id','=',$request->id)->paginate(env('APP_PAGINATE'));
       
        return view('fotos.fotos')->with(compact('dados'));
    }

    public function addfoto(Request $request)
    {
        $dados = Fotos::where('produto_id','=',$request->id)->paginate(env('APP_PAGINATE'));
        $produto = Produtos::find($request->id);
        return view('fotos.addfoto')->with(compact('dados','produto'));
    }


    public function fotosstore(Fotos $fotos, Request $request)
    {
        /*    $request->validate([
            'image' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);
 */
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();
            // Public Folder
            $request->image->move(public_path('images') . '/produtos/fotos/', $imageName);
            $fotos->path = env('APP_LINK_IMAGES') . 'produtos/fotos/' . $imageName;
        }

        $fotos->descricao = $request['descricao'];
        $fotos->produto_id = $request['produto_id'];
      
        $fotos->save();
        $dados = Fotos::where('produto_id','=',$request['produto_id'])->paginate(env('APP_PAGINATE'));
        return redirect()->route('fotos.fotos',['id' => $request->produto_id])->with(compact('dados'))->with('message-success', 'Dados Salvos!');
    }



    public function edit(Fotos $fotos, Request $request)
    {

        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $dados = Fotos::find($request->id);

        $produtos = Produtos::all();
        return view('fotos.edit')->with(compact('dados', 'produtos',));
    }

    public function update(Fotos $fotos, Request $request)
    {
        $data = collect([]);
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();

            // Public Folder
            $request->image->move(public_path('images') . 'produtos/fotos/', $imageName);

            $data = $data->merge([
                "path"       =>  env('APP_LINK_IMAGES') . 'produtos/fotos/' . $imageName
            ]);
        }


        $data = $data->merge([
            "descricao"          => trim($request->descricao),
            "produto_id"          => trim($request->produto_id),
        ]);



        Fotos::find($request->id)->update($data->all());
        $dados = Fotos::get();
        return redirect()->route('fotos.index')->with(compact('dados'))->with('message-success', 'Dados atualizados!');
    }

    public function store(Fotos $fotos, Request $request)
    {
        /*    $request->validate([
            'image' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);
 */
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();
            // Public Folder
            $request->image->move(public_path('images') . '/fotos/', $imageName);
            $fotos->path = env('APP_LINK_IMAGES') . '/fotos/' . $imageName;
        }

        $fotos->descricao = $request['descricao'];
        $fotos->produto_id = $request['produto_id'];
      
        $fotos->save();
        $dados = Fotos::get();
        return redirect()->route('fotos.index')->with(compact('dados'))->with('message-success', 'Dados Salvos!');;;
    }

    

    public function destroy(Request $request)
    {
        $foto = Fotos::find($request->id);
      
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $fotos = Fotos::find($request->id)->delete();
       
        $dados = Fotos::get();
        return redirect()->route('fotos.fotos',['id' => $foto->produto_id])->with(compact('dados'))->with('message-success', 'Foto Excluida!');
    }


    public function pesquisa(Request $request)
    {
        $query = Fotos::query();
        $query = ($request->pesquisa != null) ? $query->where('descricao', 'LIKE', '%' . $request->pesquisa . '%') : $query;
        $query = $query->orderBy('updated_at', 'desc');
        $dados = $query->paginate(env('APP_PAGINATE'));
        return view('fotos.index', ['dados' => $dados]);
    }
}
