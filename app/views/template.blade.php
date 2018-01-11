<?php $user = Sentry::getUser(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> {{ucwords(str_replace(str_split('\\/:*?"<>|-')," ",$_SERVER["REQUEST_URI"]))}} - BlueBinz</title>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
  <link rel="stylesheet" type="text/css" href="/assets/css/main.css">
  <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
  <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $('#dataTable').dataTable({
        "order": [[ 0, "desc" ]]
      });
    });
    $(document).ready(function(){
      $('#dataTable2').dataTable({
        "order": [[ 0, "desc" ]]
      });
    });
    $(document).ready(function(){
      $('.datepicker').each(function(){
        $(this).datepicker();
      });
    });
  </script>
</head>
<body>

@if (Sentry::check())
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{URL::to('/')}}"><i class="fa fa-cubes"></i> Blue Binz</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="{{URL::to('/dashboard')}}">Dashboard</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"> Catalog <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{URL::to('/products')}}">Products</a></li>
                <li><a href="{{URL::to('/virtual-products')}}">Virtual Products</a></li>
                <li><a href="{{URL::to('/adjustment-memos')}}">Adjustment Memo</a></li>
                <li><a href="{{URL::to('/purchase-orders')}}">Purchase Orders</a></li>
                <li class="divider"></li>
                <li><a href="{{URL::to('/suppliers')}}">Supplier</a></li>
                <li><a href="{{URL::to('/manufacturers')}}">Manufacturers</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"> Sales <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{URL::to('/sales-orders')}}"> Sales Orders</a></li>
                <li><a href="{{URL::to('/shipments')}}"> Shipments</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"> Reports <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{URL::to('/reports')}}"> Reports Center</a></li>
                <li><a href="{{URL::to('/quickbooks')}}"> Quick Books</a></li>
              </ul>
            </li>
            @if($user->hasAccess('admin'))
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"> Administration <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{URL::to('/sellers')}}"> Sellers </a></li>
                <li><a href="{{URL::to('/users')}}"> Users </a></li>
                <li><a href="{{URL::to('/sales/pull-orders/72c2bc635388ceda81d5d1941e')}}">Pull Orders</a></li>
              </ul>
            </li>
            @endif
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"> Settings <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{URL::to('/settings')}}"> Profile</a></li>
                <li><a href="{{URL::to('/logout')}}"> Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
@endif

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-9 col-md-12 main">

          @yield('content')

        </div>
      </div>
    </div>
</body>
</html>
