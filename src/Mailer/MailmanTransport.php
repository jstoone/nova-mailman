<?php
namespace Jstoone\Mailman\Mailer;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Mail\Transport\Transport;
use Swift_Mime_SimpleMessage;

class MailmanTransport extends Transport
{
    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var string
     */
    protected $mailboxPath;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
        $this->mailboxPath = 'mailman';
    }

    /**
     * Store the mail safely in a mailbox, and inform Nova.
     */
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $this->beforeSendPerformed($message);

        $this->createMailbox();

        $this->files->put(
            $this->mailboxPath . '/' . $this->getMailPath($message) . '.html',
            $this->getMailContent($message)
        );
    }

    /**
     * Create the mailbox directory.
     */
    protected function createMailbox(): void
    {
        if ($this->files->exists($this->mailboxPath)) {
            return;
        }

        $this->files->makeDirectory($this->mailboxPath);
        $this->files->put($this->mailboxPath . '/.gitignore', "*\n!.gitignore");
    }

    /**
     * Get the full path to the mailbox, for the given mail message.
     */
    protected function getMailPath(Swift_Mime_SimpleMessage $message): string
    {
        $time = $message->getDate()->getTimestamp();
        $subject = $message->getSubject();
        $recipient = array_first(array_keys($message->getTo()));
        $recipient = str_replace('.', '-', $recipient);

        return implode('_', [
            $time,
            str_slug($recipient),
            str_slug($subject),
        ]);
    }

    /**
     * Get the content from the given mail message.
     */
    protected function getMailContent(Swift_Mime_SimpleMessage $message): string
    {
        return $message->getBody();
    }
}
