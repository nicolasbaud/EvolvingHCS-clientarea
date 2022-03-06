<div class="col-12" id="reply">
  <div class="card">
    <form method="POST" action="{{ route('admin.ticket.reply', ['id' => $ticket->ticketid]) }}">
      @method('POST')
      @csrf
      <div class="card-body">
        <h5>Réponse</h5>
        <textarea style="width: 100%;height: 150px;" name="content" class="@error('content') is-invalid @enderror form-control" placeholder="Votre message..."></textarea>
        <br />
        <div class="justify-content-end d-flex">
          <button class="btn btn-primary" type="submit">Valider et envoyer</button>
        </div>
      </div>
    </form>
  </div>
</div>