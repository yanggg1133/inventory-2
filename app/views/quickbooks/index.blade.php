@section('content')
<script type="text/javascript">
	$(document).ready(function(){
		$('#qbdates').click(function(e) {
					var selectRoute = $("#route").val();  
			        var selectStart = $("#datepicker3").val();
			        var selectEnd = $("#datepicker4").val();
			        var route = encodeURIComponent(selectRoute);
			        var start = encodeURIComponent(selectStart);
			        var end = encodeURIComponent(selectEnd);
			        window.open("/quickbooks/"+route+"?start="+start+"&end="+end, '_blank');

			    });
	});
</script> 
	<h3><i class="fa fa-tachometer fa-4"></i> Dashboard</h3>


				<h2>Quick Books Reports</h2>
				<hr>
				<div class="clearfix"></div>

    <div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">Excel Export</div>	
			<div class="panel-body">
				<div class="col-md-6">
				<label>Start Date</label>
				<input id="datepicker3" name="date[]" type="text" placeholder="xxxx-xx-xx" class="input-md datepicker">
				</div>
				<div class="col-md-6">
				<label>End Date</label>
				<input id="datepicker4" name="date[]" type="text" placeholder="xxxx-xx-xx" class="input-md datepicker">
				</div>
				<div class="col-md-6">
				<label>Seller</label>
				<select id="route" name="route" >  
						<option value="all">All</option>    
						<option value="amazon">AMZ</option>
						<option value="amazonfl">AMZFL</option>
						<option value="cscart">TTS</option>
						<option value="cscartfl">TTSFL</option>
				</select>
				</div>
				<div class="clearfix"></div>
				<hr>
				<div class="col-md-6">
				<button type="button" id="qbdates" class="btn btn-sm btn-primary">Submit</button>
				</div>
			</div>
		</div>
	</div>
@stop