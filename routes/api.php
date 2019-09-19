<?php

// Asset routes...
Route::get('/assets', 'Api\Asset\GetAssetsController')->name('get-assets');
Route::get('/assets/{asset}', 'Api\Asset\GetAssetController')->name('get-asset');
Route::post('/assets', 'Api\Asset\UploadAssetController')->name('upload-asset');
Route::patch('/assets/{asset}', 'Api\Asset\UpdateAssetController')->name('update-asset');
Route::put('/assets/{asset}/move', 'Api\Asset\MoveAssetController')->name('move-asset');
Route::delete('/assets/{asset}', 'Api\Asset\DeleteAssetController')->name('delete-asset');

// Asset folder routes...
Route::get('/asset-folders', 'Api\AssetFolder\GetAssetFoldersController')->name('get-asset-folders');
Route::post('/asset-folders', 'Api\AssetFolder\CreateAssetFoldersController')->name('create-asset-folder');
Route::get('/asset-folders/{assetFolder}', 'Api\AssetFolder\GetAssetFolderController')->name('get-asset-folder');
Route::patch('/asset-folders/{assetFolder}', 'Api\AssetFolder\UpdateAssetFolderController')->name('update-asset-folder');
Route::delete('/asset-folders/{assetFolder}', 'Api\AssetFolder\DeleteAssetFolderController')->name('delete-asset-folder');

// Page routes...
Route::get('/pages', 'Api\Page\GetPagesController')->name('get-pages');
Route::get('/pages/{page}', 'Api\Page\GetPageController')->name('get-page');

// Collection routes...
Route::get('/collections', 'Api\Collection\GetCollectionsController')->name('get-collections');
Route::get('/collections/{collection}', 'Api\Collection\GetCollectionController')->name('get-collection');

// Form routes...
Route::get('/forms', 'Api\Form\GetFormsController')->name('get-forms');
Route::get('/forms/{form}', 'Api\Form\GetFormController')->name('get-form');
Route::get('/forms/{form}/submissions', 'Api\Form\GetFormSubmissionsController')->name('get-form-submissions');
Route::get('/form-submissions/{submission}', 'Api\Form\GetFormSubmissionController')->name('get-form-submission');

// Email routes...
Route::get('/emails', 'Api\Email\GetEmailsController')->name('get-emails');
Route::get('/emails/{email}', 'Api\Email\GetEmailController')->name('get-email');

// Profile routes...
Route::get('/profiles', 'Api\Profile\GetProfilesController')->name('get-profiles');
Route::get('/profiles/{profile}', 'Api\Profile\GetProfileController')->name('get-profile');
Route::get('/profiles/{profile}/events', 'Api\Profile\GetProfileEventsController')->name('get-profile-events');
Route::delete('/profiles/{profile}', 'Api\Profile\DeleteProfileController')->name('delete-profile');
Route::get('/profile-events/{event}', 'Api\Profile\GetProfileEventController')->name('get-profile-event');

// Automation routes...
Route::get('/automations', 'Api\Automation\GetAutomationsController')->name('get-automations');
Route::get('/automations/{automation}', 'Api\Automation\GetAutomationController')->name('get-automation');

// Domain routes...
Route::get('/domains', 'Api\Domain\GetDomainsController')->name('get-domains');
Route::get('/domains/{domain}', 'Api\Domain\GetDomainController')->name('get-domain');

// Workflow routes...
Route::get('/workflows', 'Api\Workflow\GetWorkflowsController')->name('get-workflows');
Route::get('/workflows/{workflow}', 'Api\Workflow\GetWorkflowController')->name('get-workflow');
