<!-- Modal Logo -->
<div class="modal fade" id="modallogo" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Logo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('logos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="form-group has-feedback {{ $errors->has('logos') ? 'has-error' : '' }}">
                    <label class="col-md-12 text-center">Versão 1</label>
                    <div class="col-md-12 text-center">
                        @if(auth()->user()->path_logo_one != '') 
                          <img src="{{ route('welcome') }}/storage/{{ auth()->user()->path_logo_one }}" width="100%">
                        @else 
                          <img src="{{ route('welcome') }}/storage/images/logos/default.png">
                        @endif
                    </div>
                    @if(Auth::user()->type_user == 0)
                      <div class="col-md-12 text-center mt-3">
                          <input type="file" name="logo_one" placeholder="Imagens">
                          @if ($errors->has('images'))
                          <span class="help-block">
                              <strong>{{ $errors->first('images') }}</strong>
                          </span>
                          @endif
                      </div>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('logos') ? 'has-error' : '' }}">
                    <label class="col-md-12 text-center">Versão 2</label>
                    <div class="col-md-12 text-center">
                        @if(auth()->user()->path_logo_two != '') 
                          <img src="{{ route('welcome') }}/storage/{{ auth()->user()->path_logo_two }}" width="100%">
                        @else 
                          <img src="{{ route('welcome') }}/storage/images/logos/default.png">
                        @endif
                    </div>
                    @if(Auth::user()->type_user == 0)
                      <div class="col-md-12 text-center mt-3">
                          <input type="file" name="logo_two" placeholder="Imagens">
                          @if ($errors->has('images'))
                          <span class="help-block">
                              <strong>{{ $errors->first('images') }}</strong>
                          </span>
                          @endif
                      </div>
                    @endif
                </div>
        </div>
      <div class="modal-footer">
        @if(Auth::user()->type_user == 0)
          <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar</button>
        @endif
        </form>
      </div>
    </div>
  </div>
</div>