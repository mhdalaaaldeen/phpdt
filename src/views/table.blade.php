<?php
$columns = $dt_obj->columns;
$columns_array = [];
$remove_sorting = '';

//disable order checkbox column
$orderindesx = 0;
if (isset($dt_obj->options['checkboxes']) && $dt_obj->options['checkboxes'] == true) {
	$orderindesx = 1;
	$columns_data[] = '{"data": "checkboxes_columns"}';
	$remove_sorting = '{"targets":0,"orderable": false}';
}

//columns
foreach ($columns as $columnkey => $columnheader) {
	$columns_data[] = '{ "data": "' . $columnkey . '" }';
}

if (isset($dt_obj->options['actions']) && !is_array($dt_obj->options['actions']))
	$dt_obj->options['actions']=unserialize($dt_obj->options['actions']);

//disable order action column
$between=false;
if (isset($dt_obj->options['actions']) && is_array($dt_obj->options['actions'])  && count($dt_obj->options['actions'])) {


	$between=true;
	$columns_data[] = '{ "data": "actions_columns" }';
	if (!empty($remove_sorting))
		$remove_sorting=$remove_sorting.' , ';
	$in =  count($columns_data) - 1;
	$remove_sorting .= ' {"targets": ' . $in . ',"orderable": false}';
}

if ($between || empty($remove_sorting)){
	$remove_sorting='['.$remove_sorting.']';
}

?>
<table id='{{$dt_obj->tableid}}'
       data-datatable_ajaxload='{{route('datatable_ajaxload', [])}}'
       data-dataorder='{{$orderindesx}}'
       data-columnDefs='{{$remove_sorting}}'
       data-pageLength='{{$dt_obj->perpage}}'
       data-url='{{route('datatable_homepage', [])}}'
       data-_token='{{csrf_token()}}'
       data-mycolumns ='{{json_encode($dt_obj->columns)}}'
       data-filters ='{{json_encode($dt_obj->filters)}}'
       data-columns_functions ='{{json_encode($dt_obj->columns_functions)}}'
       data-datatable = '{{urlencode($dt_obj->datatable)}}'
       data-listing = '{{$dt_obj->listing}}'
       data-options ='{{json_encode($dt_obj->options)}}'
       data-datatolisting ='{{json_encode($dt_obj->datatolisting)}}'
       data-additional_filters ='{{json_encode($dt_obj->additional_filters)}}'
       data-columns_data='[{{implode(',', $columns_data)}}]'
       class="table phpdt_ldt_datatable table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
    <tr>
	<?php
	if (isset($dt_obj->options['checkboxes']) && $dt_obj->options['checkboxes'] == true) {
		echo '<th><input type="checkbox" name="selectall" id="chbox_selectall"></th>';
	}
	foreach ($columns as $columnkey => $columnheader) {
		echo '<th>' . $columnheader . '</th>';
	}
	if (isset($dt_obj->options['actions']) && is_array($dt_obj->options['actions'])   && count($dt_obj->options['actions'])) {
		echo  '<th >Actions</th>';
	}
	?>

</table>
@include('phpdt::js')
@include('phpdt::css')