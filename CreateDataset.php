<?php

require 'vendor/autoload.php';

use Google\Cloud\AutoMl\V1\AutoMlClient;
use Google\Cloud\AutoMl\V1\Dataset;
use Google\Cloud\AutoMl\V1\TranslationDatasetMetadata;

$projectId = 'mercurial-ruler-300412';
$location = 'us-central1';
$displayName = 'translate_text_test';
$sourceLanguage = 'de';
$targetLanguage = 'en';

$client = new AutoMlClient();

try {
 
    $formattedParent = $client->locationName(
        $projectId,
        $location
    );

    $metadata = (new TranslationDatasetMetadata())
        ->setSourceLanguageCode($sourceLanguage)
        ->setTargetLanguageCode($targetLanguage);
    $dataset = (new Dataset())
        ->setDisplayName($displayName)
        ->setTranslationDatasetMetadata($metadata);

    // create dataset
    $operationResponse = $client->createDataset($formattedParent, $dataset);
    $operationResponse->pollUntilComplete();
    if ($operationResponse->operationSucceeded()) {
        $result = $operationResponse->getResult();

        // display dataset information
        $splitName = explode('/', $result->getName());
        printf('Dataset name: %s' . PHP_EOL, $result->getName());
        printf('Dataset id: %s' . PHP_EOL, end($splitName));
    } else {
        $error = $operationResponse->getError();
    }
} finally {
    $client->close();
}