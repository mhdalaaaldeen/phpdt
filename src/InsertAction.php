<?php

namespace Phpdt\Ldt;

class InsertAction extends Actions {

	const INSERT_MODE = TRUE;

	static function row_button( $record ) {
		return '';
	}

	function initialize_form() {
		$this->initial_data = new \stdClass();
	}

	function after_submit_form() {

		$this->print_message( 'Default Message', 'success' );
		$this->close( 1000 );
	}

	static function add_button() {
		return '<span class="btn btn-info"> <i class="fa fa-plus"></i> Add</span>';
	}

}
