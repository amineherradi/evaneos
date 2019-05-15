<?php

require_once __DIR__ . '/../src/autoloader.php';

use Entity\Quote;
use Entity\Template;
use Faker\Factory;


$faker = Factory::create();

$template = new Template(
    1,
    '<h1>Votre voyage avec une agence locale [quote:destination_name]</h1>',
    "
    <p>Bonjour [user:first_name],</p>
	<p>
	 	Merci d'avoir contacté un agent local pour votre voyage [quote:destination_name].
		<br>Bien cordialement,
	</p>
	<p>
	 	L'équipe Evaneos.com
		<br>www.evaneos.com
	</p>
	"
);

$templateManager = new TemplateManager();

$message = $templateManager->getTemplateComputed(
    $template,
    [
        'quote' => new Quote(
        	$faker->randomNumber(), 
        	$faker->randomNumber(), 
        	$faker->randomNumber(), 
        	$faker->date()
        )
    ]
);

echo $message->subject . "\n" . $message->content;
