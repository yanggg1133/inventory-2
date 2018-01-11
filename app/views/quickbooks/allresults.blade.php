@section('content')
<script>
                $(document).ready(function(){
                    $('.details').click(function(){
                        $(this).find('.hiders').toggle();
                    });
                    $('.details2').click(function(){
                        $(this).find('.hiders').toggle();
                    });
                    $('.details3').click(function(){
                        $(this).find('.hiders').toggle();
                    });
                    $('.details4').click(function(){
                        $(this).find('.hiders').toggle();
                    });
                });
            </script>
<div class="row">
        <div class="col-md-12">
            <h3>{{$amazoncustomer}}</h3>
            <strong>{{date("F d, Y", strtotime($start_date))}} - {{date("F d, Y", strtotime($end_date))}}</strong>
            <hr>
            <table cellpadding="0" cellspacing="0" border="0" class="reports-table table table-striped table-bordered">
                <thead>
                    <tr>
                      <th> Product</th>
                      <th> Quantity </th>
                      <th> Total </th>
                      <th> Tax </th>
                      <th> Shipping </th>
                      <th> Fee </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($amazon as $amazon)
                    <tr>
                        <td>{{$amazon[0]["product"]}}</td>
                        <td>{{$amazon[0]["qty"]}}</td>
                        <td>{{money_format('%n', $amazon[0]["total"])}}</td>
                        <td>{{money_format('%n', $amazon[0]["tax"])}}</td>
                        <td>{{money_format('%n', $amazon[0]["shipping"])}}</td>
                        <td>{{money_format('%n', $amazon[0]["fee"])}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td><strong>Totals</strong></td>
                        <td><strong>{{$amazonqty}}</strong></td>
                        <td><strong>{{money_format('%n', $amazontotal)}}</strong></td>
                        <td><strong>{{money_format('%n', $amazontax)}}</strong></td>
                        <td><strong>{{money_format('%n', $amazonship)}}</strong></td>
                        <td><strong>{{money_format('%n', $amazonfee)}}</strong></td>
                    </tr>
                </tbody>
            </table>



            <div>
                <fieldset class="details">
                <strong><i class="fa fa-plus-square-o"></i> {{$amazonflcustomer}} Details</strong>
                <div class="hiders" style="display:none" >
                    <table cellpadding="0" cellspacing="0" border="0" class="reports-table table table-striped table-bordered">
                        <thead>
                            <tr>
                              <th> Order </th>
                              <th> Purchase </th>
                              <th> Product</th>
                              <th> Quantity </th>
                              <th> Total </th>
                              <th> Tax </th>
                              <th> Shipping </th>
                              <th> Fee </th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($amazondetails as $amazondetail)
                            <tr>
                                <td><strong>{{$amazondetail->order_id}}</strong></td>
                                <td>{{$amazondetail->purchase_date}}</td>
                                <td>{{$amazondetail->qbid}}</td>
                                <td>{{$amazondetail->quantity}}</td>
                                <td>{{money_format('%n', $amazondetail->total)}}</td>
                                <td>{{money_format('%n', $amazondetail->tax)}}</td>
                                <td>{{money_format('%n', $amazondetail->shipping)}}</td>
                                <td>{{money_format('%n', $amazondetail->fee)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <h4>Estimated Deposit : {{money_format('%n',($amazontotal+$amazontax)-$amazonfee)}}</h4>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3>{{$amazonflcustomer}}</h3>
            <strong>{{date("F d, Y", strtotime($start_date))}} - {{date("F d, Y", strtotime($end_date))}}</strong>
            <hr>
            <table cellpadding="0" cellspacing="0" border="0" class="reports-table table table-striped table-bordered">
                <thead>
                    <tr>
                      <th> Product</th>
                      <th> Quantity </th>
                      <th> Total </th>
                      <th> Tax </th>
                      <th> Shipping </th>
                      <th> Fee </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($amazonfl as $amazonfl)
                    <tr>
                        <td>{{$amazonfl[0]["product"]}}</td>
                        <td>{{$amazonfl[0]["qty"]}}</td>
                        <td>{{money_format('%n', $amazonfl[0]["total"])}}</td>
                        <td>{{money_format('%n', $amazonfl[0]["tax"])}}</td>
                        <td>{{money_format('%n', $amazonfl[0]["shipping"])}}</td>
                        <td>{{money_format('%n', $amazonfl[0]["fee"])}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td><strong>Totals</strong></td>
                        <td><strong>{{$amazonflqty}}</strong></td>
                        <td><strong>{{money_format('%n', $amazonfltotal)}}</strong></td>
                        <td><strong>{{money_format('%n', $amazonfltax)}}</strong></td>
                        <td><strong>{{money_format('%n', $amazonflship)}}</strong></td>
                        <td><strong>{{money_format('%n', $amazonflfee)}}</strong></td>
                    </tr>
                </tbody>
            </table>



            <div>
                <fieldset class="details2">
                <strong><i class="fa fa-plus-square-o"></i> {{$amazonflcustomer}} Details</strong>
                <div class="hiders" style="display:none" >
                    <table cellpadding="0" cellspacing="0" border="0" class="reports-table table table-striped table-bordered">
                        <thead>
                            <tr>
                              <th> Order </th>
                              <th> Purchase </th>
                              <th> Product</th>
                              <th> Quantity </th>
                              <th> Total </th>
                              <th> Tax </th>
                              <th> Shipping </th>
                              <th> Fee </th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($amazonfldetails as $amazonfldetail)
                            <tr>
                                <td><strong>{{$amazonfldetail->order_id}}</strong></td>
                                <td>{{$amazonfldetail->purchase_date}}</td>
                                <td>{{$amazonfldetail->qbid}}</td>
                                <td>{{$amazonfldetail->quantity}}</td>
                                <td>{{money_format('%n', $amazonfldetail->total)}}</td>
                                <td>{{money_format('%n', $amazonfldetail->tax)}}</td>
                                <td>{{money_format('%n', $amazonfldetail->shipping)}}</td>
                                <td>{{money_format('%n', $amazonfldetail->fee)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <h4>Estimated Deposit : {{money_format('%n',($amazonfltotal+$amazonfltax)-$amazonflfee)}}</h4>

        </div>
    </div>

        <div class="row">
        <div class="col-md-12">
            <h3>{{$websitecustomer}}</h3>
            <strong>{{date("F d, Y", strtotime($start_date))}} - {{date("F d, Y", strtotime($end_date))}}</strong>
            <hr>
            <table cellpadding="0" cellspacing="0" border="0" class="reports-table table table-striped table-bordered">
                <thead>
                    <tr>
                      <th> Product</th>
                      <th> Quantity </th>
                      <th> Total </th>
                      <th> Tax </th>
                      <th> Shipping </th>
                      <th> Fee </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($website as $website)
                    <tr>
                        <td>{{$website[0]["product"]}}</td>
                        <td>{{$website[0]["qty"]}}</td>
                        <td>{{money_format('%n', $website[0]["total"])}}</td>
                        <td>{{money_format('%n', $website[0]["tax"])}}</td>
                        <td>{{money_format('%n', $website[0]["shipping"])}}</td>
                        <td>{{money_format('%n', $website[0]["fee"])}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td><strong>Totals</strong></td>
                        <td><strong>{{$websiteqty}}</strong></td>
                        <td><strong>{{money_format('%n', $websitetotal)}}</strong></td>
                        <td><strong>{{money_format('%n', $websitetax)}}</strong></td>
                        <td><strong>{{money_format('%n', $websiteship)}}</strong></td>
                        <td><strong>{{money_format('%n', $websitefee)}}</strong></td>
                    </tr>
                </tbody>
            </table>



            <div>
                <fieldset class="details3">
                <strong><i class="fa fa-plus-square-o"></i> {{$websitecustomer}} Details</strong>
                <div class="hiders" style="display:none" >
                    <table cellpadding="0" cellspacing="0" border="0" class="reports-table table table-striped table-bordered">
                        <thead>
                            <tr>
                              <th> Order </th>
                              <th> Purchase </th>
                              <th> Product</th>
                              <th> Quantity </th>
                              <th> Total </th>
                              <th> Tax </th>
                              <th> Shipping </th>
                              <th> Fee </th>
                              <th> Gross </th>
                              <th> Net </th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($websitedetails as $websitedetail)
                            <tr>
                                <td><strong>{{$websitedetail->order_id}}</strong></td>
                                <td>{{$websitedetail->purchase_date}}</td>
                                <td>{{$websitedetail->buyer_name}}</td>
                                <td>{{$websitedetail->quantity}}</td>
                                <td>{{money_format('%n', $websitedetail->total)}}</td>
                                <td>{{money_format('%n', $websitedetail->tax)}}</td>
                                <td>{{money_format('%n', $websitedetail->shipping)}}</td>
                                <td>{{money_format('%n', $websitedetail->fee)}}</td>
                                <td>{{money_format('%n', ($websitedetail->total+$websitedetail->tax+$websitedetail->shipping))}}</td>
                                <td>{{money_format('%n', ($websitedetail->total+$websitedetail->tax+$websitedetail->shipping)-$websitedetail->fee)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <h4>Estimated Deposit : {{money_format('%n',($websitetotal+$websitetax)-$websitefee)}}</h4>
            <h4>Gross : {{money_format('%n', $websitegross)}}</h4>
            <h4>Net : {{money_format('%n', $websitenet)}}</h4>

        </div>
    </div>

        <div class="row">
        <div class="col-md-12">
            <h3>{{$websiteflcustomer}}</h3>
            <strong>{{date("F d, Y", strtotime($start_date))}} - {{date("F d, Y", strtotime($end_date))}}</strong>
            <hr>
            <table cellpadding="0" cellspacing="0" border="0" class="reports-table table table-striped table-bordered">
                <thead>
                    <tr>
                      <th> Product</th>
                      <th> Quantity </th>
                      <th> Total </th>
                      <th> Tax </th>
                      <th> Shipping </th>
                      <th> Fee </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($websitefl as $websitefl)
                    <tr>
                        <td>{{$websitefl[0]["product"]}}</td>
                        <td>{{$websitefl[0]["qty"]}}</td>
                        <td>{{money_format('%n', $websitefl[0]["total"])}}</td>
                        <td>{{money_format('%n', $websitefl[0]["tax"])}}</td>
                        <td>{{money_format('%n', $websitefl[0]["shipping"])}}</td>
                        <td>{{money_format('%n', $websitefl[0]["fee"])}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td><strong>Totals</strong></td>
                        <td><strong>{{$websiteflqty}}</strong></td>
                        <td><strong>{{money_format('%n', $websitefltotal)}}</strong></td>
                        <td><strong>{{money_format('%n', $websitefltax)}}</strong></td>
                        <td><strong>{{money_format('%n', $websiteflship)}}</strong></td>
                        <td><strong>{{money_format('%n', $websiteflfee)}}</strong></td>
                    </tr>
                </tbody>
            </table>



            <div>
                <fieldset class="details4">
                <strong><i class="fa fa-plus-square-o"></i> {{$websiteflcustomer}} Details</strong>
                <div class="hiders" style="display:none" >
                    <table cellpadding="0" cellspacing="0" border="0" class="reports-table table table-striped table-bordered">
                        <thead>
                            <tr>
                              <th> Order </th>
                              <th> Purchase </th>
                              <th> Product</th>
                              <th> Quantity </th>
                              <th> Total </th>
                              <th> Tax </th>
                              <th> Shipping </th>
                              <th> Fee </th>
                              <th> Gross </th>
                              <th> Net </th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($websitefldetails as $websitefldetail)
                            <tr>
                                <td><strong>{{$websitefldetail->order_id}}</strong></td>
                                <td>{{$websitefldetail->purchase_date}}</td>
                                <td>{{$websitefldetail->buyer_name}}</td>
                                <td>{{$websitefldetail->quantity}}</td>
                                <td>{{money_format('%n', $websitefldetail->total)}}</td>
                                <td>{{money_format('%n', $websitefldetail->tax)}}</td>
                                <td>{{money_format('%n', $websitefldetail->shipping)}}</td>
                                <td>{{money_format('%n', $websitefldetail->fee)}}</td>
                                <td>{{money_format('%n', ($websitefldetail->total+$websitefldetail->tax+$websitefldetail->shipping))}}</td>
                                <td>{{money_format('%n', ($websitefldetail->total+$websitefldetail->tax+$websitefldetail->shipping)-$websitefldetail->fee)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <h4>Estimated Deposit : {{money_format('%n',($websitefltotal+$websitefltax)-$websiteflfee)}}</h4>
            <h4>Gross : {{money_format('%n', $websiteflgross)}}</h4>
            <h4>Net : {{money_format('%n', $websiteflnet)}}</h4>

        </div>
    </div>
@stop
