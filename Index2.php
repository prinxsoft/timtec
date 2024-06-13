<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>Title</title>
	 
	<link rel="stylesheet" href="style.css"/>
	<style>

		#table_id tbody tr.highlighted:hover{
		    background-color: #00f;
		}
		
	</style>
	<style type="text/css" title="currentStyle">
	    @import "DataTables/media/css/demo_table.css";
	</style>
 
	<script src="//localhost/scripts/jquery/jquery-1.9.1.js" type="text/javascript"></script>
	<script src="//localhost/scripts/jdatatable/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="//localhost/scripts/jeditable/jquery.jeditable.js" type="text/javascript"></script>
	<script src="//localhost/scripts/jui/jquery-ui.js" type="text/javascript"></script>
	<script src="//localhost/scripts/jvalidation/jquery.validate.js" type="text/javascript"></script>
	<script>
		var oTable1;
		
		$(document).ready( function () {
			var oTable = $('#table_id').dataTable({
		    	"bSortClasses": false,
		        "bProcessing": true,
		        "bServerSide": true,
		        "sAjaxSource": "server_processing.php"
		    });

		    oTable.$('tr').hover( function() {
		        var iCol = $('td', this.parentNode).index(this) % 17;
		        oTable.$('tr').addClass( 'highlighted' );
		    }, function() {
		        oTable.$('tr.highlighted').removeClass('highlighted');
		    } );




		    /* Add a click handler to the rows - this could be used as a callback */
		    $("#table_id tbody tr").click( function( e ) {
		        if ( $(this).hasClass('row_selected') ) {
		            $(this).removeClass('row_selected');
		        }
		        else {
		            oTable1.$('tr.row_selected').removeClass('row_selected');
		            $(this).addClass('row_selected');
		        }
		    });
		     
		    /* Add a click handler for the delete row */
		    $('#delete').click( function() {
		        var anSelected = fnGetSelected( oTable );
		        if ( anSelected.length !== 0 ) {
		            oTable1.fnDeleteRow( anSelected[0] );
		        }
		    } );

		    /* Init the table */
		    oTable1 = $('#table_id').dataTable( );





		    /* Apply the jEditable handlers to the table */
		    oTable1.$('td').editable( 'editable_ajax.php', {
		        "callback": function( sValue, y ) {
		            var aPos = oTable1.fnGetPosition( this );
		            oTable1.fnUpdate( sValue, aPos[0], aPos[1] );
		        },
		        "submitdata": function ( value, settings ) {
		            return {
		                "row_id": this.parentNode.getAttribute('id'),
		                "column": oTable1.fnGetPosition( this )[2]
		            };
		        },
		        "height": "14px",
		        "width": "100%"
		    } );

		
		} );

		/* Get the rows which are currently selected */
		function fnGetSelected( oTableLocal )
		{
		    return oTableLocal.$('tr.row_selected');
		}
		
		
		function fnClickAddRow() {
		    $('#table_id').dataTable().fnAddData( [
		
			"4",
			"Source",
			"Customer",
			"Ref",
			"Product",
			"Desc",
			"Qty",
			"Supplier",
			"Cost",
			"Status",
			"DateLogged",
			"LoggedBy",
			"ETA",
			"SentDate",
			"CompDate",
			"Delivery",
			"Notes"
		
		    ] );
		}		


	</script>
</head>
 
<body>
	<div><a onclick="fnClickAddRow();" href="javascript:void(0);">Click to add a new row</a><br><a id="delete" href="javascript:void(0)">Delete selected row</a><br><br></div>
	
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="table_id">
		<thead>
			<tr><th>JobID</th><th>Source</th><th>Customer</th><th>Ref</th><th>Product</th><th>Desc</th><th>Qty</th><th>Supplier</th><th>Cost</th><th>Status</th><th>DateLogged</th><th>LoggedBy</th><th>ETA</th><th>SentDate</th><th>CompDate</th><th>Delivery</th><th>Notes</th></tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="17" class="dataTables_empty">Loading data from server</td>
			</tr>
		</tbody>
		<tfoot>
			<tr><th>JobID</th><th>Source</th><th>Customer</th><th>Ref</th><th>Product</th><th>Desc</th><th>Qty</th><th>Supplier</th><th>Cost</th><th>Status</th><th>DateLogged</th><th>LoggedBy</th><th>ETA</th><th>SentDate</th><th>CompDate</th><th>Delivery</th><th>Notes</th></tr>
		</tfoot>
	</table>

 
</body>
</html>