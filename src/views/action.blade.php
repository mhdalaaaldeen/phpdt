@extends($formview)
@section('save_action_form_section')
    @parent

    <input type="hidden" name="input_elements_selected" value="{{$request->input_elements_selected}}">
    <input type="hidden" name="get" value="{{$request->get}}">
    <input type="hidden" name="post" value="{{$request->post}}">
    <input type="hidden" name="formissender" value="true">
    <input type="hidden" name="_token"   class="sesskeyaction_form"  value="{{csrf_token()}}">
    <input type="hidden" name="form" value="{{$request->form}}">
    <script>$(".cnclbtn783423423").click(function(){("#ajax_form").fadeOut();});</script>

    <div class="group-btn-action">
        <input type="submit" name="submit" value="Save" id="id_submitajax" class="btn btn-primary">
        <input type="button" name="cancel" value="Cancel" id="id_cancel" class="btn btn-danger">
    </div>

@stop

@section('confirm_action_form_section')
    @parent
    <input type="hidden" name="input_elements_selected" value="{{$request->input_elements_selected}}">
    <input type="hidden" name="get" value="{{$request->get}}">
    <input type="hidden" name="post" value="{{$request->post}}">
    <input type="hidden" name="formissender" value="true">
    <input type="hidden"  class="sesskeyaction_form" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="form" value="{{$request->form}}">
    <script>$(".cnclbtn783423423").click(function(){("#ajax_form").fadeOut();});</script>

    <div class="group-btn-action" style="padding:20px;">
        <p>Are you sure?</p>
        <input type="submit" name="submit" value="Yes" id="id_submitajax" class="btn btn-primary">
        <input type="button" name="cancel" value="No" id="id_cancel" class="btn btn-danger">
    </div>
@stop
