@extends('layouts.app', ['bodyclass' => 'bg-dark', 'hidenav' => true])

@section('content')

@if(isset(Auth::user()->user_email))
    <script>window.location="/home";</script>
@endif
<div class="container">
          @if ($message = Session::get('error'))
          <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
          </div>
          @endif

          @if (count($errors) > 0)
            <div class="alert alert-danger">
            <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
          @endif
          </div>
          </div>
    <div class="container navless-container">
    <div class="content">

          
          <div class="row mb-3">
                <div class="col-sm-5 order-1 order-sm-12 new-session-forms-container">
                <div id="signin-container">
                <ul class="nav-links new-session-tabs nav-tabs nav" role="tablist">
                  <li class="nav-item" role="presentation">
                  <a class="nav-link active" data-qa-selector="sign_in_tab" data-toggle="tab" href="#login-pane" role="tab" aria-selected="true">Entrar</a>
                  </li>
                </ul>

                  <div class="tab-content">
                  <div class="login-body">
                  <form method="post" action="{{ url('/checklogin') }}">
                      {{ csrf_field() }}
                      <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control" />
                      </div>
                      <div class="form-group">
                      <label>Senha</label>
                      <input type="password" name="password" class="form-control" />
                      </div>
                      <a class="btn btn-link" href="http://localhost:8000/recuperarSenha/">Esqueceu a senha?</a>
                      <div class="form-group">
                      <input type="submit" name="login" class="btn btn-primary" value="Entrar" />
                      </div>
                  </form>
                  </div>
                  </div>

                </div>
                </div>

              </div>
          </div>
    </div>
    </div>

@endsection
