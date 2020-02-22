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
                            Logo
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
                    <form method="POST" action="{{ route('posts.update', $post->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="form-group col-md-3 has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label>Nome</label>
                                <input type="text" class="form-control" name="name" value="{{ $post->name }}" placeholder="Nome" minlength="10" maxlength="50" required>
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-md-3 has-feedback {{ $errors->has('campaign') ? 'has-error' : '' }}">
                                <label>Campanha</label>
                                <select class="form-control" name="campaign" required>
                                @foreach($campaigns as $campaign)
                                    <option value="{{ $campaign->id }}" @if($campaign->id == $campaign_post->campaign_id) selected @endif>{{ $campaign->name }}</option>
                                @endforeach
                                </select>
                                @if ($errors->has('campaign'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('campaign') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-md-3 has-feedback {{ $errors->has('color') ? 'has-error' : '' }}">
                                <label>Cor dos dados técnicos</label>
                                <input type="color" class="form-control" name="color" value="{{ $post->color }}" placeholder="Cor" minlength="4" maxlength="50" required>
                                @if ($errors->has('color'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('color') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-2 pt-4">
                                <button type="submit" class="btn btn-success">Salvar</button>
                            </div>
                        </div>
                    </form>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Imagem</th>
                            <th scope="col">Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($images as $image)
                        <tr>
                            <td>
                                <img src="{{ route('welcome') }}/storage/{{ $image->path }}" class="img-thumbnail" width="100px">
                            </td>
                            <td>
                                <form action="{{ route('figures.destroy', $image->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
@endsection
