@if ($errors->any())
    <div class="alert alert-danger">
        Une erreur s'est produite:
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif