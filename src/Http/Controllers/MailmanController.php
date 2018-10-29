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
        $path = $filesystem->path('mailman');

        $files = (new Finder)->in($path)
            ->name('*.json')
            ->ignoreDotFiles(true)
            ->files();

        return collect(iterator_to_array($files))
            ->map(function (SplFileInfo $resource) {
                $file = json_decode(file_get_contents($resource));

                return [
                    'recipient' => $file->recipient,
                    'subject'   => $file->subject,
                    'sent_at'   => $file->sent_at,
                    'content'   => asset($file->content),
                ];
            })->values();
    }
}
