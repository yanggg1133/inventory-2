<table>
 <tbody>
  <tr>
   <td>Customer</td>
   <td>Product</td>
   <td>QTY</td>
   <td>Total</td>
   <td>Shipping</td>
   <td>Tax</td>
   <td>Fee</td>
  </tr>
  @foreach ($products as $product)
  <tr>
   @if ($amazon["$product->sku"][0]["qty"] > 0 && $amazon["$product->sku"][0]["qty"] != NULL && isset($amazon["$product->sku"][0]["qty"]))
    <td>{{$customer}}</td>
    <td>{{$amazon["$product->sku"][0]["product"]}}</td>
    <td>{{$amazon["$product->sku"][0]["qty"]}}</td>
    <td>{{money_format('%n', $amazon["$product->sku"][0]["total"])}}</td>
    <td>{{money_format('%n', $amazon["$product->sku"][0]["shipping"])}}</td>
    <td>{{money_format('%n', $amazon["$product->sku"][0]["tax"])}}</td>
    <td>{{money_format('%n', $amazon["$product->sku"][0]["fee"])}}</td>
   @endif
  </tr>
  @endforeach
 </tbody>
</table>