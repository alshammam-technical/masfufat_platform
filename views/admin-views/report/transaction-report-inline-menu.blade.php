<div class="inline-page-menu my-4">
    <ul class="list-unstyled">
        <li class="{{ Request::is('admin/transaction/order-transaction-list') ?'active':'' }}"><a href="{{route('admin.transaction.order-transaction-list')}}">{{\Helpers::translate('Order_Transactions')}}</a></li>
        <li class="{{ Request::is('admin/transaction/expense-transaction-list') ?'active':'' }}"><a href="{{route('admin.transaction.expense-transaction-list')}}">{{\Helpers::translate('Expense_Transactions')}}</a></li>
        <li class="{{ Request::is('admin/transaction/refund-transaction-list') ?'active':'' }}"><a href="{{ route('admin.transaction.refund-transaction-list') }}">{{\Helpers::translate('Refund_Transactions')}}</a></li>
    </ul>
</div>
