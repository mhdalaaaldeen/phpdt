<div class="btns_submit ">
@foreach($actions as $action)
        <form class="form_ajax_add" data-formid="form_ajax_add_{{$action['name']}}"
              id="form_ajax_add_{{$action['name']}}" method="post"   >
            <input type="hidden" name="input_elements_selected" class="input_elements_selected" >
            <input type="hidden"  name="_token" value="{{ csrf_token() }}" class="sesskey" >
            <input type="hidden"  name="formclass" value="{{$action['class']}}" class="formclass" >
            <a href="#" class="add_action_submit">
            <?php echo $action['class']::add_button(); ?>
            </a></form>
@endforeach
</div>
