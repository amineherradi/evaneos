<?php

namespace Entity;

class Quote
{
    public $id;
    public $siteId;
    public $destinationId;
    public $userId;
    public $dateQuoted;

    public function __construct($id, $siteId, $destinationId, $userId, $dateQuoted)
    {
        $this->id            = $id;
        $this->siteId        = $siteId;
        $this->destinationId = $destinationId;
        $this->userId        = $userId;
        $this->dateQuoted    = $dateQuoted;
    }

    public static function renderHtml(Quote $quote)
    {
        return '<p>' . $quote->id . '</p>';
    }

    public static function renderText(Quote $quote)
    {
        return (string) $quote->id;
    }
}