<?php

use Entity\Quote;
use Entity\Template;
use Repository\DestinationRepository;
use Repository\SiteRepository;
use Repository\UserRepository;

class TemplateManager
{
    /**
     * @param Template $tpl
     * @param Quote $data
     * @return Template
     */
    public function getTemplateComputed(Template $tpl, Quote $data = null)
    {
        if (!$tpl) {
            throw new RuntimeException('no tpl given');
        }

        if (!$data) {
            throw new RuntimeException('no data given');
        }

        $tpl->subject = $this->computeText($tpl->subject, $data);
        $tpl->content = $this->computeText($tpl->content, $data);

        return $tpl;
    }

    /**
     * @param $text
     * @param Quote|null $data
     * @return mixed
     */
    private function computeText($text, Quote $data = null)
    {
        /*
         * QUOTE
         * [quote:*]
         */
        $quote = (
            isset($data) &&
            $data instanceof Quote
        ) ? $data : null;

        if (isset($quote)) {
            $site        = SiteRepository::getInstance()->getById($quote->siteId);
            $destination = DestinationRepository::getInstance()->getById($quote->destinationId);
            $user        = UserRepository::getInstance()->getById($quote->userId);

            $content = $site->url.'/'.$destination->countryName.'/quote/'.$quote->id;
            $text = str_replace('[quote:destination_link]', $content, $text);
            $text = str_replace('[quote:destination_name]', $destination->countryName, $text);
            $text = str_replace('[quote:summary_html]', Quote::renderHtml($quote), $text);
            $text = str_replace('[quote:summary]', Quote::renderText($quote), $text);
            $text = str_replace('[quote:date]', $quote->dateQuoted, $text);
            $text = str_replace('[user:first_name]', ucfirst(mb_strtolower($user->firstname)), $text);
            $text = str_replace('[user:last_name]', ucfirst(mb_strtolower($user->lastname)), $text);
        }

        return $text;
    }
}
