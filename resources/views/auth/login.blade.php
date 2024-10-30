@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">Autenticação</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="cpf" class="col-sm-4 col-form-label text-sm-end">CPF</label>

                                <div class="col-sm-6">
                                    <input id="cpf" type="text"
                                        class="form-control @error('cpf') is-invalid @enderror" name="cpf"
                                        value="{{ old('cpf') }}" required autocomplete="cpf" autofocus>
                                </div>
                            </div>

                            <div class="row ">
                                <label for="password" class="col-sm-4 col-form-label text-sm-end">SENHA</label>

                                <div class="col-sm-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-sm-6 mb-4">
                              
                                </div>
                                <div class="col-sm-6 " style="text-align: right">
                                    <button type="submit" class="btn btn-success">
                                        Entrar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
