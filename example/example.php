<?php

require_once __DIR__ . '/../src/autoloader.php';

use Entity\Quote;
use Entity\Template;
use Faker\Factory;

$faker = Factory::create();

$template = new Template(
    1,
    '<h1>Un super titre</h1>',
    "
        [quote:destination_name]<br>
        [user:first_name]<br>
        [user:last_name]<br>
		[quote:destination_link]<br>
		[quote:summary]<br> 
		[quote:summary_html]<br>
		[quote:date]
	"
);

$templateManager = new TemplateManager();
$quote = new Quote(
    $faker->randomNumber(),
    $faker->randomNumber(),
    $faker->randomNumber(),
    $faker->randomNumber(),
    $faker->date()
);
$message = $templateManager->getTemplateComputed($template, $quote);

echo $message->subject . "\n" . $message->content;
