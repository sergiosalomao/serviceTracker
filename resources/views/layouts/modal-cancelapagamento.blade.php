    <script>
        function setaDadosModalCancelaPagamento(valor) {
            console.log(valor)
            $("#cancelapagamento-modal").attr("onclick", valor);
        }
    </script>

    <!-- Modal -->
    <div class="modal modal-md fade-sm" id="cancelapagamento-modal" tabindex="-1" aria-labelledby="cancelapagamento-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelapagamento-modal">Confirmação</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body titulo">
                    Deseja realmente cancelar o  pagamento?
                </div>
                <div class="modal-footer">
                    <button onclick="" id="cancelapagamento-modal" class="btn btn-sm btn-danger"
                        type="button">Cancelar Pagamento</button>
                    <button class="btn btn-sm btn-success form-button-back" data-dismiss="modal"
                        type="button">Fechar</button>
                </div>
            </div>
        </div>
    </div>