<?php

namespace Jstoone\Mailman\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Routing\Controller;
use Jstoone\Mailman\MailSheet;

class MailmanController extends Controller
{
    public function index(Filesystem $filesystem)
    {
        return sheets()
            ->all()
            ->reverse()
            ->map(function (MailSheet $sheet) {
                return [
                    'id'        => $sheet->slug,
                    'recipient' => $sheet->recipient,
                    'subject'   => $sheet->subject,
                    'sent_at'   => $sheet->sent_at,
                    'link'      => $sheet->link,
                ];
            });
    }

    public function show(MailSheet $mail)
    {
        return $mail->contents;
    }

    public function destroy(Filesystem $filesystem, string $identifier)
    {
        $filesystem->delete('mailman/' . $identifier . '.md');
    }
}
