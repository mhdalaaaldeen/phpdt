<?php

namespace Phpdt\Ldt;

class RenderDatatable {

	private $objDatatable;

	function __construct( Datatable $objDatatable ) {
		$this->objDatatable = $objDatatable;
	}

	function render_add_buttons() {

		if ( isset( $this->objDatatable->options['actions'] ) && ! empty( $this->objDatatable->options['actions'] ) && ( isset( $this->objDatatable->options['checkboxes'] ) && $this->objDatatable->options['checkboxes'] == TRUE ) ) {
			$actions = unserialize( $this->objDatatable->options['actions'] );
			foreach ( $actions as $key => $action ) {
				if ( ! method_exists( $action['class'], 'add_button' ) || $action['class']::INSERT_MODE != TRUE ) {
					unset( $actions[ $key ] );
				}
			}
		} else {
			$actions = [];
		}

		return view( 'phpdt::add_buttons', [ 'actions' => $actions ] );
	}

	function render_filters() {
		return view( 'phpdt::filters' )->with( 'filters', $this->objDatatable->filterelements );
	}

	function render_table() {
		return view( 'phpdt::table', [ 'dt_obj' => $this->objDatatable ] );
	}

}

