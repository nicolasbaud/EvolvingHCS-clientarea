<div class="col-12 hide" id="reply">
  <div class="card">
    <form method="POST" action="{{ route('ticket.update', ['id' => $ticket->ticketid]) }}">
      @method('PATCH')
      @csrf
      <div class="card-body">
        <h5>Réponse</h5>
        <textarea style="width: 100%;height: 200px;" name="content" class="@error('content') is-invalid @enderror form-control" placeholder="Votre message..."></textarea>
        <br />
        <div class="justify-content-end d-flex">
          <button class="btn btn-danger" id="closeButton" type="button">Fermer</button>
          &nbsp;
            <button class="btn btn-primary" type="submit">Valider et envoyer</button>
        </div>
      </div>
    </form>
  </div>
</div>
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
$("#replyButton").on("click", function(){
  $("#reply").slideDown(1500);
  $("#replyButton").addClass('hide');
})
$("#closeButton").on("click", function(){
  $("#reply").slideToggle(1500);
  setTimeout(function(){
    $("#replyButton").removeClass('hide')
  }, 1500)
})
</script>
@endsection
<style type="text/css">
  .hide {
    display: none;
  }
</style>