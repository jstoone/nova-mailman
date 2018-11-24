<?php

namespace Jstoone\Mailman\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Routing\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class MailmanController extends Controller
{
    public function index(Filesystem $filesystem)
    {
        if (!$filesystem->exists('mailman')) {
            return [];
        }

        $files = (new Finder)
            ->in($filesystem->path('mailman'))
            ->name('*.json')
            ->ignoreDotFiles(true)
            ->files();

        return collect(iterator_to_array($files))
            ->map(function (SplFileInfo $resource) {
                $file = json_decode(file_get_contents($resource));

                return [
                    'identifier' => $file->identifier,
                    'recipient'  => $file->recipient,
                    'subject'    => $file->subject,
                    'sent_at'    => $file->sent_at,
                ];
            })->sortBy('sent_at')->values();
    }

    public function show(Filesystem $filesystem, string $identifier)
    {
        return view("nova-mailman-mails::$identifier");
    }
}
