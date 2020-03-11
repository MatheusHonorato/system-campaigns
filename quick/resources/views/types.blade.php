@extends('layouts.app')

@section('content')

@include('nav')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div class="col-md-12">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                    <h1 class="h2">Campanhas - tipo</h1>
                    @if(Auth::user()->type_user == 0)
                        <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modal"><i class="fa fa-plus-circle" aria-hidden="true"></i> Novo</button>
                    @endif
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col" class="text-center">Acessar</th>
                            @if(Auth::user()->type_user == 0)
                                <th scope="col" class="text-center">Excluir</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($types as $type)
                        <tr>
                            <td id="type_name_{{ $type->id }}">{{ $type->name }}</td>
                            <td class="text-center">           
                                <a href="{{ route('categories.show', $type->id) }}" class="btn btn-primary"><i class="fa fa-sign-in" aria-hidden="true"></i> Acessar</a>
                            </td>
                            @if(Auth::user()->type_user == 0)
                            <td class="text-center">
                                <form class="delete-c" action="{{ route('types.destroy', $type->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-minus-circle" aria-hidden="true"></i> Excluir</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $types->links() }}
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
            <form action="{{ route('types.store') }}" method="POST" enctype="multipart/form-data">
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
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar</button>
            </form>
        </div>
    </div>
  </div>
</div>
@endsection
