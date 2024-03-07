<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{\App\CPU\Helpers::translate('Ready to Leave')}}?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">{{\App\CPU\Helpers::translate('Select "Logout" below if you are ready to end your current session')}}.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">{{\App\CPU\Helpers::translate('Cancel')}}</button>
                <a class="btn btn--primary btn-primary" href="{{route('seller.auth.logout')}}">{{\App\CPU\Helpers::translate('Logout')}}</a>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="popup-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <center>
                            <h2 style="color: rgba(96,96,96,0.68)">
                                <i class="tio-shopping-cart-outlined"></i> {{\App\CPU\Helpers::translate('You have new order, Check Please')}}.
                            </h2>
                            <hr>
                            <button onclick="check_order()" class="btn btn--primary btn-primary">{{\App\CPU\Helpers::translate('Ok, let me check')}}</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
