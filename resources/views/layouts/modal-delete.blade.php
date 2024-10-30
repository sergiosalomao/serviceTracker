    <script>
        function setaDadosModal(valor) {
            console.log(valor)
            $("#deleta").attr("onclick", valor);
        }
    </script>

    <!-- Modal -->
    <div class="modal modal-md " id="delete-modal" tabindex="-1" aria-labelledby="delete-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete-modal">Confirmação</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" 
                        {{-- data-bs-dismiss="modal" para bootstrap5 --}} aria-label="Close"></button>
                </div>
                <div class="modal-body titulo">
                    Deseja realmente excluir este registro?
                </div>
                <div class="modal-footer">
                    <button onclick="" id="deleta" class="btn btn-sm btn-danger" type="button">Deletar</button>
                    <button class="btn btn-sm btn-primary form-button-back" data-bs-dismiss="modal" data-dismiss="modal"
                        type="button">Fechar</button>
                </div>
            </div>
        </div>
    </div>
