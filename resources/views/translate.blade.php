<?php

require '../vendor/autoload.php';
putenv('GOOGLE_APPLICATION_CREDENTIALS=../mercurial-ruler-300412-afdb2b91bb57.json');

use Google\Cloud\Translate\V3\TranslationServiceClient;

$translationServiceClient = new TranslationServiceClient();

?>

<form action="/" method="post">
  Write text
  <input type="text" name="translate" maxlength="50" />

  Please choose language
  <select name="targetLanguage">
     <option value="">Select...</option>
     <option value="de">de</option>
     <option value="ru">ru</option>
  </select>

<input type="submit" value="Submit" name="formSubmit" />
</form>

<?php


if($_POST['formSubmit'] == "Submit") 
{
    $translate = $_POST['translate'];
    $targetLanguage = $_POST['targetLanguage'];
    $projectId = 'mercurial-ruler-300412';
    $contents = [$translate];
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

}