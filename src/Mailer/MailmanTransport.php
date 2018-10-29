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

        // Create html file
        $this->files->put(
            $this->getMailPath($message) . '.html',
            $this->getMailContent($message)
        );

        // Create json file
        $this->files->put(
            $this->getMailPath($message) . '.json',
            $this->getMailMetadata($message)
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
        return $this->mailboxPath . '/' . time();
    }

    /**
     * Get the content from the given mail message.
     */
    protected function getMailContent(Swift_Mime_SimpleMessage $message): string
    {
        return $message->getBody();
    }

    /**
     * Get the metadata for the given mail message.
     */
    protected function getMailMetadata(Swift_Mime_SimpleMessage $message): string
    {
        return json_encode([
            'recipient' => array_first(array_keys($message->getTo())),
            'subject'   => $message->getSubject(),
            'sent_at'   => time(),
            'content'   => $this->getMailPath($message) . '.html',
        ], JSON_PRETTY_PRINT);
    }
}
