<?php

namespace Jstoone\Mailman;

use Illuminate\Support\Carbon;
use Illuminate\Support\HtmlString;
use Spatie\Sheets\Sheet;

class MailSheet extends Sheet
{
    /** @var string */
    public $slug;

    /** @var string */
    public $recipient;

    /** @var string */
    public $subject;

    /** @var Carbon */
    public $sent_at;

    /** @var string */
    public $link;

    /** @var HtmlString */
    public $contents;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->slug = data_get($attributes, 'slug');
        $this->recipient = data_get($attributes, 'recipient');
        $this->subject = data_get($attributes, 'subject');
        $this->sent_at = data_get($attributes, 'sent_at');
        $this->link = data_get($attributes, 'link');
        $this->contents = data_get($attributes, 'contents');
    }
}
