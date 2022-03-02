
  @forelse($replies as $reply)
    @if (is_null($reply->adminid))
    <div class="col-12 d-flex justify-content-end mt-4">
      <div class="col-lg-9">
        <div class="card">
          <div class="card-body">
            <p class="card-title">
              <i class="fa fa-user"></i>&nbsp;
              <b>{{ Auth::user()->firstname." ".Auth::user()->lastname }}</b>
              <br />
              <small>Client</small>
            </p>
            <hr>
            {!! nl2br(htmlspecialchars($reply->content)) !!}
          </div>
        </div>
      </div>
    </div>
    @else
    <div class="col-12 d-flex justify-content-left mt-4">
      <div class="col-lg-9">
        <div class="card">
          <div class="card-body">
            <p class="card-title">
              <i class="fa fa-user"></i>&nbsp;
              <b>{{ Auth::user()->firstname." ".Auth::user()->lastname }}</b>
              <br />
              <small>Administrateur</small>
            </p>
            <hr>
            {{{ nl2br($reply->content) }}}
          </div>
        </div>
      </div>
    </div>
    @endif
  @empty
  <div class="col-8">
    <div class="alert alert-danger text-white font-weight-bold">
      Aucune réponse 😕
    </div>
  </div>
  @endforelse