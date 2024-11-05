@extends('layouts.app')

@section('content')
<div class="container-fluid" style="background-color: #002148; height: 100vh;">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-md-4 text-center mb-4">
            <img src="{{ env('APP_LINK_IMAGES') }}/logo2.png" alt="Logo" class="img-fluid" style="max-width: 100%; border-radius: 10px;">
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Autenticação</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    body {
        background-color: #002148;
        color: #ffffff;
    }
    .card {
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        background-color: #ffffff;
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }
</style>
@endsection
