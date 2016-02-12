/* Set the defaults for DataTables initialisation */
$.extend( true, $.fn.dataTable.defaults, {
	"sDom": "<<'col-xs-6'l><'col-xs-6'f>r>t<<'col-xs-6'i><'col-xs-6'p>>",
	"sPaginationType": "bootstrap",
	"oLanguage": {
        "sLengthMenu": "_MENU_ " + $_lang.records_per_page,
        "sZeroRecords": $_lang.nothing_found,
        "sInfo": $_lang.showing + " _START_ "+ $_lang.to +" _END_ "+ $_lang.of +" _TOTAL_ " + $_lang.records,
        "sInfoEmpty": $_lang.showing + " 0 "+ $_lang.to +" 0 "+ $_lang.of +" 0 " + $_lang.records,
        "sInfoFiltered": "(" + $_lang.filtered_from +" _MAX_ " + $_lang.total_records+")",
        "sSearch" : $_lang.search + ":",
        "sEmptyTable" : $_lang.no_data_in_table
	}
} );




/* Default class modification */
$.extend( $.fn.dataTableExt.oStdClasses, {
	"sWrapper": "dataTables_wrapper form-inline",
	"sFilterInput": "form-control input-sm",
	"sLengthSelect": "form-control input-sm"
} );


/*
 * TableTools Bootstrap compatibility
 * Required TableTools 2.1+
 */
if ( $.fn.DataTable.TableTools ) {
	// Set the classes that TableTools uses to something suitable for Bootstrap
	$.extend( true, $.fn.DataTable.TableTools.classes, {
		"container": "DTTT btn-group",
		"buttons": {
			"normal": "btn btn-default",
			"disabled": "disabled"
		},
		"collection": {
			"container": "DTTT_dropdown dropdown-menu",
			"buttons": {
				"normal": "",
				"disabled": "disabled"
			}
		},
		"print": {
			"info": "DTTT_print_info modal"
		},
		"select": {
			"row": "active"
		}
	} );

	// Have the collection use a bootstrap compatible dropdown
	$.extend( true, $.fn.DataTable.TableTools.DEFAULTS.oTags, {
		"collection": {
			"container": "ul",
			"button": "li",
			"liner": "a"
		}
	} );
}
