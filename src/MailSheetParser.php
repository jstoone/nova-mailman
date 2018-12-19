<?php

namespace Jstoone\Mailman;

use League\CommonMark\CommonMarkConverter;
use Spatie\Sheets\ContentParser;
use Spatie\Sheets\ContentParsers\MarkdownWithFrontMatterParser;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class MailSheetParser implements ContentParser
{
    public function parse(string $contents): array
    {
        $document = YamlFrontMatter::parse($contents);

        return array_merge(
            $document->matter(),
            ['contents' => trim($document->body())]
        );
    }
}
