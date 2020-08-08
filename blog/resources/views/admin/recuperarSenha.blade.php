@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
    </div>
@endif
<div class="card">
    <div class="card-header">Recuperar Senha</div>
    <div class="card-body">
        <form method="post" action="{{ url('/recuperarSenha') }}">
        {{ csrf_field() }}
        <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" />
        </div>
        <div class="form-group">
        <input type="submit" name="enviar" class="btn btn-primary" value="Enviar Link de Recuperação" />
        </div>
        </form>
    </div>
    </div>
</div>
</div>
</div>
</div>
@endsection
