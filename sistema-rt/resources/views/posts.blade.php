@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clinics.index') }}">
                            <span data-feather="home"></span>
                            Clínicas <span class="sr-only"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('campaigns.index') }}">
                            <span data-feather="bar-chart-2"></span>
                        Campanhas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('posts.index') }}">
                            <span data-feather="shopping-cart"></span>
                            Posts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="download-cart"></span>
                            Download
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div class="col-md-11">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                    <h1 class="h2">Posts</h1>
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
                        @foreach($posts as $post)
                        <tr>
                            <td id="post_name_{{ $post->id }}">{{ $post->name }}</td>
                            <td>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary ">Editar</<a>
                            </td>
                            <td>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $posts->links() }}
            </div>
        </main>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cadastro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
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
            <div class="form-group has-feedback {{ $errors->has('campaign') ? 'has-error' : '' }}">
                <label>Campanha</label>
                <select class="form-control" name="campaign" required>
                @foreach($campaigns as $campaign)
                    <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                @endforeach
                </select>
                @if ($errors->has('campaign'))
                <span class="help-block">
                    <strong>{{ $errors->first('campaign') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('color') ? 'has-error' : '' }}">
                <label>Cor dos dados técnicos</label>
                <input type="color" class="form-control" name="color" placeholder="Cor" minlength="10" maxlength="50" required>
                @if ($errors->has('color'))
                <span class="help-block">
                    <strong>{{ $errors->first('color') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('images') ? 'has-error' : '' }}">
                <label class="col-md-12 pl-0">Imagens</label>
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
@endsection
