<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('effect', 'EffectCrudController');
    Route::crud('action', 'ActionCrudController');
    Route::crud('indicator', 'IndicatorCrudController');
    Route::crud('indicatorstatus', 'IndicatorStatusCrudController');
    Route::crud('indicatorvalue', 'IndicatorValueCrudController');
    Route::crud('team', 'TeamCrudController');
    Route::crud('user', 'UserCrudController');
    Route::crud('evidence', 'EvidenceCrudController');
    Route::crud('beneficiary', 'BeneficiaryCrudController');
    Route::crud('beneficiarytype', 'BeneficiaryTypeCrudController');
    Route::crud('product', 'ProductCrudController');
    Route::crud('aim', 'AimCrudController');
    Route::crud('ipflow', 'IpflowCrudController');
    Route::crud('scope', 'ScopeCrudController');
    Route::crud('geoboundary', 'GeoBoundaryCrudController');
    Route::crud('csaframework', 'CsaFrameworkCrudController');
    Route::crud('subactivity', 'SubactivityCrudController');
    Route::crud('activity', 'ActivityCrudController');
    Route::crud('output', 'OutputCrudController');
}); // this should be the absolute last line of this file