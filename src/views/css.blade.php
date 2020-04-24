<style>
    .form_ajax_bulk {
        display: inline-block;
        width: auto;
        padding: 2px;

    }

    #modal {
        position: fixed !important;
        background: #000;
        width: 100%;
        position: fixed;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        background: rgba(51, 51, 51, 0.7);
        z-index: 10;
    }

    #ajax_form {
        width: 50%;
        z-index: 9999;
        background: #fff;
        margin: 50px  auto;
        border: 5px solid #000;

    }

    .postion_relative {
        position: relative !important;
    }

    .select2-container {
        width: auto !important;
        min-width: 150px;
        max-width: 250px;
        display: block !important;
    }


    .select2-container--default .select2-selection--multiple,
    .select2-container--default .select2-selection--single {
        border: 1px solid #ced4da !important;;
        padding: 5px 5px;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple,
    .select2-container--default.select2-container--focus .select2-selection--single {
        border: 1px solid #66dae0 !important;;
    }

    .select2-container--default .select2-selection__choice {
        background-color: #66dae0 !important;
        border: 0px !important;
        color: #fff !important;
        margin: 4px !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove,
    .select2-container--default .select2-selection--single .select2-selection__choice__remove {
        color: #0a0905 !important;
        cursor: pointer;
        display: inline-block;
        font-weight: bold;
        margin-right: 5px;
        margin-top: -6px !important;
        top: 0px !important;
        padding: 0px;
        vertical-align: text-bottom;
    }

    .select2-dropdown {
        border: 1px solid #eeeeee !important;
    }

    .select2-results__option {
        border-bottom: 1px solid #eee;
        background: #fefefe;
        font-size: 13px;
        padding: 4px;
    }

    .select2-container--default .select2-results__option[aria-selected=true] {
        background: #66dae0 !important;
        color: #fff !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__rendered li {
        font-size: 13px;
    }

    .select2-container .select2-selection--single {
     height: 34px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 5px !important;
    }

    .dataTables_filter {
        display: none;
    }
    .dataTables_processing {
        padding: 0px; !important;

    }
    .dataTables_processing img{
        width: 100%;
        height: 100%;

    }
    th.sorting {
        cursor: pointer ;
    }

</style>