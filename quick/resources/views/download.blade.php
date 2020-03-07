<!-- Modal Logo -->
<div class="modal fade" id="modaldownload" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Download</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="container">
                <div class="modal-body">
                    <form action="{{ route('download') }}" method="GET">
                        <input type="hidden" id="type_campaign" name="type_campaign" value="1">
                        <div class="form-group row">
                            <label class="pl-0 col-sm-2 col-form-label">Clínica</label>
                            <select id="clinic" class="form-control" name="clinic" onclick="javascript:alterClinic(this);">
                                @foreach($clinics_option as $key => $clinic)
                                    <option value="{{ $clinic->id }}"
                                    
                                    @if($key == 0)
                                        selected
                                    @endif

                                    >{{ $clinic->name }}</option>
                                @endforeach
                            </select>   
                        </div>
                        <div class="form-group row">
                            <label class="pl-0 col-sm-2 col-form-label">Campanha</label>
                            <select id="select_posts" class="form-control" name="campaign" onclick="javascript:alterCampaign(this);">
                                @foreach($campaigns_option as $key => $campaign)
                                    <option value="{{ $campaign->id }}"
                                    
                                     @if($key == 0)
                                        selected
                                    @endif

                                    >{{ $campaign->name }}</option>
                                @endforeach
                            </select>   
                        </div>

                        <div class="form-group row" id="form-group-description">
                            
                        </div>

                        <div class="form-group text-center">
                            <button id="btnCollapseEdit" class="btn btn-primary" type="button" onclick="javascript:alterType();" data-toggle="collapse" data-target="#collapseEdit" aria-expanded="false">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar
                            </button>
                        </div>

                        <div class="collapse" id="collapseEdit">
                                <table id="table-select-posts" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Imagem</th>
                                            <th scope="col" class="text-center">Baixar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_posts">
                                       
                                    </tbody>
                                </table>
                            </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i> Baixar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var destiny_posts = document.getElementById('body_posts');
    var destiny_alerts = document.getElementById('form-group-description');
    var click_posts = document.getElementById('select_posts').value;
    var type_campaign = document.getElementById('type_campaign');
    var clinic = document.getElementById('clinic').value;

    function alterType() {
        type_campaign.value = 1;
    }

    function alterClinic(clinic_id) {
        clinic = clinic_id.value;
        getPostsAndAlertCampaign();
    }

    function alterCampaign(campaign_id) {
        click_posts = campaign_id.value;
        getPostsAndAlertCampaign();
    }

    function populateHeader(jsonObj) {
        
        result = jsonObj.response;
        while (destiny_posts.firstChild) {
            destiny_posts.removeChild(destiny_posts.firstChild);
        }
        for (i = 0; i < result.length; i = i + 1) {
            var img = document.createElement("img");
            img.src = "{{ route('welcome') }}/storage/"+result[i].image;
            img.width = 100;
            var td = document.createElement("td");
            td.appendChild(img);
            var tdd = document.createElement("td");
            tdd.className = "text-center";
            var input = document.createElement("input");
            input.name = result[i].id;
            input.type = "checkbox";
            input.checked = "checked";
            tdd.appendChild(input);
            var tr = document.createElement("tr");
            tr.appendChild(td);
            tr.appendChild(tdd);
            destiny_posts.appendChild(tr);
        }
        
    }
    function populateAlert(jsonObj) {
        
        result = jsonObj.response;
        while (destiny_alerts.firstChild) {
            destiny_alerts.removeChild(destiny_alerts.firstChild);
        }

        var label = document.createElement("label");
        label.className  = "pl-0 col-sm-2 col-form-label";
        label.textContent = "Observações"; 
        destiny_alerts.appendChild(label);
        var campaign_id = click_posts;
        for (i = 0; i < result.length; i = i + 1) {

            var strong = document.createElement("strong");
            strong.textContent = result[i].description;
            var alert = document.createElement("div");
            alert.className = "alert alert-danger col-md-12";
            
            alert.appendChild(strong);

            destiny_alerts.appendChild(alert);
        }
        
    }

    function getPosts() {
        destiny_posts.disabled = false;
        var campaign_id = click_posts;
        var url = "{{ route('welcome') }}/posts_filter/"+campaign_id;
        var requestURL = url;
        var request = new XMLHttpRequest();
        request.open('GET', requestURL, true);
        request.responseType = 'json';
        request.send();
        
        request.onload = function() {
            var posts = request;
            populateHeader(posts);
        }
    };

    function getAlerts() {
        var url = "{{ route('welcome') }}/alert?clinic="+clinic+"&campaign="+click_posts;
        var requestURL = url;
        var request = new XMLHttpRequest();
        request.open('GET', requestURL, true);
        request.responseType = 'json';
        request.send();
        
        request.onload = function() {
            var alerts = request;
            console.log(alerts);
            populateAlert(alerts);
        }
    };

    function getPostsAndAlertCampaign() {
        getPosts();
        getAlerts();
    }
        
</script>