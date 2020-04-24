<?php

namespace Phpdt\Ldt;

class Actions {

	var $formview = 'phpdt::confirmaction';
	public $initial_data;
	protected $request;
	protected $errors;

	function __construct( $request ) {
		$this->request = $request;
	}

	static function print_link( $record ) {
		return FALSE;
	}

	function respond() {
		$formissender = $this->request->formissender;
		if ( $formissender ) {

			$this->after_submit_form();
			if ( ! $this->valid() ) {
				if ( $this->formview != '' ) {
					return view( 'phpdt::.action', [ 'formview'     => $this->formview,
					                                 'request'      => $this->request,
					                                 'initial_data' => $this->initial_data,
					] );
				}
			}
			$this->reloaddatatable();
		} else {
			$this->initialize_form();
			$this->reloaddatatable();
			if ( $this->formview != '' ) {
				return view( 'phpdt::action', [ 'formview'     => $this->formview,
				                                'request'      => $this->request,
				                                'initial_data' => $this->initial_data,
				] );
			}
		}
	}

	function after_submit_form() {
		return TRUE;
	}

	function initialize_form() {
		$this->initial_data = new \stdClass();
	}

	static function can_do( $record ) {
		return TRUE;
	}

	function reloaddatatable() {
		echo '<script>var reloaddatatable=true;</script>';
	}

	function print_message( $m, $c ) {
		echo '<div class="alert alert-' . $c . '"  style="margin:0px;border-radius:0px">' . $m . '</div>';
	}

	function close( $m = 1500 ) {
		echo '<script>
                    function fadeout() {
                      $("#modal").fadeOut();
                    }
                    window.setTimeout(fadeout, ' . $m . ')</script>';
	}

	function requestParams() {
		return $this->request;
	}

	function selectedItems() {
		return json_decode( $this->request->input_elements_selected );
	}

	function postParams() {
		return $this->request->post;
	}

	function getPrams() {
		return $this->request->get;
	}

	function valid() {

		if ( is_array( $this->errors ) && count( $this->errors ) > 0 ) {
			$txt = implode( '<br> ', $this->errors );
			$this->print_message( $txt, 'danger' );

			return FALSE;
		}

		return TRUE;
	}

}
