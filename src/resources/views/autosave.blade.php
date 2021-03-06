@extends($page ?? 'vellum::modal')

@section('head')
	@include('vellum::modal.header-buttons', ['attributes' => arrayToHtmlAttributes(['id' => 'insert-media']), 'rightBtnTxt' => 'Select This Version'])
@endsection

@section('content')
<div class="px-3">
	<input type="hidden" value="{{$autosaveRedirect}}" id="redirect_url">
    <div class="row">
        <h4 class="text-center">
            @icon(['icon' => 'info'])
            This form was not closed properly. Please choose a version below to continue editing this form.
        </h4>
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="active autosave-tab"><a href="#autosave" data-toggle="tab">Auto Saved<i> - {{ $timestamp }}</i></a></li>
                <li class="autosave-tab"><a href="#previous" data-toggle="tab">Previously Saved<i></i></a></li>
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
@endsection

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

    $('#insert-media').on('click',function(){
        var url = $('#redirect_url').val();
        parent.window.location = url;
    });
</script>
@endpush
