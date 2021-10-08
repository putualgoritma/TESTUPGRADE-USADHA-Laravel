<?php

//Route::get('member/register', 'MembersController@register');
Route::resource('member', 'MembersController');

Route::redirect('/', '/login');

Route::redirect('/home', '/admin');

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');

    Route::resource('permissions', 'PermissionsController');

    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');

    Route::resource('roles', 'RolesController');

    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');

    Route::resource('users', 'UsersController');

    Route::delete('products/destroy', 'ProductsController@massDestroy')->name('products.massDestroy');

    Route::resource('products', 'ProductsController');

    Route::delete('accounts/destroy', 'AccountController@massDestroy')->name('accounts.massDestroy');
    Route::resource('accounts', 'AccountController');
    Route::get('accbalance', 'AccbalanceController@index')->name('accbalance');
    Route::get('balance-trial', 'AccbalanceController@trial')->name('balancetrial');
    Route::get('profit-loss', 'AccbalanceController@profitLoss')->name('profitloss');
    Route::get('accmutation/{id}', 'AccbalanceController@mutation')->name('accmutation');
    Route::get('acc-mutation', 'AccbalanceController@accMutation')->name('acc-mutation');

    Route::delete('cogsallocats/destroy', 'CogsAllocatsController@massDestroy')->name('cogsallocats.massDestroy');
    Route::resource('cogsallocats', 'CogsAllocatsController');

    Route::delete('accountsgroups/destroy', 'AccountsGroupController@massDestroy')->name('accountsgroups.massDestroy');
    Route::resource('accountsgroups', 'AccountsGroupController');

    // Orders
    Route::delete('orders/destroy', 'OrdersController@massDestroy')->name('orders.massDestroy');
    Route::resource('orders', 'OrdersController');

    // Ledgers
    Route::delete('ledgers/destroy', 'LedgersController@massDestroy')->name('ledgers.massDestroy');
    Route::resource('ledgers', 'LedgersController');

    // Packages
    Route::delete('packages/destroy', 'PackagesController@massDestroy')->name('packages.massDestroy');
    Route::resource('packages', 'PackagesController');

    // Productions
    Route::delete('productions/destroy', 'ProductionsController@massDestroy')->name('productions.massDestroy');
    Route::resource('productions', 'ProductionsController');

    // Customers
    Route::delete('customers/destroy', 'CustomersController@massDestroy')->name('customers.massDestroy');
    Route::resource('customers', 'CustomersController');
    Route::get('customer-unblock/{id}', 'CustomersController@unblock')->name('customers.unblock');
    Route::put('customer-unblock-process', 'CustomersController@unblockProcess')->name('customers.unblockprocess');

    // Members
    Route::delete('members/destroy', 'MembersController@massDestroy')->name('members.massDestroy');
    Route::resource('members', 'MembersController');
    Route::get('member-unblock/{id}', 'MembersController@unblock')->name('members.unblock');
    Route::put('member-unblock-process', 'MembersController@unblockProcess')->name('members.unblockprocess');

    // Topups
    Route::delete('topups/destroy', 'TopupsController@massDestroy')->name('topups.massDestroy');
    Route::resource('topups', 'TopupsController');
    Route::get('approved/{id}', 'TopupsController@approved')->name('topups.approved');
    Route::put('approvedprocess', 'TopupsController@approvedprocess')->name('topups.approvedprocess');
    Route::get('topup-cancelled/{id}', 'TopupsController@cancelled')->name('topups.cancelled');
    Route::put('topup-cancelled-process', 'TopupsController@cancelledProcess')->name('topups.cancelledprocess');

    // Network Fee
    Route::delete('fees/destroy', 'NetworkFeesController@massDestroy')->name('fees.massDestroy');
    Route::resource('fees', 'NetworkFeesController');

    // Reset
    Route::get('reset', 'ResetController@index')->name('reset');
    Route::get('reset-all', 'ResetController@resetall')->name('reset-all');

    //History points
    Route::get('history-points', 'OrderpointsController@index')->name('history-points');

    // Withdraw
    Route::delete('withdraw/destroy', 'WithdrawController@massDestroy')->name('withdraw.massDestroy');
    Route::resource('withdraw', 'WithdrawController');
    Route::get('withdraw-approved/{id}', 'WithdrawController@approved')->name('withdraw.approved');
    Route::put('withdraw-approvedprocess', 'WithdrawController@approvedprocess')->name('withdraw.approvedprocess');
    Route::post('withdraw-otp', 'WithdrawController@otpApproved')->name('withdraw.otpApproved');

    //test
    Route::get('test', 'TestController@test')->name('test.test');
    Route::get('sms-api', 'OrdersController@smsApi');

    // Sale Retur
    Route::delete('salereturs/destroy', 'SaleReturController@massDestroy')->name('salereturs.massDestroy');
    Route::resource('salereturs', 'SaleReturController');

    // Assets
    Route::delete('assets/destroy', 'AssetsController@massDestroy')->name('assets.massDestroy');
    Route::resource('assets', 'AssetsController');

    // Capitals
    Route::delete('capitals/destroy', 'CapitalsController@massDestroy')->name('capitals.massDestroy');
    Route::resource('capitals', 'CapitalsController');

    // Agents
    Route::delete('agents/destroy', 'AgentsController@massDestroy')->name('agents.massDestroy');
    Route::resource('agents', 'AgentsController');
    Route::get('agent-unblock/{id}', 'AgentsController@unblock')->name('agents.unblock');
    Route::put('agent-unblock-process', 'AgentsController@unblockProcess')->name('agents.unblockprocess');

    // Capitalists
    Route::delete('capitalists/destroy', 'CapitalistsController@massDestroy')->name('capitalists.massDestroy');
    Route::resource('capitalists', 'CapitalistsController');
    Route::get('capitalist-unblock/{id}', 'CapitalistsController@unblock')->name('capitalists.unblock');
    Route::put('capitalist-unblock-process', 'CapitalistsController@unblockProcess')->name('capitalists.unblockprocess');

    // Payables
    Route::delete('payables/destroy', 'PayablesController@massDestroy')->name('payables.massDestroy');
    Route::resource('payables', 'PayablesController');
    Route::get('payables-trs/{id}', 'PayableTrsController@indexTrs')->name('payables.indexTrs');
    Route::get('payables-trs-create/{id}', 'PayableTrsController@createTrs')->name('payables.createTrs');
    Route::post('payables-trs-store', 'PayableTrsController@storeTrs')->name('payables.storeTrs');
    Route::get('payables-trs-show/{id}', 'PayableTrsController@showTrs')->name('payables.showTrs');
    Route::get('payables-trs-edit/{id}', 'PayableTrsController@editTrs')->name('payables.editTrs');
    Route::delete('payables-trs-destroy/{id}', 'PayableTrsController@destroyTrs')->name('payables.destroyTrs');

    // Receivables
    Route::delete('receivables/destroy', 'ReceivablesController@massDestroy')->name('receivables.massDestroy');
    Route::resource('receivables', 'ReceivablesController');
    Route::get('receivables-trs/{id}', 'ReceivableTrsController@indexTrs')->name('receivables.indexTrs');
    Route::get('receivables-trs-create/{id}', 'ReceivableTrsController@createTrs')->name('receivables.createTrs');
    Route::post('receivables-trs-store', 'ReceivableTrsController@storeTrs')->name('receivables.storeTrs');
    Route::get('receivables-trs-show/{id}', 'ReceivableTrsController@showTrs')->name('receivables.showTrs');
    Route::get('receivables-trs-edit/{id}', 'ReceivableTrsController@editTrs')->name('receivables.editTrs');
    Route::delete('receivables-trs-destroy/{id}', 'ReceivableTrsController@destroyTrs')->name('receivables.destroyTrs');
    Route::get('statistik', 'StatistikController@index')->name('statistik.index');
    Route::get('statistik/product', 'StatistikController@product')->name('statistik.product');
    Route::get('statistik/member', 'StatistikController@member')->name('statistik.member');

    //order product
    Route::resource('order-product', 'OrderProductsController');

    //order package
    Route::resource('order-package', 'OrderPackagesController');

});

Route::group(['prefix' => 'admin', 'as' => 'midtrans.', 'namespace' => 'Admin'], function () {
    Route::get('midtrans/finish', 'MidtransController@finishRedirect')->name('finish');
    Route::get('midtrans/unfinish', 'MidtransController@unfinishRedirect')->name('unfinish');
    Route::get('midtrans/failed', 'MidtransController@errorRedirect')->name('error');
    Route::post('midtrans/callback', 'MidtransController@notificationHandlerTopup')->name('notifiactionTopup');
});
