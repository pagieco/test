<?php

namespace App\Domains\Profile\Enums;

use App\Models\Enums\Enum;

final class ProfileEventType extends Enum
{
    // Tag events...
    const AppliedTag = 'applied-tag';
    const RemovedTag = 'removed-tag';

    // Email events...
    const Bounced = 'bounced';
    const IssuedSpamComplaint = 'issued-spam-complaint';
    const MarkedAsUndeliverable = 'marked-as-undeliverable';
    const OpenedEmail = 'opened-email';
    const ClickedEmailLink = 'clicked-email-link';

    // Form events...
    const ConfirmedFormSubmission = 'confirmed-form-submission';
    const SubmittedForm = 'submitted-form';

    // Profile events...
    const UpdatedEmailAddress = 'updated-email-address';

    // Page events...
    const VisitedPage = 'visited-page';
    const ClickedPageLink = 'clicked-page-link';
}
