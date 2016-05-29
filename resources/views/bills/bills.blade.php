@extends ('layouts.tables')

@section ('variables')

<?php 
	$columns = array('Number', 'Date', 'Description', 'Customer', 'Amount', 'Taxes', 'Driver');
?>

@endsection

@section ('script')

<script type='text/javascript'>

	function childRow() {
		return "<table>" +
					"<tr>" +
						"<td>" +
							"<button class='edit-button'><a href=''><i class='fa fa-edit'></i></a></button>" +
							"<button class='delete-button'><a href=''><i class='fa fa-trash'></i></a></button>" +
							"<button class='save'><a href=''><i class='fa fa-save'></i></a></button>" +
						"</td>" +
						"<td></td>" +
						"<td></td>" +
						"<td></td>" +
						"<td>" + "<label>ID</label>" + "</td>" +
						"<td>" + "<label>%</label>" + "</td>" +
						"<td>" + "<label>Total</label>" + "</td>" +
					"</tr>" +
					"<tr>" +
						"<td>" + "<label>Bill #:</label>" + "<br>" + "<input style='width: 100px;' readonly type='number' value='15246' />" + "</td>" +
						"<td>"+ "<label>Date:</label>" + "<br>" + "<input style='width: 100px;' readonly type='date' />" + "</td>" +
						"<td>" + "<label>Amount:</label>" + "<br>" + "<input style='width: 100px;' readonly type='money' value='$12.50' />" + "</td>" +
						"<td>" + "<label>Pickup:</label>" + "</td>" +
						"<td>" + "<input style='width:65px;' readonly type='number' value='1001' min='1' />" + "</td>" +
						"<td>" + "<input style='width:50px;' readonly type='number' value='34' min='0' max='100' />" + "</td>" +
						"<td>" + "<input style='width:100px;' readonly type='money' value='$5.29' />" + "</td>" +
					"</tr>" +
					"<tr>" +
						"<td>" + "<label>Customer #:</label>" + "<br>" + "<input style='width: 100px;' readonly type='number' value='14597' />" + "</td>" +
						"<td>" + "<label>Customer Name:</label>" + "<br>" + "<input readonly type='text' value='Fast Forward Express' />" + "</td>" +
						"<td>" + "<label>Interliner Amount:</label>" + "<br>" + "<input style='width: 100px;' readonly type='money' value='$0.00' />" + "</td>" +
						"<td>" + "<label>Delivery:</label>" + "</td>" +
						"<td>" + "<input style='width:65px;' readonly type='number' value='298' min='1' />" + "</td>" +
						"<td>" + "<input style='width:50px;' readonly type='number' value='34' min='0' max='100' />" + "</td>" +
						"<td>" + "<input style='width:100px;' readonly type='money' value='$50000.29' min='0.00' />" + "</td>" +
					"</tr>" +
					"<tr>" +
						"<td>" + "<label>Manifest: 15497</label>" + "</td>" +
						"<td>" + "<label>Invoice: 27648</label>" + "</td>" +
						"<td>" + "<label>Driver Amount:</label>" + "<br>" + "<input style='width: 100px;' readonly type='money' value='$12.50' />" + "</td>" +
						"<td>" + "<label>Interliner:</label>" + "</td>" +
					"</tr>" +
				"</table>" +
				"Description: Delivery for 03/01/2105 - do not deliver before 2pm, no one will be home";
	}

</script>

@parent

@endsection

@section ('navBar')

<table>
	<button class='navButton btn-primary fa'><i class='fa-icon-plus'></i>Create New Bill</button>
	<button class='navButton btn-primary'>Edit Bill</button>
	<button class='navButton btn-primary'>Eat IceCream</button>
</table>

@endsection
