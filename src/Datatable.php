<?php

namespace Phpdt\Ldt;

use Illuminate\Support\Str;

class Datatable {

	const TABLE = '';

	const INDEX = '';

	var $columns = [];
	var $tableid = '';
	var $columns_functions = [];
	var $filters = [];
	var $options = [];
	var $perpage;
	var $datatable;
	var $wwwroot;
	var $ME;
	var $listing;
	var $additional_filters;
	var $datatolisting;
	var $filterelements = [];

	function __construct(
		$columns, $columns_functions = [], $perpage = 30, $options = []
	) {

		$this->tableid            = Str::random();
		$this->columns            = $columns;
		$this->columns_functions  = $columns_functions;
		$this->perpage            = $perpage;
		$this->datatable          = get_class( $this );
		$this->wwwroot            = \URL::to( '/' );
		$this->ME                 = \Request::getPathInfo();
		$this->additional_filters = [];
		$this->datatolisting      = [];
	}

	function set_checkbox( $options ) {
		$this->options['checkboxes'] = $options;
	}

	function set_query( $function_name = '' ) {
		$this->listing = $function_name;
	}

	function set_additional_filters( $additional_filters = [] ) {
		$this->additional_filters = $additional_filters;
	}

	function set_datatolisting( $datato_query = [] ) {
		$this->datatolisting = $datato_query;
	}

	function addfilter( $name, $type, $label, $op, $data = NULL ) {
		$filter                 = new \stdClass();
		$filter->name           = $name;
		$filter->type           = $type;
		$filter->label          = $label;
		$filter->op             = $op;
		$filter->data           = $data;
		$filter->data           = $data;
		$filter->id             = rand( 100, 2000 ) . '' . str_replace( '.', '_', $name ) . '';
		$filter->url            = '';
		$this->filterelements[] = $filter;
	}

	static function respond_filters_autocomplete( $records ) {
		$arr = [];
		foreach ( $records as $recordid => $value ) {
			$arr[] = $value;
		}
		echo json_encode( $arr );
	}

	static function respond_filters_tag( $records ) {
		$arr = [];
		foreach ( $records as $id => $record ) {
			$arr[] = [ 'id' => $id, 'name' => $record ];
		}

		echo json_encode( $arr );
	}

	function addaction( $newaction ) {

		if ( isset( $this->options['actions'] ) ) {
			$actions = unserialize( $this->options['actions'] );
		} else {
			$actions = [];
		}

		$actions[]                = $newaction;
		$actions                  = serialize( $actions );
		$this->options['actions'] = $actions;
	}

	function display( $view, \Illuminate\Http\Request $request ) {

		$render = new \Phpdt\Ldt\RenderDatatable( $this );

		return view( $view, [ 'dt_obj'  => $this,
		                      'request' => $request,
		                      'render'  => $render,
		] );
	}

}

