<style>
  .modal-header {
    background-color: #0480be;
  }
  h5 {
    color: white;
  }
  </style>
<div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title" id="exampleModalLabel">
          Your Shopping Cart
        </h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body">
            @if(Session::get('successCart'))
                <div class="alert alert-success d-flex justify-content-center">
                    {{ Session::get('successCart') }}
                </div>
            @endif
            @if(Session::get('failOrder'))
						<div class="alert alert-danger d-flex justify-content-center">
							{{ Session::get('failOrder') }}
						</div>
					@endif
        <table id="myTable" class="table table-image">
          <thead>
              <tr>
                  <th hidden></th>
                  <th>Image</th>
                  <th scope="col">Product</th>
                  <th scope="col">Price</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Total</th>
                  <th scope="col">Actions</th>
              </tr>
          </thead>
          <tbody id="product_table">
            <form  id="updateQuantityForm" action="{{ route('checkout') }}" method="post">
              @csrf
                @foreach($cart as $id => $details)
                  <tr>
                      <td hidden><input type="text" id="id[]" name="id[]" value="{{ $details->productID }}"/></td>
                      <td class="w-25">
                        <img src="{{ asset($details->image) }}" class="img-fluid img-thumbnail cart-image" alt="products">
                      </td>
                      <td>{{ $details->product }}
                        <br>
                        <label style="opacity: 0.7; font-size: 14px;">Product Remaining: {{ $details->remaining }}</label
                      ></td>
                      <td>₱<input class="compute" type="text" id="price" name="price" style="width: 30%; border:none; outline:none" value="{{ $details->price }}" readonly/></td>
                      <td class="qty">
                        <input class="compute form-control" type="number" min="1" max="{{ $details->max_quantity }}" id="quantity" name="quantity[]" style="width: 100px;" value="{{ $details->quantity }}"/>
                      </td>
                      <td class="">
                        ₱<input class="compute txtCal" type="text" min="0" id="total" name="total[]" style="width: 50%; border:none; outline:none" value="{{ $details->total }}" readonly/>
                      </td>
                      <td>
                        <a href="{{ route('delete.product', ['id' => $details->productID]) }}" class="btn btn-danger btn-sm">
                          <i class="fa fa-times"></i>
                        </a>
                      </td>
                  </tr>
                @endforeach
              </form>
          </tbody>
        </table> 
          @if($cart->isEmpty())
            <div class="d-flex justify-content-center py-5">
              <h3>No Item</h3>
            </div>
          @endif
          <div class="d-flex justify-content-end">
            @if(session()->has('Customer'))
              <h4>Total: <span id="totalPrices">{{ $totalPrice }}</span></h4>
            @endif
          </div>
      </div>
     
      <div class="modal-footer border-top-0 justify-content-center">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        @if(session()->has('Customer'))
          @if(!$cart->isEmpty())    
            <button type="submit" form="updateQuantityForm" class="checkoutButton btn btn-success">Checkout</button>  
          @endif
        @endif
      </div>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
    const table = document.getElementById('product_table');

    table.addEventListener('input', ({ target }) => {
        var calculated_total_sum = 0;
        const tr = target.closest('tr');
        const [price, quantity, total] = tr.querySelectorAll(".compute");;
        total.value = price.value * quantity.value;

        $("#myTable .txtCal").each(function () {
            var get_textbox_value = $(this).val();
            calculated_total_sum += parseFloat(get_textbox_value);
        });
        $("#totalPrices").html(calculated_total_sum);
       
    });
    
</script>



