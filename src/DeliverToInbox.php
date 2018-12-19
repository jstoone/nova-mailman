<?php

namespace Jstoone\Mailman;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Mail\Events\MessageSent;
use Swift_Message;
use Symfony\Component\Yaml\Yaml;

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
        $this->mailboxPath = '';
    }

    public function handle(MessageSent $event): void
    {
        // Create html file
        $this->storeMailContent($event->message);
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
        $content = '---' . PHP_EOL;
        $content .= Yaml::dump([
            'recipient' => array_first(array_keys($message->getTo())),
            'subject'   => $message->getSubject(),
            'sent_at'   => (string) now(),
            'link'      => route('nova-mailman.show', $this->identifier),
        ]);
        $content .= '---' . PHP_EOL;
        $content .= $message->getBody();

        $this->files->put(
            $this->getMailPath() . '.md',
            $content
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
