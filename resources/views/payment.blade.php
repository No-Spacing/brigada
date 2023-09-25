<!DOCTYPE html>
<html>
<head>
  <title>Payment</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="css/payment.css">
</head>
<body>
  <main class="page payment-page">
    <section class="payment-form dark">
      <div class="container">
        <div class="block-heading">
          <h2>Payment</h2>
          <p>Please review your products before placing your order.</p>
        </div>
          <div class="products">
              <h3 class="title">Checkout</h3>
              @if(Session::get('noOrder'))
                <div class="alert alert-danger d-flex justify-content-center">
                    {{ Session::get('noOrder') }}
                </div>
              @else
                @foreach($products as $product)
                  <div class="item">
                    <img src="{{ $product->image }}" width="60">
                    <span class="price">₱{{ $product->total }}.00</span>
                    <p class="item-name">{{ $product->product }}</p>
                    <p class="item-description">Quantity: {{ $product->quantity }}</p>
                  </div>
                @endforeach 
              @endif 
              <div class="total">Total<span class="price">₱{{ $total }}.00</span></div>
          </div>
          <div class="card-details">
            <h3 class="title">Payment Options</h3>
            <div class="row">
              <div class="container py-2">
                <div class="card">
                  <div class="card-header">
                    <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                      <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3 col">
                        <li class="nav-item" value="Credit Card"> <a data-toggle="pill" href="#credit-card" class="nav-link active "> <i class="fas fa-credit-card mr-2"></i> Credit Card </a> </li>
                        <li class="nav-item" value="COD"> <a data-toggle="pill" href="#paypal" class="nav-link "> <i class="fa-solid fa-truck mr-2"></i> COD </a></li>
                        <li class="nav-item" value="Net Banking"> <a data-toggle="pill" href="#net-banking" class="nav-link "> <i class="fas fa-mobile-alt mr-2"></i> Net Banking </a> </li>
                      </ul>
                    </div> <!-- End -->
                    <!-- Credit card form content -->
                    <div class="tab-content">
                      <!-- credit card info-->
                      <div id="credit-card" class="tab-pane fade show active pt-3">
                        <form class="form-group" style="width:100%;" action="{{ route('place.order') }}" method="post">
                          @csrf
                          <div class="container-fluid pb-3">
                            <div class="form-group pt-2"> <label for="username">
                              <h6>Card Owner</h6>
                              </label> <input type="text" name="username" placeholder="Card Owner Name" required class="form-control "> 
                            </div>
                            <div class="form-group"> 
                              <label for="cardNumber"><h6>Card number</h6></label>
                              <div class="input-group"> 
                                <input type="number" min="0" name="cardNumber" placeholder="Valid card number" class="form-control " required>
                                <div class="input-group-append"> 
                                  <span class="input-group-text text-muted">
                                    <i class="fa fa-credit-card mx-1"></i>
                                  </span>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                  <div class="form-group"> <label><span class="hidden-xs">
                                    <h6>Expiration Date</h6>
                                    </span></label>
                                    <div class="input-group"> 
                                      <input type="number" min="0" placeholder="MM" name="" class="form-control" required> 
                                      <input type="number" min="0" placeholder="YY" name="" class="form-control" required> 
                                      <input type="text" id="paymentMethod" name="paymentMethod" class="form-control" value="Credit Card" hidden/> 
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group mb-2"> <label data-toggle="tooltip" title="Three digit CV code on the back of your card">
                                    <h6>CVV <i class="fa fa-question-circle d-inline"></i></h6>
                                    </label> <input type="text" required class="form-control"> 
                                  </div>
                                </div>
                            </div>
                            @if(!$products->count() == NULL)
                              <div class="form-group d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary w-50">Place Your Order</button>
                              </div>
                            @endif 
                          </div>
                        </form>
                      </div> <!-- End -->
                    <!-- Paypal info -->
                    <div id="paypal" class="tab-pane fade pt-3">
                      <form action="{{ route('place.order') }}" method="post">
                        @csrf
                        <div class="container-fluid pb-3">
                          <label>
                            <h6 class="py-2">CASH ON DELIVERY</h6>
                          </label>
                          <p class="text-muted"> 
                            Note: Please prepare exact amount when the delivery rider has come to your place.
                          </p>
                          <input type="text" id="paymentMethod" name="paymentMethod" class="form-control" value="Cash On Delivery" hidden/> 
                          @if(!$products->count() == NULL)
                            <div class="form-group d-flex justify-content-center">
                              <button type="submit" class="btn btn-primary w-50">Place Your Order</button>
                            </div>
                          @endif 
                        </div>
                      </form>
                    </div> <!-- End -->
                    <!-- bank transfer info -->
                    <div id="net-banking" class="tab-pane fade pt-3">
                      <form class="form-group" style="width:100%;" action="{{ route('place.order') }}" method="post">
                        @csrf
                        <div class="container-fluid pb-3">
                          <div class="form-group"> 
                            <label for="Select Your Bank" class="pt-2">
                              <h6>Select your Bank</h6>
                            </label> 
                            <select class="form-control" id="ccmonth" required>
                              <option value="" selected disabled>--Please select your Bank--</option>
                              <option>BDO</option>
                              <option>BPI</option>
                              <option>PNB</option>
                              <option>MetroBank</option>
                            </select> 
                            <input type="text" id="paymentMethod" name="paymentMethod" class="form-control" value="Net Banking" hidden/> 
                          </div>
                          @if(!$products->count() == NULL)
                            <div class="form-group d-flex justify-content-center">
                              <button type="submit" class="btn btn-primary w-50">Place Your Order</button>
                            </div>
                          @endif 
                        </div>
                      </form>
                    </div> 
                  </div>
                </div>
              </div>
            </div>
      </div>
    </section>
  </main>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>