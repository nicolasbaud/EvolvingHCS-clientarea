@extends('layouts.app')

@section('title', 'Tickets')

@section('content')
<div class="col-12 hide" id="reply">
  <div class="card">
    <form method="POST" action="{{ route('ticket.open') }}">
      @method('POST')
      @csrf
      <div class="card-body">
        <h5>Ouvrir une demande</h5>
        <div class="col-12 row">
          <div class="col-6">
            <label for="subject">Sujet</label>
            @error('subject') {{ $message }} @enderror
            <input type="text" id="subject" name="subject" class="@error('subject') is-invalid @enderror form-control" placeholder="Sujet de la demande">
          </div>
          <div class="col-6">
            <label for="department">Département</label>
            @error('department') {{ $message }} @enderror
            <select class="form-control @error('department') is-invalid @enderror " id="department" name="department">
              <option value="Technique">Technique</option>
              <option value="Commercial">Commercial</option>
              <option value="Facturation">Facturation</option>
              <option value="Autre">Non listé</option>
            </select>
          </div>
        </div>
        <label for="content">Message</label>
        <textarea style="width: 100%;height: 200px;" id="content" name="content" class="@error('content') is-invalid @enderror form-control" placeholder="Votre message..."></textarea>
        @error('content') {{ $message }} @enderror
        <br />
        <div class="justify-content-end d-flex">
          <button class="btn btn-primary" type="submit">Valider et envoyer</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection