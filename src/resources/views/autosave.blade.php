@extends($page ?? 'vellum::modal_no_header')
@section('content')
<div class="modal-body">
    <div class="panel panel-default panel-fullheight">
        <div class="panel-heading clearfix navbar-fixed-top">
            <button type="button" class="btn btn-outline cf-button close-modal pull-left" close-modal>Cancel</button>
            <button type="button" class="btn btn-success cf-button pull-right insert-media">Select This Version</button>
        </div>
        <div class="panel-body mt-7">
            <div class="px-3 panel-fullheight">
                <div class="px-3">
                    <input type="hidden" value="{{$originalRedirect}}" id="redirect_url">
                        <div class="row">
                            <h4 class="text-center"> 
                                @icon(['icon' => 'info'])
                                This form was not closed properly. Please choose a version below to continue editing this form.
                            </h4>
                            <div class="col-md-12">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#autosave" data-toggle="tab">Auto Saved<i> - {{ $timestamp }}</i></a></li>
                                    <li><a href="#previous" data-toggle="tab">Previously Saved<i></i></a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content mt-5">
                                    <div class="tab-pane active" id="autosave">
                                        <table class="table table-bordered" width="100%">
                                            <tbody>
                                                @foreach($autosave as $key => $value)
                                                <tr>                                                    
                                                    <td width="20%">{{ ucwords($key) }}</td>
                                                    <td width="80%">{{ $value }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="previous">
                                        <table class="table table-bordered" width="100%">
                                            <tbody>
                                                @foreach($original as $key => $value)
                                                <tr>
                                                    <td width="20%">{{ ucwords($key) }}</td>
                                                    <td width="80%">{{ $value }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
.nav-tabs>li.active>a {
    background-color: #008dde!important;
    color: #fff!important;
}
</style>
@endpush

@push('scripts')
<script type="text/javascript">
    var version;

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        e.target // activated tab
        e.relatedTarget // previous tab
        version = $(e.target).attr('href').replace('#', '');
        if(version=='autosave') {
        $('#redirect_url').val('{{$autosaveRedirect}}');
        } else {
        $('#redirect_url').val('{{$originalRedirect}}');
        }
    });

    $('.insert-media').on('click',function(){
        var url = $('#redirect_url').val();
        parent.window.location = url;
    });
</script>
@endpush