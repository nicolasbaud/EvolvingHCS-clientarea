@if(Session::has('success'))
    <div class="alert alert-success text-white font-weight-bold">
        {{ Session::get('success') }}
        @php
            Session::forget('success');
        @endphp
    </div>
@endif
@if(Session::has('warning'))
    <div class="alert alert-warning text-white font-weight-bold">
        {{ Session::get('warning') }}
        @php
            Session::forget('warning');
        @endphp
    </div>
@endif
@if(Session::has('danger'))
    <div class="alert alert-danger text-white font-weight-bold">
        {{ Session::get('danger') }}
        @php
            Session::forget('danger');
        @endphp
    </div>
@endif
@if(Session::has('info'))
    <div class="alert alert-info text-white font-weight-bold">
        {{ Session::get('info') }}
        @php
            Session::forget('info');
        @endphp
    </div>
@endif
@if(Session::has('primary'))
    <div class="alert alert-primary text-white font-weight-bold">
        {{ Session::get('primary') }}
        @php
            Session::forget('primary');
        @endphp
    </div>
@endif
@if (is_null(Auth::user()->email_verified_at))
    <div class="alert alert-danger text-white">
        <a class="text-white" href="{{ route('verification.notice') }}">Votre compte n'est pas confirmé, confirmez votre compte en cliquant-ici</a>
    </div>
@endif