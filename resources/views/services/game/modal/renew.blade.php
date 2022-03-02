<div class="modal fade" id="renew" tabindex="-1" role="dialog" aria-labelledby="renewLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form method="post" action="{{ route('service.game.renew', ['id' => $service->first()->serviceid]) }}">
      @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="renewLabel">Renouvellement</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          En cliquant sur "valider" une facture sera généré afin de renouveler votre service.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn bg-gradient-primary">Valider</button>
        </div>
      </form>
    </div>
  </div>
</div>