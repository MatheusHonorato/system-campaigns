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
                    <h1 class="h2">Posts</h1>
                    <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modal">Novo</button>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col" class="text-center">Editar</th>
                            <th scope="col" class="text-center">Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                        <tr>
                            <td id="post_name_{{ $post->id }}">{{ $post->id }}</td>
                            <td class="text-center">
                                <a href="" data-toggle="modal" data-target="#modalEdit{{ $post->id }}" class="btn btn-primary ">Editar</<a>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>

                         <!-- Modal -->
                         <div class="modal fade text-left text-dark" id="modalEdit{{ $post->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                                                    <label>Id</label>
                                                    <input type="text" class="form-control" name="id" placeholder="Id" value="{{ $post->id }}" disabled>
                                                    @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="form-group has-feedback {{ $errors->has('campaign') ? 'has-error' : '' }}">
                                                    <label>Campanha</label>
                                                    <select class="form-control" name="campaign">
                                                    @foreach($campaigns as $camp)
                                                        @foreach($campaign_post as $cp)
                                                            @if(($post->id == $cp->post_id) && ($cp->campaign_id == $camp->id))
                                                                <option value="{{ $camp->id }}" selected>{{ $camp->name }}</option>
                                                                @break
                                                            @else
                                                                <option value="{{ $camp->id }}">{{ $camp->name }}</option>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                    </select>
                                                    @if ($errors->has('campaign'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('campaign') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="form-group has-feedback {{ $errors->has('logo') ? 'has-error' : '' }}">
                                                    <label>Logo</label>
                                                    <select class="form-control" name="logo">
                                                        <option value="0" @if($post->logo == '0') selected  @endif>Original</option>
                                                        <option value="1" @if($post->logo == '1') selected  @endif>Transparente</option>
                                                    </select>
                                                    @if ($errors->has('logo'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('logo') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="form-group has-feedback {{ $errors->has('color') ? 'has-error' : '' }}">
                                                    <label>Cor dos dados técnicos</label>
                                                    <input type="color" class="form-control" name="color" placeholder="Cor" value="{{ $post->color }}" maxlength="50">
                                                    @if ($errors->has('color'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('color') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="form-group text-center has-feedback {{ $errors->has('image') ? 'has-error' : '' }}">
                                                    <label class="col-md-12 pl-0">Imagem</label>
                                                    @if($post->image != '') 
                                                        <img src="{{ route('welcome') }}/storage/{{ $post->image }}" width="200px">
                                                    @else 
                                                        <img src="{{ route('welcome') }}/storage/images/default.png">
                                                    @endif
                                                    <input type="file" name="image" placeholder="Image">
                                                    @if ($errors->has('image'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('image') }}</strong>
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
                <input type="text" class="form-control" name="name" placeholder="Nome" maxlength="50" required>
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
                <input type="color" class="form-control" name="color" placeholder="Cor" minlength="10" maxlength="50" required>
                @if ($errors->has('color'))
                <span class="help-block">
                    <strong>{{ $errors->first('color') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('image') ? 'has-error' : '' }}">
                <label class="col-md-12 pl-0">Imagem</label>
                <input type="file" name="image" placeholder="Image" required>
                @if ($errors->has('image'))
                <span class="help-block">
                    <strong>{{ $errors->first('image') }}</strong>
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
