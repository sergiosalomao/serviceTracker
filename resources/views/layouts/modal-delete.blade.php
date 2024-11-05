<!-- Modal de Confirmação -->
<div class="modal fade" id="confirm-modal" tabindex="-1" aria-labelledby="confirm-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirm-modal-label">Confirmação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Você tem certeza de que deseja continuar com esta ação?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirm-delete" onclick="">Apagar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Script para Setar a Ação do Botão -->
<script>
    function setaDadosModal(action) {
       console.log(action);
        document.getElementById('confirm-delete').setAttribute('onclick', action);
        var myModal = new bootstrap.Modal(document.getElementById('confirm-modal'));
        myModal.show();
    }
</script>
