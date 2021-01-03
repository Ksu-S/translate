<?php

require '../vendor/autoload.php';

use Google\Cloud\Translate\V3\TranslationServiceClient;

$translationServiceClient = new TranslationServiceClient();

$username = $_POST['text'];
// $text = 'Hello, world!';
$targetLanguage = 'fr';
$projectId = 'AIzaSyC8WSQX5pjS41THP_YfG5fvvAY66DvOhw4';
$contents = [$text];
$formattedParent = $translationServiceClient->locationName($projectId, 'global');

try {
    $response = $translationServiceClient->translateText(
        $contents,
        $targetLanguage,
        $formattedParent
    );
    foreach ($response->getTranslations() as $translation) {
        printf('Translated text: %s' . PHP_EOL, $translation->getTranslatedText());
    }
} finally {
    $translationServiceClient->close();
}