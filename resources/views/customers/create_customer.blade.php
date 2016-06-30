@extends ('layouts.app')

@section ('script')

<script type='text/javascript' src='public/dist/jquery.validate.js'></script>

<script type="text/javascript">
$(document).ready(function() {
	$('#subLocation, #separateBillingAddr, #giveDiscount, #giveCommission, #giveDriverCommission, #balanceOwingInterest, #gstExempt, #useCustomField').change(function() {
		if(this.checked){
			$('tr#' + this.id).fadeIn();
		}
		else{
			$('tr#' + this.id).fadeOut();
		}
	});
	$('#advFilter input[type="checkbox"]').each(function(i,j) { 
		if(j.checked){
			$('tr#' + j.id).fadeIn();
		}
		else{
			$('tr#' + j.id).fadeOut();
		}
	});
});

function showSecondaryContact() {
	$('.secondaryContact').prop('hidden', false);
	$('#secondaryContact-button').prop('hidden', true);
}
</script>

@parent

@endsection

@section ('style')

@endsection

@section ('content')
<form id='createCustomer'>
	<table id='newCustomer'>
		<thead>
		</thead>
		<tbody>
			<tr id='subLocation' hidden>
				<td><label for='parentLocation'>Parent Location: </label></td>
				<td><select id='parentLocation' class='' name='parentLocation'></td>
			</tr>
			<tr>
				<td><label>Company Name: </label></td>
				<td><input id='companyName' type='' name='companyName' required></td>
			</tr>
			<tr>
				<td><label>Delivery Address: </label></td>
				<td><input id='deliveryAddress' type='' name='deliveryAddress' required></td>
				<td><label>Postal Code: </label></td>
				<td><input id='deliveryPostalCode' type='' name='deliveryPostalCode' required></td>
			</tr>
			<tr id='separateBillingAddr' hidden>
				<td><label>Billing Address: </label></td>
				<td><input id='billingAddress' type='' name='billingAddress'></td>
				<td><label>Postal Code: </label></td>
				<td><input id='billingPostalCode' class='postalCode' type='' name='billingPostalCode'></td>
			</tr>
			<tr>
				<td><label>Primary Contact: </label></td>
			</tr>
			<tr>
				<td><label>Name:</label>
				<td><input type='' name='PrimContactName' required></td>
				<td><label>Primary Phone #: </label></td>
				<td><input type='' name='PrimContactPhone' required></input></td>
				<td><label>Secondary Phone #: </label></td>
				<td><input type='' name='PrimContactSecondPhone'></td>
			</tr>
			<tr>
				<td><label>Primary Email Address: </label></td>
				<td><input type='email' name='PrimContactEmailAddress' required></td>
				<td><label>Secondary Email Address:</label></td>
				<td><input type='email' name='PrimContactSecondEmailAddress'></td>
			</tr>
			<tr>
				<td><button id='secondaryContact-button' type='button' onclick="showSecondaryContact();">Show Secondary Contact</button></td>
			</tr>
			<tr class='secondaryContact' hidden>
				<td><label>Secondary Contact: </label></td>
			</tr>
			<tr class='secondaryContact' hidden>
				<td><label>Name:</label>
				<td><input type='' name='SecondaryContactName'></td>
				<td><label>Primary Phone #: </label></td>
				<td><input type='' name='SecondaryContactPhone'></input></td>
				<td><label>Secondary Phone #: </label></td>
				<td><input type='' name='SecondaryContactSecondPhone'></td>
			</tr>
			<tr class='secondaryContact' hidden>
				<td><label>Primary Email Address: </label></td>
				<td><input type='email' name='SecondaryContactEmailAddress'></td>
				<td><label>Secondary Email Address:</label></td>
				<td><input type='email' name='SecondaryContactSecondEmailAddress'></td>
			</tr>
			<tr>
				<td><label>Rate Type:</label></td>
				<td><select required></select></td>
				<td><label>Invoice Interval:</label></td>
				<td><select required></select></td>
			</tr>
			<tr id='giveDiscount' hidden>
				<td><label>Discount:</label></td>
				<td><input min=0 max=100 type='number' name='Discount'></td>
			</tr>
			<tr id='giveCommission' hidden>
				<td><label>Commission ID:</label></td>
				<td><input min=0 type='number' name=''></td>
				<td><label>Commission %</label></td>
				<td><input min=0 max=100 type='number' name='Commission'></td>
			</tr>
			<tr id='giveDriverCommission' hidden>
				<td><label>Driver Commission ID:</label></td>
				<td><input min=0 type='number' name='DriverCommissionID'></td>
				<td><label>Driver Commission %:</label></td>
				<td><input min=0 max=100 type='number' name='DriverCommissionPercentage'></td>
			</tr>
			<tr id='useCustomField' hidden>
				<td><label>Custom Field Name:</label></td>
				<td><input type='' name='CustomField'></td>
				<td><label><input type='checkbox' name='Sortable'>Sortable?</label></td>
			</tr>
		</tbody>
	</table>
</form>
@endsection

@section ('navBar')
<ul class='nav nav-pills nav-stacked'>
	<li class='navButton'><a href="">Save</a></li>
	<li class='navButton'><a href="">Save and New</a></li>
	<li class='navButton'><a href="">Cancel</a></li>
</ul>
@endsection

@section ('advFilter')
<div id='advFilter'>
	<label><input type='checkbox' id='subLocation' value=''> Is Sub-Location</input></label>
	<label><input type='checkbox' id='separateBillingAddr' value=''> Use Separate Billing Address</input></label>
	<label><input type='checkbox' id='giveDiscount' value=''> Give Discount</input></label>
	<label><input type='checkbox' id='giveCommission' value=''> Give Commission</input></label>
	<label><input type='checkbox' id='giveDriverCommission' value=''> Give Driver Commission</input></label>
	<label><input type='checkbox' id='useCustomField' name='' value=''>Use Custom Field</label>
	<label><input type='checkbox' id='balanceOwingInterest' value=''> Charge Interest on Balance Owing</input></label>
	<label><input type='checkbox' id='gstExempt' value=''> GST Exempt</input></label>
</div>
@endsection
