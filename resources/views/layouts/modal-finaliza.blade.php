    <script>
          function setaDadosModalFinaliza(valor) {
              console.log(valor)
              $("#finaliza").attr("onclick", valor);
          }
      </script>

      <!-- Modal -->
      <div class="modal modal-md fade-sm" id="finaliza-modal" tabindex="-1" aria-labelledby="finaliza-modal" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="finaliza-modal">Confirmação</h5>
                      <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body titulo">
                      Deseja realmente finalizar esta solicitação?
                  </div>
                  <div class="modal-footer">
                      <button onclick="" id="finaliza" class="btn btn-sm btn-danger"
                          type="button">Finalizar</button>
                      <button class="btn btn-sm btn-primary form-button-back" data-dismiss="modal"
                          type="button">Fechar</button>
                  </div>
              </div>
          </div>
      </div>
