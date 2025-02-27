<style>
    .navbar {
        margin: 0px;
        padding: 0px;
        z-index: 999;
    }

    .nav-background {
        background: linear-gradient(90deg, rgb(162, 0, 255) 0%, rgb(229, 71, 250) 35%, rgb(255, 255, 255) 100%);
        filter: drop-shadow(0 0 0.2rem rgb(88, 88, 88));
    }

  
</style>

<nav id="navbar_top" class="navbar navbar-expand-lg d-flex flex-column">
    <div class="container-fluid d-inline-flex justify-content-between nav-background pt-2 px-4 pb-2">
        <div class="">
            <a class="navbar-brand fs-3 fw-bold d-flex align-items-center" style="color:white" href="/home">
                <img src="{{ asset('img/E_Commerce_Icon.jpg') }}" alt="/home" style="width:auto; height:60px;"> 
                <div class="px-2">
                    <h4>E-Commerce Website.</h4>
                </div>
            </a>
        </div> 
        @if(!request()->is('register'))
            <div class=""> 
                <form action="{{ route('search.item') }}" method="get">
                    @csrf
                    <div class="input-group">
                        <input type="text" id="search" name="search" class="form-control outline-secondary align-self-center searchInput " placeholder="Search bar" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary bg-white" type="submit" id="button-addon2">
                            <i class="fa-solid fa-magnifying-glass" style="color:black"></i>
                        </button>
                    </div>
                </form>      
            </div> 
        @endif
        
        <div class="d-flex align-items-center"> 
            @if(session()->has('Customer'))   
                <button type="button" class="btn px-2" data-toggle="modal" data-target="#cart">
                    <div class="col">
                        <i class="fa-solid fa-shopping-cart fa-2x" style="color:dodgerblue"></i>
                        <h6>My Cart</h6>
                    </div>
                </button>             
                <div class="nav-item dropdown ">
                    <button type="button" class="btn" id="navbarDropdown" data-bs-toggle="dropdown">
                        <div class="col">
                            <i class="fa-solid fa-user fa-2x" style="color:dodgerblue"></i>
                            <h6>{{ $customerDetails->fname }}</h6>
                        </div>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="right: 0; left: auto;">
                        <li> 
                            <a class="dropdown-item" href="{{ route('orders') }}">Orders</a>
                        </li>  
                        <li> 
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#profileModal">Profile</a>
                        </li>               
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                        </li>
                    </ul>
                </div>
            @else
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#loginModal">
                    <div class="col">
                        <i class="fa-solid fa-user fa-2x" style="color:dodgerblue"></i>
                        <h6>Login</h6>
                    </div>
                </button> 
            @endif
        </div> 
    </div>
</nav>