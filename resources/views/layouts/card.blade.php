<div class="mt-2 p-2 " >
    <a class="btn-imagens"
    onclick="setaDadosModal('window.location.href=\'/fotos/delete/{{ $item->id }}\'')"
    data-toggle="modal" data-target="#delete-modal"><img src="{{ $item->path }}"  alt="{{$item->descricao}}" title="{{$item->descricao}}"
            style="object-fit: cover;border:1px solid silver;" height="180px"></a>
</div>
