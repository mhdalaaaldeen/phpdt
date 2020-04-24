<?php

namespace Phpdt\Ldt;

use Mockery\Expectation;
use phpDocumentor\Reflection\DocBlock\Tags\Example;

class BaseController extends \App\Http\Controllers\Controller {

	public $querybuilder;

	function index( \Illuminate\Http\Request $request ) {

		$data_table = urldecode( $request->input( 'datatable' ) );
		//$querybuilder=\DB::table(\Website\Datatables\Test::select());
		$sesskeyaction_form = csrf_token();

		if ( method_exists( $data_table, 'from' ) ) {
			$querybuilder = \DB::table( $data_table::from() );
		}
		if ( method_exists( $data_table, 'select' ) ) {
			$querybuilder->select( $data_table::select() );
		} else {
			$querybuilder->select( '*' );
		}

		if ( method_exists( $data_table, 'joins' ) ) {
			$joins = $data_table::joins();
			foreach ( $joins as $join ) {
				$querybuilder->join( $join[0], $join[1], $join[2], $join[3] );
			}
		}

		$where_array      = [];
		$wherein_array    = [];
		$wherenotin_array = [];
		$whereNull        = [];
		$filters_values   = json_decode( $request->input( 'search' )['value'] );

		$additional_filters = json_decode( $request->input( 'additional_filters' ), TRUE );

		if ( is_array( $additional_filters ) ) {
			foreach ( $additional_filters as $fieldname => $fiedvalue ) {

				if ( empty( $fiedvalue ) ) {
					$querybuilder->whereNull( $fiedvalue );
				} else {
					if ( is_numeric( $fiedvalue ) ) {
						$where_array[] = [ $fieldname, ' = ', $fiedvalue ];
					} else {
						$where_array[] = [
							$fieldname,
							'like',
							'%' . $fiedvalue . '%',
						];
					}
				}
			}
		}

		if ( is_array( $filters_values ) ) {
			foreach ( $filters_values as $filters_value ) {
				if ( method_exists( $data_table, 'filtermap' ) && isset( $data_table::filtermap()[ $filters_value[0] ] ) ) {
					$filed = $data_table::filtermap()[ $filters_value[0] ];
				} else {
					$filed = $filters_value[0];
				}

				if ( $filters_value[1] == 'like' ) {
					$where_array[] = [
						$filed,
						$filters_value[1],
						'%' . $filters_value[2] . '%',
					];
				} else if ( $filters_value[1] == '=' || $filters_value[1] == '!=' || $filters_value[1] == '>' || $filters_value[1] == '<' || $filters_value[1] == '<=' || $filters_value[1] == '>=' ) {
					$where_array[] = [
						$filed,
						$filters_value[1],
						$filters_value[2],
					];
				} elseif ( $filters_value[1] == 'notin' ) {
					$wherenotin_array[] = [ $filed, $filters_value[2] ];
				} elseif ( $filters_value[1] == 'in' ) {
					$wherein_array[] = [ $filed, $filters_value[2] ];
				}
			}

			foreach ( $wherein_array as $in ) {
				$querybuilder->whereIn( $in[0], $in[1] );
			}
			foreach ( $wherenotin_array as $in ) {
				$querybuilder->whereNotIn( $in[0], $in[1] );
			}
		}
		if ( count( $where_array ) ) {
			$querybuilder->where( $where_array );
		}

		$options = json_decode( $request->input( 'options' ), TRUE );

		$columns           = json_decode( $request->input( 'mycolumns' ) );
		$columns_functions = json_decode( $request->input( 'columns_functions' ), TRUE );

		$array_col = [];
		foreach ( $columns as $columnskey => $columnsheader ) {
			$array_col[] = $columnskey;
		}

		$orders      = $request->input( 'order' );
		$sql_orderby = [];

		$order_by_click = FALSE;
		foreach ( $orders as $order ) {
			if ( $order['column'] == 0 ) {
				continue;
			}

			if ( isset( $options['checkboxes'] ) && $options['checkboxes'] == TRUE ) {
				$order_by_column = $array_col[ $order['column'] - 1 ];
			} else {
				$order_by_column = $array_col[ $order['column'] ];
			}
			$order_by_click = TRUE;
			$querybuilder->orderBy( $order_by_column, $order['dir'] );
		}

		if ( method_exists( $data_table, 'orderby' ) && ! $order_by_click ) {
			if ( is_array( $data_table::orderBy() ) ) {

				foreach ( $data_table::orderBy() as $f ) {
					$querybuilder = $querybuilder->orderBy( $f[0], $f[1] );
				}
			} else {
				throw new Exception( 'orderBy must be returned array.' );
			}
		}

		$allrecords = $querybuilder->get()->count();
		$querybuilder->limit( $request->input( 'length' ) )
		             ->offset( $request->input( 'start' ) );

		//================
		$records         = $querybuilder->get();
		$recordsTotal    = $allrecords;
		$recordsFiltered = $allrecords;

		$array = [];
		$index = 0;

		foreach ( $records as $id => $record ) {

			$indexcolumn = $data_table::PRIMARY;
			$id          = $record->$indexcolumn;

			if ( isset( $options['checkboxes'] ) && $options['checkboxes'] == TRUE ) {
				$array[ $index ]['checkboxes_columns'] = '<lable styel="display:block;padding:5px;" for="chbox1' . $id . '"><input
                    class="element_chbox_datatable"
                    onchange="select_chbox(' . $id . ');"
                    type="checkbox"
                    id="chbox' . $id . '"
                    name="chbox' . $id . '"
                    value="' . $id . '"></lable>';
			}
			foreach ( $record as $recordid => $recordvalue ) {
				if ( isset( $columns_functions[ $recordid ] ) && method_exists( $data_table, $columns_functions[ $recordid ] ) ) {

					$fnname                       = $columns_functions[ $recordid ];
					$array[ $index ][ $recordid ] = $data_table::$fnname( $record );
				} else {
					$array[ $index ][ $recordid ] = '<lable for="chbox1' . $id . '">' . $recordvalue . '</lable>';
				}
			}
			$actions_html = '';
			if ( isset( $options['actions'] ) ) {
				if ( ! is_array( $options['actions'] ) ) {
					$actions = unserialize( $options['actions'] );
				} else {
					$actions = $options['actions'];
				}
				foreach ( $actions as $action ) {

					if ( $action['class']::can_do( $record ) ) {
						$modal = ' class="submit_link_action_tep" data-formclass="' . $action['class'] . '" data-sesskeyaction_form="' . $sesskeyaction_form . '" data-id="' . $id . '"';

						if ( method_exists( $action['class'], 'row_button' ) ) {
							$actions_html .= '<a id="button_ajax' . md5( time() . rand( 1, 1000 ) ) . '" href="#page-MADB"  ' . $modal . '   >' . $action['class']::row_button( $id, $action['class'] ) . ' </a>';
						} else if ( method_exists( $action['class'], 'row_link' ) ) {
							$actions_html .= $action['class']::row_link( $id, $action['class'] );
						} else {
							$actions_html .= '<a id="button_ajax' . md5( time() . rand( 1, 1000 ) ) . '" href="#page-MADB"  ' . $modal . '   >' . basename( $action['class'] ) . ' </a>';
						}
					}
				}
				$array[ $index ]['actions_columns'] = $actions_html;
			}
			$index ++;
		}

		echo json_encode( [
			"draw"            => isset ( $params['draw'] ) ? intval( $params['draw'] ) : 0,
			"recordsTotal"    => intval( $recordsTotal ),
			"recordsFiltered" => intval( $recordsFiltered ),
			"data"            => $array,
		] );
		die;
	}

	function do_actiondatatable() {
		echo 'print form here';
		die;
	}

	function ajaxload( \Illuminate\Http\Request $request ) {
		$form = $request->input( 'form' );
		$form = new $form( $request );

		return $form->respond();
	}

}
