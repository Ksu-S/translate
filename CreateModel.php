<?php

use Google\Cloud\Translate\V3\TranslationServiceClient;

$translationServiceClient = new TranslationServiceClient();

// $modelId = '[MODEL ID]';
// $text = 'Hello, world!';
// $targetLanguage = 'fr';
// $sourceLanguage = 'en';
// $projectId = '[Google Cloud Project ID]';
// $location = 'global';
$modelPath = sprintf(
    'projects/%s/locations/%s/models/%s',
    $projectId,
    $location,
    $modelId
);
$contents = [$text];
$formattedParent = $translationServiceClient->locationName(
    $projectId,
    $location
);

$mimeType = 'text/html';

try {
    $response = $translationServiceClient->translateText(
        $contents,
        $targetLanguage,
        $formattedParent,
        [
            'model' => $modelPath,
            'sourceLanguageCode' => $sourceLanguage,
            'mimeType' => $mimeType
        ]
    );

    foreach ($response->getTranslations() as $translation) {
        printf('Translated text: %s' . PHP_EOL, $translation->getTranslatedText());
    }
} finally {
    $translationServiceClient->close();
}