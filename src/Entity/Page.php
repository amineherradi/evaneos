<?php

namespace Entity;

class Page
{
    /** @var Site $site */
    private $site;
    /** @var Destination $destination */
    private $destination;
    /** @var Template $template */
    private $template;
    /** @var User $user */
    private $user;

    public function __construct(
        Site $site,
        Destination $destination,
        Template $template,
        User $user
    ) {

    }
}