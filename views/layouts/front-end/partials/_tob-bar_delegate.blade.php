

<style>
    .navbar-sticky{
        margin-top: 44px !important;
    }
    /* Top Bar Styles */
.top-bar {
    background-color: #673ab7; /* Yellow background */
    color: #333; /* Dark text color */
    padding: 10px 0; /* Some padding */
    z-index: 99999999999999;
    position: fixed;
    width: -webkit-fill-available;
    height: 44px !important;
    top: 0;
}
#mySidebar{
    margin-top: 44px !important
}
.top-bar .top-bar-left p,
.top-bar .top-bar-right p {
    margin: 0; /* Remove default margins */
    padding: 0 15px; /* Add some padding */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .top-bar .top-bar-left,
    .top-bar .top-bar-right {
        justify-content: center;
        padding-bottom: 10px;
    }
}

</style>
<!-- Top Bar -->
<div class="top-bar">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <!-- Left Side Content -->
                <div class="top-bar-left d-flex align-items-center">
                    <div class="text">
                        <p class="text-white"> 👋 {{\App\CPU\Helpers::translate('Hello') }} {{ $delegateStore->name }} </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Right Side Content -->
                <div class="top-bar-right d-flex justify-content-end align-items-center">
                    <div class="email">
                        <p class="text-white">{{\App\CPU\Helpers::translate('You manage an account for') }} : {{ $store->store_informations['company_name'] ?? $store->name }}</p>
                    </div>
                    <!-- Other elements here -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Top Bar -->
