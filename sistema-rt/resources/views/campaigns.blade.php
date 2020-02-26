@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('nav')
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div class="col-md-11">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                    <h1 class="h2">Campanhas</h1>
                    <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modal">Novo</button>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Editar</th>
                            <th scope="col">Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($campaigns as $campaign)
                        <tr>
                            <td id="campaign_name_{{ $campaign->id }}">{{ $campaign->name }}</td>
                            <td>
                                <!-- Modal Edit --> 
                                <div class="modal fade" id="modalEdit{{ $campaign->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Cadastro</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('campaigns.update', $campaign->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                                                        <label>Nome</label>
                                                        <input type="text" class="form-control" name="name" placeholder="Nome" value="{{ $campaign->name }}" minlength="10" maxlength="50" required>
                                                        @if ($errors->has('name'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group has-feedback {{ $errors->has('description') ? 'has-error' : '' }}">
                                                        <label>Descrição</label>
                                                        <input type="text" class="form-control" name="description" placeholder="Descrição" value="{{ $campaign->description }}" minlength="10" maxlength="50" required>
                                                        @if ($errors->has('description'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('description') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#modalEdit{{ $campaign->id }}">Editar</button>
                            </td>
                            <td>
                                <form action="{{ route('campaigns.destroy', $campaign->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $campaigns->links() }}
            </div>
        </main>
    </div>
</div>

<!-- Modal New --> 
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Cadastro</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('campaigns.store') }}" method="POST">
                @csrf
                <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label>Nome</label>
                    <input type="text" class="form-control" name="name" placeholder="Nome" minlength="10" maxlength="50" required>
                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('description') ? 'has-error' : '' }}">
                    <label>Descrição</label>
                    <input type="text" class="form-control" name="description" placeholder="Descrição" minlength="10" maxlength="50" required>
                    @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                    @endif
                </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>
    </div>
  </div>
</div>
@include('logo')
@include('download')
@endsection
