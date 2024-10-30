    <script>
          function setaDadosModalCancela(valor) {
              console.log(valor)
              $("#cancela").attr("onclick", valor);
          }
      </script>

      <!-- Modal -->
      <div class="modal modal-md fade-sm" id="cancela-modal" tabindex="-1" aria-labelledby="cancela-modal" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="cancela-modal">Confirmação</h5>
                      <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body titulo">
                      Deseja realmente cancelar esta solicitação?
                  </div>
                  <div class="modal-footer">
                      <button onclick="" id="cancela" class="btn btn-sm btn-danger"
                          type="button">Cancelar</button>
                      <button class="btn btn-sm btn-primary form-button-back" data-dismiss="modal"
                          type="button">Fechar</button>
                  </div>
              </div>
          </div>
      </div>
