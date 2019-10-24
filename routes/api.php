<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Form\Http\Controllers\Api\GetFormController;
use App\Domains\Page\Http\Controllers\Api\GetPageController;
use App\Domains\Form\Http\Controllers\Api\GetFormsController;
use App\Domains\Page\Http\Controllers\Api\GetPagesController;
use App\Domains\Asset\Http\Controllers\Api\GetAssetController;
use App\Domains\Email\Http\Controllers\Api\GetEmailController;
use App\Domains\Asset\Http\Controllers\Api\GetAssetsController;
use App\Domains\Asset\Http\Controllers\Api\MoveAssetController;
use App\Domains\Email\Http\Controllers\Api\GetEmailsController;
use App\Domains\Form\Http\Controllers\Api\CreateFormController;
use App\Domains\Form\Http\Controllers\Api\DeleteFormController;
use App\Domains\Form\Http\Controllers\Api\SubmitFormController;
use App\Domains\Page\Http\Controllers\Api\CreatePageController;
use App\Domains\Page\Http\Controllers\Api\DeletePageController;
use App\Domains\Page\Http\Controllers\Api\UpdatePageController;
use App\Domains\Domain\Http\Controllers\Api\GetDomainController;
use App\Domains\Page\Http\Controllers\Api\PublishPageController;
use App\Domains\Asset\Http\Controllers\Api\DeleteAssetController;
use App\Domains\Asset\Http\Controllers\Api\UpdateAssetController;
use App\Domains\Asset\Http\Controllers\Api\UploadAssetController;
use App\Domains\Domain\Http\Controllers\Api\GetDomainsController;
use App\Domains\Email\Http\Controllers\Api\CreateEmailController;
use App\Domains\Email\Http\Controllers\Api\DeleteEmailController;
use App\Domains\Email\Http\Controllers\Api\UpdateEmailController;
use App\Domains\Profile\Http\Controllers\Api\GetProfileController;
use App\Domains\Project\Http\Controllers\Api\GetProjectController;
use App\Domains\Domain\Http\Controllers\Api\CreateDomainController;
use App\Domains\Domain\Http\Controllers\Api\DeleteDomainController;
use App\Domains\Domain\Http\Controllers\Api\UpdateDomainController;
use App\Domains\Profile\Http\Controllers\Api\GetProfilesController;
use App\Domains\User\Http\Controllers\Api\GetCurrentUserController;
use App\Domains\Asset\Http\Controllers\Api\GetAssetFolderController;
use App\Domains\Workflow\Http\Controllers\Api\GetWorkflowController;
use App\Domains\Asset\Http\Controllers\Api\GetAssetFoldersController;
use App\Domains\Profile\Http\Controllers\Api\DeleteProfileController;
use App\Domains\Profile\Http\Controllers\Api\UpdateProfileController;
use App\Domains\Project\Http\Controllers\Api\UpdateProjectController;
use App\Domains\Workflow\Http\Controllers\Api\GetWorkflowsController;
use App\Domains\Form\Http\Controllers\Api\GetFormSubmissionController;
use App\Domains\User\Http\Controllers\Api\UpdateCurrentUserController;
use App\Domains\Asset\Http\Controllers\Api\DeleteAssetFolderController;
use App\Domains\Asset\Http\Controllers\Api\UpdateAssetFolderController;
use App\Domains\Form\Http\Controllers\Api\GetFormSubmissionsController;
use App\Domains\Profile\Http\Controllers\Api\GetProfileEventController;
use App\Domains\Project\Http\Controllers\Api\SwitchToProjectController;
use App\Domains\Workflow\Http\Controllers\Api\CreateWorkflowController;
use App\Domains\Workflow\Http\Controllers\Api\DeleteWorkflowController;
use App\Domains\Asset\Http\Controllers\Api\CreateAssetFoldersController;
use App\Domains\Automation\Http\Controllers\Api\GetAutomationController;
use App\Domains\Collection\Http\Controllers\Api\GetCollectionController;
use App\Domains\Profile\Http\Controllers\Api\GetProfileEventsController;
use App\Domains\Automation\Http\Controllers\Api\GetAutomationsController;
use App\Domains\Collection\Http\Controllers\Api\GetCollectionsController;
use App\Domains\Profile\Http\Controllers\Api\TrackProfileEventController;
use App\Domains\User\Http\Controllers\Api\UploadProfilePictureController;
use App\Domains\Automation\Http\Controllers\Api\DeleteAutomationController;
use App\Domains\Collection\Http\Controllers\Api\CreateCollectionController;
use App\Domains\Collection\Http\Controllers\Api\DeleteCollectionController;
use App\Domains\Collection\Http\Controllers\Api\UpdateCollectionController;
use App\Domains\Profile\Http\Controllers\Api\ConfirmProfileConsentController;
use App\Domains\Collection\Http\Controllers\Api\GetCollectionEntriesController;
use App\Domains\Collection\Http\Controllers\Api\CreateCollectionEntryController;
use App\Domains\Collection\Http\Controllers\Api\DeleteCollectionEntryController;
use App\Domains\Collection\Http\Controllers\Api\UpdateCollectionEntryController;

// User routes...
Route::get('/current-user', GetCurrentUserController::class)->name('get-current-user');
Route::patch('/current-user', UpdateCurrentUserController::class)->name('update-current-user');
Route::put('/current-user/profile-picture', UploadProfilePictureController::class)->name('upload-profile-picture');

