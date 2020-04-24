@section('datatable_section')
    @parent
    <link rel="stylesheet" type="text/css" href="{{base_path('/css/custom.css')}}" />
    {{$render->render_filters()}}

    <div class="row">
        <div class="insertactions col-md-12">
            {{$render->render_add_buttons()}}
        </div>
    </div>
    <div id="modal"  style="display: none">
        <div id="ajax_form" style="display: none"></div>
    </div>
    {{$render->render_table()}}
@stop

