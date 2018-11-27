<?php

namespace Jstoone\Mailman;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Mail\Events\MessageSent;
use Swift_Message;

class DeliverToInbox
{
    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $mailboxPath;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
        $this->identifier = MailIdentifier::generate();
        $this->mailboxPath = 'mailman';
    }

    public function handle(MessageSent $event): void
    {
        $this->createMailbox();

        // Create html file
        $this->storeMailContent($event->message);

        // Create json file
        $this->storeMailMetadata($event->message);
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
    protected function getMailPath(): string
    {
        return $this->mailboxPath . '/' . $this->identifier;
    }

    /**
     * Get the content from the given mail message.
     */
    protected function storeMailContent(Swift_Message $message): void
    {
        $this->files->put(
            $this->getMailPath() . '.blade.php',
            $message->getBody()
        );
    }

    /**
     * Get the metadata for the given mail message.
     */
    protected function storeMailMetadata(Swift_Message $message): void
    {
        $this->files->put(
            $this->getMailPath() . '.json',
            $this->getMetadata($message)
        );
    }

    protected function getMetadata(Swift_Message $message): string
    {
        return json_encode([
            'id'        => $this->identifier,
            'recipient' => array_first(array_keys($message->getTo())),
            'subject'   => $message->getSubject(),
            'sent_at'   => (string) now(),
            'link'      => route('nova-mailman.show', $this->identifier),
        ], JSON_PRETTY_PRINT) ?: '';
    }
}