// Project routes...
Route::get('/projects/{project}', GetProjectController::class)->name('get-project');
Route::patch('/projects/{project}', UpdateProjectController::class)->name('update-project');
Route::post('/projects/{project}/switch', SwitchToProjectController::class)->name('switch-to-project');

// Asset routes...
Route::get('/assets', GetAssetsController::class)->name('get-assets');
Route::get('/assets/{asset}', GetAssetController::class)->name('get-asset');
Route::post('/assets', UploadAssetController::class)->name('upload-asset');
Route::patch('/assets/{asset}', UpdateAssetController::class)->name('update-asset');
Route::put('/assets/{asset}/move', MoveAssetController::class)->name('move-asset');
Route::delete('/assets/{asset}', DeleteAssetController::class)->name('delete-asset');

// Asset folder routes...
Route::get('/asset-folders', GetAssetFoldersController::class)->name('get-asset-folders');
Route::post('/asset-folders', CreateAssetFoldersController::class)->name('create-asset-folder');
Route::get('/asset-folders/{assetFolder}', GetAssetFolderController::class)->name('get-asset-folder');
Route::patch('/asset-folders/{assetFolder}', UpdateAssetFolderController::class)->name('update-asset-folder');
Route::delete('/asset-folders/{assetFolder}', DeleteAssetFolderController::class)->name('delete-asset-folder');

// Page routes...
Route::get('/pages', GetPagesController::class)->name('get-pages');
Route::post('/pages', CreatePageController::class)->name('create-page');
Route::get('/pages/{page}', GetPageController::class)->name('get-page');
Route::post('/pages/{page}/publish', PublishPageController::class)->name('publish-page');
Route::patch('/pages/{page}', UpdatePageController::class)->name('update-page');
Route::delete('/pages/{page}', DeletePageController::class)->name('delete-page');

// Collection routes...
Route::get('/collections', GetCollectionsController::class)->name('get-collections');
Route::post('/collections', CreateCollectionController::class)->name('create-collection');
Route::patch('/collections/{collection}', UpdateCollectionController::class)->name('update-collection');
Route::delete('/collections/{collection}', DeleteCollectionController::class)->name('delete-collection');
Route::get('/collections/{collection}', GetCollectionController::class)->name('get-collection');
Route::post('/collections/{collection}', CreateCollectionEntryController::class)->name('create-collection-entry');
Route::get('/collections/{collection}/entries', GetCollectionEntriesController::class)->name('get-collection-entries');
Route::patch('/collection-entries/{entry}', UpdateCollectionEntryController::class)->name('update-collection-entry');
Route::delete('/collection-entries/{entry}', DeleteCollectionEntryController::class)->name('delete-collection-entry');

// Form routes...
Route::get('/forms', GetFormsController::class)->name('get-forms');
Route::post('/forms', CreateFormController::class)->name('create-form');
Route::get('/forms/{form}', GetFormController::class)->name('get-form');
Route::post('/forms/{form}', SubmitFormController::class)->name('submit-form');
Route::delete('/forms/{form}', DeleteFormController::class)->name('delete-form');
Route::get('/forms/{form}/submissions', GetFormSubmissionsController::class)->name('get-form-submissions');
Route::get('/form-submissions/{submission}', GetFormSubmissionController::class)->name('get-form-submission');

// Email routes...
Route::get('/emails', GetEmailsController::class)->name('get-emails');
Route::post('/emails', CreateEmailController::class)->name('create-email');
Route::get('/emails/{email}', GetEmailController::class)->name('get-email');
Route::patch('/emails/{email}', UpdateEmailController::class)->name('update-email');
Route::delete('/emails/{email}', DeleteEmailController::class)->name('delete-email');

// Profile routes...
Route::get('/profiles', GetProfilesController::class)->name('get-profiles');
Route::get('/profiles/{profile}', GetProfileController::class)->name('get-profile');
Route::get('/profiles/{profile}/confirm-consent', ConfirmProfileConsentController::class)->name('confirm-profile-consent');
Route::patch('/profiles/{profile}', UpdateProfileController::class)->name('update-profile');
Route::post('/profiles/{profile}', TrackProfileEventController::class)->name('track-profile-event');
Route::delete('/profiles/{profile}', DeleteProfileController::class)->name('delete-profile');
Route::get('/profiles/{profile}/events', GetProfileEventsController::class)->name('get-profile-events');
Route::get('/profile-events/{event}', GetProfileEventController::class)->name('get-profile-event');

// Automation routes...
Route::get('/automations', GetAutomationsController::class)->name('get-automations');
Route::get('/automations/{automation}', GetAutomationController::class)->name('get-automation');
Route::delete('/automations/{automation}', DeleteAutomationController::class)->name('delete-automation');

// Domain routes...
Route::get('/domains', GetDomainsController::class)->name('get-domains');
Route::post('/domains', CreateDomainController::class)->name('create-domain');
Route::get('/domains/{domain}', GetDomainController::class)->name('get-domain');
Route::patch('/domains/{domain}', UpdateDomainController::class)->name('update-domain');
Route::delete('/domains/{domain}', DeleteDomainController::class)->name('delete-domain');

// Workflow routes...
Route::get('/workflows', GetWorkflowsController::class)->name('get-workflows');
Route::post('/workflows', CreateWorkflowController::class)->name('create-workflows');
Route::get('/workflows/{workflow}', GetWorkflowController::class)->name('get-workflow');
Route::delete('/workflows/{workflow}', DeleteWorkflowController::class)->name('delete-workflow');
