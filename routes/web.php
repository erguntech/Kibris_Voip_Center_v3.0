<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ActivityLogsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\DataManagementController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeLogsController;
use App\Http\Controllers\PaymentPeriodController;
use App\Http\Controllers\PaymentOrderController;
use App\Http\Controllers\CallCenterClientController;
use App\Http\Controllers\MyInvoicesController;
use App\Http\Controllers\CompanyDetailController;
use App\Http\Controllers\MyNumbersController;
use App\Http\Controllers\MyExtensionsController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CallOrderController;
use App\Http\Controllers\CallOrderCommentController;
use App\Http\Controllers\SandboxController;
use App\Http\Controllers\CallOrderSmsController;
use App\Http\Controllers\CallOrderDescriptionsController;
use App\Http\Controllers\SMSCreditController;
use App\Http\Controllers\SMSDeviceController;
use App\Http\Controllers\ClientModuleSelectionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ServiceFeeController;
use App\Http\Controllers\OrganizationChartController;
use App\Http\Controllers\ClientExtensionSelectionController;
use App\Http\Controllers\AsteriskManagementController;

// LanguageController Start
Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');
// LanguageController End

Route::group(['middleware' => ['auth', 'auth.timeout']], function () {
    Route::get('/authentication/account/deactivated', [StatusController::class, 'userDeactivated'])->name('UserDeactivated');
    Route::get('/authentication/module/deactivated', [StatusController::class, 'moduleDeactivated'])->name('ModuleDeactivated');

    Route::group(['middleware' => ['status.active', 'client.active']], function () {
        // DashboardController Start
        Route::get('/', [DashboardController::class, 'index'])->name('Dashboard.Index');
        // DashboardController End

        // UserController Start
        Route::resource('users', UserController::class, [
            'names' => ['index' => 'Users.Index', 'create' => 'Users.Create', 'store' => 'Users.Store', 'edit' => 'Users.Edit', 'update' => 'Users.Update', 'destroy' => 'Users.Destroy']
        ]);
        Route::post('/ajax/users', [UserController::class, 'getUserNameData'])->name('Users.GetUserNameData');
        // UserController End

        // RoleController Start
        Route::resource('roles', RoleController::class, [
            'names' => ['index' => 'Roles.Index', 'create' => 'Roles.Create', 'store' => 'Roles.Store', 'edit' => 'Roles.Edit', 'update' => 'Roles.Update', 'destroy' => 'Roles.Destroy']
        ]);
        // RoleController End

        // PermissionController Start
        Route::resource('permissions', PermissionController::class, [
            'names' => ['index' => 'Permissions.Index', 'create' => 'Permissions.Create', 'store' => 'Permissions.Store', 'edit' => 'Permissions.Edit', 'update' => 'Permissions.Update', 'destroy' => 'Permissions.Destroy']
        ]);
        // PermissionController End

        // ActivityLogsController Start
        Route::get('/activitylogs', [ActivityLogsController::class, 'index'])->name('ActivityLogs.Index');
        Route::post('/ajax/activitylogs', [ActivityLogsController::class, 'showLogData'])->name('ActivityLogs.ShowLogData');
        // ActivityLogsController End

        // SettingsController Start
        Route::get('/systemsettings', [SettingsController::class, 'systemSettings'])->name('SystemSettings.Index');
        Route::post('/systemsettings', [SettingsController::class, 'systemSettingsUpdate'])->name('SystemSettings.Update');
        Route::get('/generalsettings', [SettingsController::class, 'generalSettings'])->name('GeneralSettings.Index');
        Route::post('/generalsettings', [SettingsController::class, 'generalSettingsUpdate'])->name('GeneralSettings.Update');
        // SettingsController End

        // ClientController Start
        Route::resource('clients', ClientController::class, [
            'names' => ['index' => 'Clients.Index', 'create' => 'Clients.Create', 'store' => 'Clients.Store', 'edit' => 'Clients.Edit', 'update' => 'Clients.Update', 'destroy' => 'Clients.Destroy']
        ]);
        // ClientController End

        // AsteriskManagementController Start
        Route::post('/ajax/getassignedextensions', [AsteriskManagementController::class, 'getAssignedExtensions'])->name('Asterisk.GetAssignedExtensions');
        Route::post('/ajax/getemptyextensions', [AsteriskManagementController::class, 'getEmptyExtensions'])->name('Asterisk.GetEmptyExtensions');
        Route::post('/ajax/getextensionstatus', [AsteriskManagementController::class, 'getExtensionStatus'])->name('Asterisk.GetExtensionStatus');
        Route::post('/ajax/getcallrecording', [AsteriskManagementController::class, 'getCallRecording'])->name('CallOrders.GetCallRecording');
        Route::post('/ajax/removecallrecording', [AsteriskManagementController::class, 'removeCallRecording'])->name('Asterisk.RemoveCallRecording');
        Route::post('/ajax/startcall', [AsteriskManagementController::class, 'startCall'])->name('Asterisk.StartCall');
        // AsteriskManagementController End

        // ClientModuleSelectionController Start
        Route::get('/clients/{id}/moduleselection', [ClientModuleSelectionController::class, 'index'])->name('Clients.ModuleSelection.Index');
        Route::post('/clients/{id}/moduleselection', [ClientModuleSelectionController::class, 'update'])->name('Clients.ModuleSelection.Update');
        // ClientModuleSelectionController End

        // ClientExtensionSelectionController Start
        Route::get('/clients/{id}/extensionselection', [ClientExtensionSelectionController::class, 'index'])->name('Clients.ExtensionSelection.Index');
        Route::post('/clients/{id}/extensionselection', [ClientExtensionSelectionController::class, 'update'])->name('Clients.ExtensionSelection.Update');
        // ClientExtensionSelectionController End

        // EmployeeController Start
        Route::resource('employees', EmployeeController::class, [
            'names' => ['index' => 'Employees.Index', 'create' => 'Employees.Create', 'store' => 'Employees.Store', 'edit' => 'Employees.Edit', 'update' => 'Employees.Update', 'destroy' => 'Employees.Destroy']
        ]);
        // EmployeeController End

        // EmployeeLogsController Start
        Route::get('/employeelogs', [EmployeeLogsController::class, 'index'])->name('EmployeeLogs.Index');
        Route::post('/ajax/employeelogs', [EmployeeLogsController::class, 'showLogData'])->name('EmployeeLogs.ShowLogData');
        // EmployeeLogsController End

        // OrganizationChartController Start
        Route::get('/organizationchart', [OrganizationChartController::class, 'index'])->name('OrganizationCharts.Index');
        // OrganizationChartController End

        // SMSCreditController Start
        Route::get('/smscredits', [SMSCreditController::class, 'index'])->name('SMSCredits.Index');
        Route::post('/ajax/clientsmscredits', [SMSCreditController::class, 'assignCreditsToClient'])->name('SMSCredits.AssignCreditsToClient');
        Route::post('/ajax/devicesmscredits', [SMSCreditController::class, 'assignCreditsToDevice'])->name('SMSCredits.AssignCreditsToDevice');
        // SMSCreditController End

        // SMSDeviceController Start
        Route::resource('smsdevices', SMSDeviceController::class, [
            'names' => ['index' => 'SMSDevices.Index', 'create' => 'SMSDevices.Create', 'store' => 'SMSDevices.Store', 'edit' => 'SMSDevices.Edit', 'update' => 'SMSDevices.Update', 'destroy' => 'SMSDevices.Destroy']
        ]);
        // SMSDeviceController End

        // ExtensionController Start
        Route::resource('extensions', ExtensionController::class, [
            'names' => ['index' => 'Extensions.Index', 'create' => 'Extensions.Create', 'store' => 'Extensions.Store', 'edit' => 'Extensions.Edit', 'update' => 'Extensions.Update', 'destroy' => 'Extensions.Destroy']
        ]);
        // ExtensionController End

        // CallCenterClientController Start
        Route::resource('callcenterclients', CallCenterClientController::class, [
            'names' => ['index' => 'CallCenterClients.Index', 'create' => 'CallCenterClients.Create', 'store' => 'CallCenterClients.Store', 'edit' => 'CallCenterClients.Edit', 'update' => 'CallCenterClients.Update', 'destroy' => 'CallCenterClients.Destroy']
        ]);
        // CallCenterClientController End

        // PaymentPeriodController Start
        Route::resource('paymentperiods', PaymentPeriodController::class, [
            'names' => ['index' => 'PaymentPeriods.Index', 'create' => 'PaymentPeriods.Create', 'store' => 'PaymentPeriods.Store', 'edit' => 'PaymentPeriods.Edit', 'update' => 'PaymentPeriods.Update', 'destroy' => 'PaymentPeriods.Destroy']
        ]);
        // PaymentPeriodController End

        // AnnouncementController Start
        Route::resource('announcements', AnnouncementController::class, [
            'names' => ['index' => 'Announcements.Index', 'create' => 'Announcements.Create', 'store' => 'Announcements.Store', 'edit' => 'Announcements.Edit', 'update' => 'Announcements.Update', 'destroy' => 'Announcements.Destroy']
        ]);
        Route::get('/myannouncements', [AnnouncementController::class, 'myAnnouncements'])->name('MyAnnouncements.Index');
        // AnnouncementController End

        // CompanyDetailController Start
        Route::get('/companydetails', [CompanyDetailController::class, 'companyDetails'])->name('CompanyDetails.Index');
        Route::post('/companydetails', [CompanyDetailController::class, 'companyDetailsUpdate'])->name('CompanyDetails.Update');
        // CompanyDetailController End

        // ServiceFeeController Start
        Route::get('/servicefees', [ServiceFeeController::class, 'index'])->name('ServiceFees.Index');
        Route::post('/servicefees', [ServiceFeeController::class, 'serviceFeesUpdate'])->name('ServiceFees.Update');
        // ServiceFeeController End

        // PaymentOrderController Start
        Route::resource('paymentorders', PaymentOrderController::class, [
            'names' => ['index' => 'PaymentOrders.Index', 'create' => 'PaymentOrders.Create', 'store' => 'PaymentOrders.Store', 'edit' => 'PaymentOrders.Edit', 'update' => 'PaymentOrders.Update', 'destroy' => 'PaymentOrders.Destroy']
        ]);
        Route::post('/paymentorders/{id}', [PaymentOrderController::class, 'approvePayment'])->name('PaymentOrders.ApprovePayment');
        // PaymentOrderController End

        // MyInvoicesController Start
        Route::get('/myinvoices', [MyInvoicesController::class, 'index'])->name('MyInvoices.Index');
        Route::get('/myinvoices/{id}', [MyInvoicesController::class, 'showInvoiceDetail'])->name('MyInvoices.Detail');
        // MyInvoicesController End

        // DataManagementController Start
        Route::get('/datamanagement', [DataManagementController::class, 'index'])->name('DataManagement.Index');
        Route::get('/datamanagement/template', [DataManagementController::class, 'downloadExcelTemplate'])->name('DataManagement.DownloadExcelTemplate');
        Route::post('/datamanagement/import', [DataManagementController::class, 'readExcelData'])->name('DataManagement.ImportExcelData');
        Route::post('/datamanagement/clientcount', [DataManagementController::class, 'getClientCount'])->name('DataManagement.GetClientCount');
        Route::post('/assigncallcenterclient', [DataManagementController::class, 'assignCallCenterClient'])->name('DataManagement.AssignCallCenterClient');
        Route::get('/datadistribution', [DataManagementController::class, 'dataDistribution'])->name('DataDistribution.Index');
        Route::post('/ajax/datadistribution', [DataManagementController::class, 'autoAssign'])->name('DataDistribution.AutoAssign');
        // DataManagementController End

        // CallOrderController Start
        Route::get('/callorders', [CallOrderController::class, 'index'])->name('CallOrders.Index');
        Route::post('/ajax/callorderdetails', [CallOrderController::class, 'getDetails'])->name('CallOrders.GetDetails');
        Route::get('/callorderdetails/{id}', [CallOrderController::class, 'details'])->name('CallOrders.Details');
        // CallOrderController End

        // CallOrderDescriptionsController Start
        Route::get('/callorderdescriptions', [CallOrderDescriptionsController::class, 'index'])->name('CallOrderDescriptions.Index');
        // CallOrderDescriptionsController End

        // CallOrderCommentController Start
        Route::post('/callordercomment', [CallOrderCommentController::class, 'postComment'])->name('CallOrderComments.PostComment');
        // CallOrderCommentController End

        // CallOrderSmsController Start
        Route::post('/callordersms', [CallOrderSmsController::class, 'postSMS'])->name('CallOrderSMS.PostSMS');
        // CallOrderSmsController End

        // MyNumbers Start
        Route::get('/mynumbers', [MyNumbersController::class, 'index'])->name('MyNumbers.Index');
        // MyNumbers End

        // MyExtensions Start
        Route::get('/myextensions', [MyExtensionsController::class, 'index'])->name('MyExtensions.Index');
        // MyExtensions End

        // ContactController Start
        Route::get('/contact', [ContactController::class, 'index'])->name('Contact.Index');
        Route::post('/contact', [ContactController::class, 'sendMessage'])->name('Contact.SendMessage');
        // MyExtensions End

        // SandboxController Start
        Route::get('/issabell', [SandboxController::class, 'sandboxIssabel'])->name('Sandbox.Issabel');
        Route::get('/fetchdata', [SandboxController::class, 'fetchData'])->name('Sandbox.FetchData');
        // SandboxController End
    });
});
