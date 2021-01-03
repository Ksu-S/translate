<?php


define('LARAVEL_START', microtime(true));
require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);

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

<input type="submit" name="formSubmit" value="Submit" name="formSubmit" />
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
    // Display the translation for each input text provided
    foreach ($response->getTranslations() as $translation) {
        printf('Translated text: %s' . PHP_EOL, $translation->getTranslatedText());
    }
} finally {
    $translationServiceClient->close();
}

}