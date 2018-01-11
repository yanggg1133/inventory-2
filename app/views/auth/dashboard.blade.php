@section('content')

<script type="text/javascript">
	$(document).ready(function(){

	    $('#button').click(function(e) {  
	        var startDate = $("#datepicker1").val();
	        var endDate = $("#datepicker2").val();
	        var start = encodeURIComponent(startDate);
	        var end = encodeURIComponent(endDate);
	        window.location.replace("/reports?start="+start+"&end="+end);

	    });
	});
</script> 
	<h3><i class="fa fa-tachometer fa-4"></i> Dashboard</h3>
	<hr>
	<div class="col-sm-9 col-md-12">
        	<div class="panel panel-primary">
				<div class="panel-heading">Sales Analytics for {{date("F")}}</div>	
			</div>

			<div id="chart_div" style="width=80%; height: 400px;"></div>
					
    </div>


<!--    <div class="col-sm-9 col-md-12 main">

          <div class="row placeholders">
            <div class="col-xs-6 col-sm-3 col-md-4">
              <h4>7 Days</h4>
              <div id="sales7" style="width: 400px;"></div>
            </div>
            <div class="col-xs-6 col-sm-3 col-md-4">
              <h4>14 Days</h4>
              <div id="sales14" style="width: 400px;"></div>
            </div>
            <div class="col-xs-6 col-sm-3 col-md-4">
              <h4>30 Days</h4>
              <div id="sales30" style="width: 400px;"></div>
            </div>
          </div>

        </div>	-->


        <div class="col-sm-4">
          <div class="list-group">
            <a href="#" class="list-group-item active">
              Purchase Orders
            </a>
            <center>
            @foreach ($purchase_orders as $purchase_order)
            <a href="{{URL::to('/purchase-orders')}}" class="list-group-item"><h2>{{$purchase_order->pos}}</h2></a>
            @endforeach
        	</center>
          </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-4">
          <div class="list-group">
            <a href="#" class="list-group-item active">
              Orders
            </a>
            <center>
            @foreach ($orders as $order)
           <a href="{{URL::to('/sales-orders')}}" class="list-group-item"><h2>{{$order->orders}}</h2></a>
            @endforeach
        </center>
          </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-4">
          <div class="list-group">
            <a href="#" class="list-group-item active">
              Shipments
            </a>
            <center>
            @foreach ($shipments as $shipment)
            <a href="{{URL::to('/shipments')}}" class="list-group-item"><h2>{{$shipment->packages}}</h2></a>
            @endforeach
        </center>
          </div>
        </div><!-- /.col-sm-4 -->


        <script type="text/javascript">
	      google.load("visualization", "1", {packages:["corechart"]});
	      google.setOnLoadCallback(sales7Chart);
	      google.setOnLoadCallback(sales14Chart);
	      google.setOnLoadCallback(sales30Chart);

	      function sales7Chart() {
	        var data = google.visualization.arrayToDataTable([
	        @foreach ($sales7 as $sale7)
	          ['source', 'orders'],
	          ['Website', {{$sale7->cscart}}],
	          ['Ebay',  {{$sale7->ebay}}],
	          ['Amazon', {{$sale7->amazon}}],
	        @endforeach
	        ]);

	        var options = {
	          pieHole: 0.4,
	        };

	        var chart = new google.visualization.PieChart(document.getElementById('sales7'));
	        chart.draw(data, options);
	      }
	      function sales14Chart() {
	        var data = google.visualization.arrayToDataTable([
	        @foreach ($sales14 as $sale14)
	          ['source', 'orders'],
	          ['Website', {{$sale14->cscart}}],
	          ['Ebay',  {{$sale14->ebay}}],
	          ['Amazon', {{$sale14->amazon}}],
	        @endforeach
	        ]);

	        var options = {
	          pieHole: 0.4,
	        };

	        var chart = new google.visualization.PieChart(document.getElementById('sales14'));
	        chart.draw(data, options);
	      }
	      function sales30Chart() {
	        var data = google.visualization.arrayToDataTable([
	        @foreach ($sales30 as $sale30)
	          ['source', 'orders'],
	          ['Website', {{$sale30->cscart}}],
	          ['Ebay',  {{$sale30->ebay}}],
	          ['Amazon', {{$sale30->amazon}}],
	        @endforeach
	        ]);

	        var options = {
	          pieHole: 0.4,
	        };

	        var chart = new google.visualization.PieChart(document.getElementById('sales30'));
	        chart.draw(data, options);
	      }
    	</script>
    	<script type="text/javascript">
	      google.load("visualization", "1", {packages:["corechart"]});
	      google.setOnLoadCallback(drawChart);
	      function drawChart() {
	        var data = google.visualization.arrayToDataTable([
	          ['Orders', 'Website', 'Amazon', 'Ebay'],
	          @foreach ($graph as $point)
	          ['{{date("d",strtotime("$point->date"))}}',  {{$point->website}},      {{$point->amazon}},      {{$point->ebay}}],
	          @endforeach
	        ]);

	        var options = {
	          hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},
	          vAxis: {minValue: 0}
	        };

	        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
	        chart.draw(data, options);
	      }
	      
	      //Resisze Graph for responsiveness

			$(window).on("resize orientationchange", function(){
			    drawChart();
			});
	    </script>

@stop