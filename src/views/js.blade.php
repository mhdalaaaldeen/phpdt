@include('phpdt::includes')
<script type="text/javascript" language="javascript" class="init">
    var datatables = [],
        datatable_ajaxload = "";
    $(".phpdt_ldt_datatable").each(function(t) {
        datatables[t] = $(this)
    });
    var table, reloaddatatable = !1,
        elemets_seletced = [],
        seleted_all = !1;

    function get_filters_value_as_array() {
        $(".dataTables_processing").empty().append("<img   src='https://i1.wp.com/www.rankred.com/wp-content/uploads/2017/06/Loader.gif?resize=650%2C230'>");
        var t = new Array;
        return $(".datatable_filters").each(function() {
            var a = $("#" + this.id).data("op"),
                e = $("#" + this.id).data("fieldname");
            console.log(e);
            var n = $("#" + this.id).val();
            console.log(n), "" != this.value && t.push(new Array(e, a, n))
        }), t
    }

    function select_chbox(t) {
        document.getElementById("chbox" + t).checked ? (elemets_seletced[t] = "" + t, $("#chbox" + t).parent().parent().parent().addClass("selected")) : (delete elemets_seletced[t], $("#chbox_selectall").prop("checked", !1), $("#chbox" + t).parent().parent().parent().removeClass("selected"))
    }

    function selectd_element() {
        return !1
    }
    $(document).ready(function() {

        //
    });
    $(document).ready(function() {

        function t(t, a, e) {
            return $("#ajax_form").css("display", "none"), $("#modal").fadeIn(), $.ajax({
                url: datatable_ajaxload,
                type: "POST",
                data: {
                    form: t,
                    _token: a,
                    current_url: window.location.href,
                    input_elements_selected: e
                },
                success: function(t) {
                    $("#ajax_form").html(t), $("#ajax_form").fadeIn(), 1 == reloaddatatable && (table.search(JSON.stringify(get_filters_value_as_array())).draw(), reloaddatatable = !1), $(".dataTables_processing").fadeOut()
                },
                error: function(t) {
                    $("#ajax_form").html("Ajax Error!")
                }
            }), !1
        }
        $.fn.dataTableExt.sErrMode = "none", $.each(datatables, function(t, a) {
            datatable_ajaxload = a.attr("data-datatable_ajaxload"), console.log(a.attr("data-dataorder")), table = a.DataTable({
                lengthChange: !1,
                order: [
                    [0, "UNSET"]
                ],
                columnDefs: JSON.parse(a.attr("data-columnDefs")),
                pageLength: a.attr("data-pageLength"),
                processing: !0,
                serverSide: !0,
                pagingType: "first_last_numbers",
                searching: !0,
                ajax: {
                    url: a.attr("data-url"),
                    type: "POST",
                    data: function(t) {
                        t._token = a.attr("data-_token"), t.mycolumns = a.attr("data-mycolumns"), t.filters = a.attr("data-filters"), t.columns_functions = a.attr("data-columns_functions"), t.datatable = a.attr("data-datatable"), t.listing = a.attr("data-listing"), t.options = a.attr("data-options"), t.datatolisting = a.attr("data-datatolisting"), t.additional_filters = a.attr("data-additional_filters"), t.additional_filters = a.attr("data-additional_filters")
                    }
                },
                columns: JSON.parse(a.attr("data-columns_data"))
            }),$('.dt-table').removeClass('row');
        }), table.on("draw.dt", function() {
            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip()
            }), $("#chbox_selectall").attr("checked", !1), elemets_seletced = [], seleted_all = !1
        }), $(".datatable_filters_textbox").on("keyup", function() {
            table.search(JSON.stringify(get_filters_value_as_array())).draw()
        }), $(".datatable_filters_select").each(function() {
            $("#" + this.id).on("change", function(t, a) {
                table.search(JSON.stringify(get_filters_value_as_array())).draw()
            })
        }), $(".dataTables_wrapper").on("change", "#chbox_selectall", function() {
            $(this).prop("checked") ? $(".element_chbox_datatable").each(function() {
                idrecord = $(this).val(), console.log(idrecord), $(this).prop("checked", !0), select_chbox(idrecord)
            }) : $(".element_chbox_datatable").each(function() {
                idrecord = $(this).val(), console.log(idrecord), $(this).prop("checked", !1), select_chbox(idrecord)
            })
        }), $(document).on("click", ".submit_link_action_tep", function() {
            var a = [];
            a.push($("#" + this.id).data("id")), console.log($("#" + this.id).data("id")), console.log($("#" + this.id)), t($("#" + this.id).data("formclass"), $("#" + this.id).data("sesskeyaction_form"), JSON.stringify(a))
        }), $(document).on("click", "#id_submitajax", function() {
            ! function() {
                $("#ajax_form").fadeOut(0);
                var t = {
                    current_url: window.location.href
                };
                $("#ajax_form :input").each(function() {
                    name = $(this).attr("name"), type = $(this).attr("type"), "checkbox" == type ? $(this).prop("checked") ? value = 1 : value = 0 : value = $(this).val(), t[name] = value
                }), $.ajax({
                    url: datatable_ajaxload,
                    type: "POST",
                    data: t,
                    success: function(t) {
                        $("#ajax_form").html(t), $("#ajax_form").fadeIn(t), 1 == reloaddatatable && (table.search(JSON.stringify(get_filters_value_as_array())).draw(), reloaddatatable = !1), $(".dataTables_processing").fadeOut()
                    },
                    error: function(t) {
                        $("#ajax_form").html("Ajax Error!")
                    }
                })
            }()
        }), $(document).on("click", "#id_cancel", function() {
            $("#modal").fadeOut(function() {
                $("#ajax_form").empty()
            })
        }),  $(".btns_submit .add_action_submit").click(function() {
            var e = $(this).parent().data("formid");
            t($("#" + e + " .formclass ").val(), $("#" + e + " .sesskey").val(), $("#" + e + " .input_elements_selected ").val())
        })
    });

</script>
