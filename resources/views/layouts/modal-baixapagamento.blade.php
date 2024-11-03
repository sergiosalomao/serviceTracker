    <script>
        function setaDadosModalBaixaPagamento(valor) {
            console.log(valor)
            $("#baixapagamento-modal").attr("onclick", valor);
        }
    </script>

    <!-- Modal -->
    <div class="modal modal-md fade-sm" id="baixapagamento-modal" tabindex="-1" aria-labelledby="baixapagamento-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="baixapagamento-modal">Confirmação</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body titulo">
                    Deseja realizar a baixa do pagamento?
                </div>
                <div class="modal-footer">
                    <button onclick="" id="baixapagamento-modal" class="btn btn-sm btn-success"
                        type="button">Baixar</button>
                    <button class="btn btn-sm btn-primary form-button-back" data-dismiss="modal"
                        type="button">Fechar</button>
                </div>
            </div>
        </div>
    </div>