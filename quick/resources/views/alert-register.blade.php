<!-- Modal Logo -->
<div class="modal fade" id="modalalert" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Observações</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="container">
                <div class="modal-body">
                    <form action="{{ route('alert.campaign.register') }}" method="POST">
                        @csrf
                        <input type="hidden" id="type_campaign" name="type_campaign" value="0">
                        <div class="form-group row">
                            <label class="pl-0 col-sm-2 col-form-label">Clínica</label>
                            <select class="form-control" name="clinic">
                                @foreach($clinics_option as $clinic)
                                    <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                                @endforeach
                            </select>   
                        </div>
                        <div class="form-group row">
                            <label class="pl-0 col-sm-2 col-form-label">Campanha</label>
                            <select id="select_posts" class="form-control" name="campaign">
                                @foreach($campaigns_option as $campaign)
                                    <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                                @endforeach
                            </select>   
                        </div>
                        <div class="form-group row">
                            <label class="pl-0 col-sm-2 col-form-label">Observação</label>
                            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                        </div>
  
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


