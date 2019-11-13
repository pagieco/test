<?php

namespace App\Domains\Profile\Enums;

use App\Models\Enums\Enum;

final class ProfileEventType extends Enum
{
    // Tag events...
    public const AppliedTag = 'applied-tag';
    public const RemovedTag = 'removed-tag';

    // Email events...
    public const Bounced = 'bounced';
    public const IssuedSpamComplaint = 'issued-spam-complaint';
    public const MarkedAsUndeliverable = 'marked-as-undeliverable';
    public const OpenedEmail = 'opened-email';
    public const ClickedEmailLink = 'clicked-email-link';

    // Form events...
    public const ConfirmedFormSubmission = 'confirmed-form-submission';
    public const SubmittedForm = 'submitted-form';

    // Profile events...
    public const UpdatedEmailAddress = 'updated-email-address';

    // Page events...
    public const VisitedPage = 'visited-page';
    public const ClickedPageLink = 'clicked-page-link';
}
