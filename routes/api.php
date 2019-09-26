<?php

use Illuminate\Support\Facades\Route;

// User routes...
Route::get('/current-user', 'Api\User\GetCurrentUserController')->name('get-current-user');
Route::patch('/current-user', 'Api\User\UpdateCurrentUserController')->name('update-current-user');
Route::put('/current-user/profile-picture', 'Api\User\UploadProfilePictureController')->name('upload-profile-picture');

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
Route::post('/pages', 'Api\Page\CreatePageController')->name('create-page');
Route::get('/pages/{page}', 'Api\Page\GetPageController')->name('get-page');
Route::patch('/pages/{page}', 'Api\Page\UpdatePageController')->name('update-page');
Route::delete('/pages/{page}', 'Api\Page\DeletePageController')->name('delete-page');

// Collection routes...
Route::get('/collections', 'Api\Collection\GetCollectionsController')->name('get-collections');
Route::post('/collections', 'Api\Collection\CreateCollectionController')->name('create-collection');
Route::get('/collections/{collection}', 'Api\Collection\GetCollectionController')->name('get-collection');
Route::post('/collections/{collection}', 'Api\Collection\CreateCollectionEntryController')->name('create-collection-entry');

// Form routes...
Route::get('/forms', 'Api\Form\GetFormsController')->name('get-forms');
Route::post('/forms', 'Api\Form\CreateFormController')->name('create-form');
Route::get('/forms/{form}', 'Api\Form\GetFormController')->name('get-form');
Route::get('/forms/{form}/submissions', 'Api\Form\GetFormSubmissionsController')->name('get-form-submissions');
Route::get('/form-submissions/{submission}', 'Api\Form\GetFormSubmissionController')->name('get-form-submission');

// Email routes...
Route::get('/emails', 'Api\Email\GetEmailsController')->name('get-emails');
Route::post('/emails', 'Api\Email\CreateEmailController')->name('create-email');
Route::get('/emails/{email}', 'Api\Email\GetEmailController')->name('get-email');
Route::patch('/emails/{email}', 'Api\Email\UpdateEmailController')->name('update-email');
Route::delete('/emails/{email}', 'Api\Email\DeleteEmailController')->name('delete-email');

// Profile routes...
Route::get('/profiles', 'Api\Profile\GetProfilesController')->name('get-profiles');
Route::get('/profiles/{profile}', 'Api\Profile\GetProfileController')->name('get-profile');
Route::delete('/profiles/{profile}', 'Api\Profile\DeleteProfileController')->name('delete-profile');
Route::get('/profiles/{profile}/events', 'Api\Profile\GetProfileEventsController')->name('get-profile-events');
Route::get('/profile-events/{event}', 'Api\Profile\GetProfileEventController')->name('get-profile-event');

// Automation routes...
Route::get('/automations', 'Api\Automation\GetAutomationsController')->name('get-automations');
Route::get('/automations/{automation}', 'Api\Automation\GetAutomationController')->name('get-automation');

// Domain routes...
Route::get('/domains', 'Api\Domain\GetDomainsController')->name('get-domains');
Route::get('/domains/{domain}', 'Api\Domain\GetDomainController')->name('get-domain');
Route::patch('/domains/{domain}', 'Api\Domain\UpdateDomainController')->name('update-domain');

// Workflow routes...
Route::get('/workflows', 'Api\Workflow\GetWorkflowsController')->name('get-workflows');
Route::post('/workflows', 'Api\Workflow\CreateWorkflowController')->name('create-workflows');
Route::get('/workflows/{workflow}', 'Api\Workflow\GetWorkflowController')->name('get-workflow');
Route::delete('/workflows/{workflow}', 'Api\Workflow\DeleteWorkflowController')->name('delete-workflow');
