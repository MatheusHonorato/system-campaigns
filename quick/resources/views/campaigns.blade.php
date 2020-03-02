@extends('layouts.app')

@section('content')

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

                                <form action="{{ route('posts.index') }}" method="GET">
                
                                    <input type="hidden" name="id" value="{{ $campaign->id }}">
                                  
                                    <button type="submit" class="btn btn-primary">Editar</button>
                                </form>
                            </td>
                            <td>
                                <form class="delete-c" action="{{ route('campaigns.destroy', $campaign->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $campaigns->links() }}
            </div>
        </main>
    

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
            <form action="{{ route('campaigns.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label>Nome</label>
                    <input type="text" class="form-control" name="name" placeholder="Nome" maxlength="50" required>
                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('logo') ? 'has-error' : '' }}">
                    <label>Logo</label>
                    <select class="form-control" name="logo" required>
                        <option value="0">Original</option>
                        <option value="1">Transparente</option>
                    </select>
                    @if ($errors->has('logo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('logo') }}</strong>
                    </span>
                    @endif
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('color') ? 'has-error' : '' }}">
                        <label>Cor dos dados técnicos</label>
                        <input type="color" class="form-control" name="color" placeholder="Cor" maxlength="50" required>
                        @if ($errors->has('color'))
                        <span class="help-block">
                            <strong>{{ $errors->first('color') }}</strong>
                        </span>
                        @endif
                    </div>
                <div class="form-group has-feedback {{ $errors->has('image') ? 'has-error' : '' }}">
                    <label class="col-md-12 pl-0">Imagem</label>
                    <input type="file" name="images[]" placeholder="Imagens" multiple required> 
                    @if ($errors->has('images'))
                        <span class="help-block">
                            <strong>{{ $errors->first('images') }}</strong>
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
