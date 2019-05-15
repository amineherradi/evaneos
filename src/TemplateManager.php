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

            $containsDestinationLink = strpos($text, '[quote:destination_link]');
            $containsDestinationName = strpos($text, '[quote:destination_name]');
            $containsSummaryHtml     = strpos($text, '[quote:summary_html]');
            $containsSummary         = strpos($text, '[quote:summary]');
            $containsDate            = strpos($text, '[quote:date]');

            if($containsDestinationLink){
                $destination = DestinationRepository::getInstance()->getById($quote->destinationId);
            }
            if ($containsSummaryHtml) {
                $text = str_replace('[quote:summary_html]', Quote::renderHtml($quote), $text);
            }
            if ($containsSummary) {
                $text = str_replace('[quote:summary]', Quote::renderText($quote), $text);
            }
            if ($containsDestinationName) {
                $text = str_replace('[quote:destination_name]', $destination->countryName, $text);
            }
            if ($containsDate) {
                $text = str_replace('[quote:date]', $quote->dateQuoted, $text);
            }
            if ($destination) {
                $text = str_replace('[quote:destination_link]', $site->url . '/' . $destination->countryName . '/quote/' . $quote->id, $text);
            } else {
                $text = str_replace('[quote:destination_link]', '', $text);
            }

            if ($user) {
                $containsFirstName = strpos($text, '[user:first_name]');
                $containsLastName  = strpos($text, '[user:last_name]');

                if ($containsFirstName) {
                    $text = str_replace('[user:first_name]', ucfirst(mb_strtolower($user->firstname)), $text);
                }
                if ($containsLastName) {
                    $text = str_replace('[user:last_name]', ucfirst(mb_strtolower($user->lastname)), $text);
                }
            }
        }

        return $text;
    }
}
