<?php
/**
 * Pole $_FILES ma debilni strukturu, ktera dobre ilustruje, proc bylo PHP na zacatku zmrseny jazyk
 * https://stackoverflow.com/questions/11690570/files-array-and-its-silly-structure
 *
 * pokud delate <input type="file" name="file1"> bude ve $_FILES:
 * ['file1' =>
 *    [
 *      'name' => ...
 *       'type' => ...
 *        ...
 *    ]
 * ]
 *
 * ale kdyz si inputy pojmenujete podle formu <input type="file" name="formular[file1]"> dostanete
 *
 *  [
 *    'formular' =>
 *    [
 *      'name' => ['file1' => ...],
 *      'type' => ['file1' => ...],
 *      ...
 *   ]
 * ]
 *
 * tak bacha na to
 */


// regex pro jedno slovo obsahujici ceske upper case znaky
const CZ_ALPHA_UPPER_REGEX = '^[A-ZČĎĚŇŘŠŤŽÁÉÍÓŮÚ]*$';

/*--------------------------------- VALIDACE ----------------------------------*/

// nejdriv validujeme cely form
function validateForm(array $form, array $uploadedFiles): bool
{
    // je poslano vse co ma byt?
    if (!isset($form['name'], $form['lastName'], $uploadedFiles ['tmp_name']['file'])) {
        throw new \InvalidArgumentException('Struktura formulare je neplatna');
    }

    // pokud ano validujeme jednotlive polozky
    return validateName($form['name']) && validateLastName($form['lastName']) && validateFile($uploadedFiles);
}

function validateName(string $name): bool
{
    // jmeno musi mit hodnotu a odpovidat regexu
    if ($name === '') {
        throw new \InvalidArgumentException('Jmeno musi byt vyplneno a musi obsahovat velka pismena ceske abecedy');
    }

    if (!preg_match('/' . CZ_ALPHA_UPPER_REGEX . '/', $name)) {
        throw new \InvalidArgumentException('Jmeno musi obsahovat velka pismena ceske abecedy');
    }

    return true;
}

function validateLastName(string $lastName): bool
{
    // prijmeni musi mit hodnotu a odpovidat regexu
    if ($lastName === '') {
        throw new \InvalidArgumentException('Prijmeni musi byt vyplneno a musi obsahovat velka pismena ceske abecedy');
    }

    if (!preg_match('/' . CZ_ALPHA_UPPER_REGEX . '/', $lastName)) {
        throw new \InvalidArgumentException('Prijmeni musi obsahovat velka pismena ceske abecedy');
    }

    return true;
}

function validateFile(array $file, $id = 'file'): bool
{
    if ($file['name'][$id] === '') {
        throw new \InvalidArgumentException('Musite nahrat soubor');
    }

    // mohli bychom take kontrolovat priponu apod...

    return true;
}

/*--------------------------------- FILE UPLOAD ----------------------------------*/


function processFileUpload(string $name, string $lastName, array $file, string $id = 'file'): string
{
    $uploadDir = 'upload/';
    // kouknem jestli slozka existuje a pripadne ji vytvorime
    createDirIfNeeded($uploadDir);

    // Dost naivini zpusob jak zjistit priponu souboru. Normalne by se hadalo podle mime typu
    // rozdelime puvodni jmeno po teckach
    $explodedName = explode('.', $file['name'][$id]);

    // za posledni teckou bude pripona...
    $extension = count($explodedName) > 1 ? end($explodedName) : null;

    // vytvorime novy nazev. Pripona je pridana jen kdyz byla v puvodnim souboru
    $fileName = $name . '_' . $lastName . ($extension ? '.' . $extension : '');

    // sestavime cestu
    $path = $uploadDir . $fileName;

    //smazeme predchozi soubor pokud existuje
    removeOldFile($path);

    //pokusime se presunout z tmp do noveho mista
    if (!move_uploaded_file($file['tmp_name']['file'], $path)) {
        throw new \Exception('Soubor nemohl byt nahran');
    }

    // vratime absolutni cestu k novemu souboru
    return realpath($path);
}

function createDirIfNeeded(string $dir): void
{
    // existuje uz?
    if (!is_dir($dir)) {
        // kdyz ne, vytvor a znovu zkontroluj
        if (!mkdir($dir, 0777, true) && !is_dir($dir)) {
            // neco se pokazilo
            throw new \RuntimeException(sprintf('Unable to create the %s directory', $dir));
        }
    }
}

function removeOldFile(string $path): void
{
    // kdyz uz soubor existuje, smaz ho
    if (file_exists($path)) {
        unlink($path);
    }
}

/*}--------------------------------- FORM SUBMIT ----------------------------------*/


function processForm(array $form, array $uploadedFiles): ?string
{
    // nejdriv validuju
    if (validateForm($form, $uploadedFiles)) {
        // vytaham data z pole do jednotlivych promennych
        ['name' => $name, 'lastName' => $lastName] = $form;

        // nahrajeme soubor a cestu vratime
        return processFileUpload($name, $lastName, $uploadedFiles);
    }

    // neco se nepovedlo
    return null;
}

$error = null;
$filePath = null;
$name = null;
$lastName = null;
$submitted = false;

if (isset($_POST['form'])) {// celou tu saskarnu provozuju jen kdyz byl form submitnuty
    $submitted = true;
    // protoze nahore vyhazuju vyjimky a neodchytam je, chytnu si je tady pres try-catch
    try {
        /** v $_POST['form'] jsou data z formu, ve $_FILES['form'] jsou nahrany soubory
         * plati jenom kdyz dolisuju inputy jmenem formulare (name="formular[lastName]"),
         * pokud udelam jen (name="lastName") tak hodnota inputu bude rovnou v $_POST['lastName']
         *
         **/
        // zpracujeme formular a cestu si ulozime
        $filePath = processForm($_POST['form'], $_FILES['form']);
    } catch (\Exception $exception) {
        // submitnute hodnoty si ulozim do promennych pokud nastala chyba, aby se pak dal form predvyplnit
        [
            'name' => $name,
            'lastName' => $lastName
        ] = $_POST['form'];  // array destruction https://stitcher.io/blog/array-destructuring-with-list-in-php

        // error message si ulozime
        $error = $exception->getMessage();
    }
}

?>

<html lang="cs">
<head>
  <title>
    Řešení zkouškového testu
  </title>
</head>
<body>
<h1>Testik</h1>
<form action="" method="post" name="form" enctype="multipart/form-data">
  <input type="text" name="form[name]" placeholder="Jmeno"
         value="<?php
         echo $name; ?>">
  <br/>
  <input type="text" name="form[lastName]" placeholder="Prijmeni"
         value="<?php
         echo $lastName; ?>">
  <br/>
  <input type="file" name="form[file]"><br/><br/>

  <p>
      <?php
      if($submitted) {
          // bud vypisuju error nebo se vse povedlo
          echo $error ?? sprintf('Vse se povedlo. Cesta k souboru: %s', $filePath);
      }
      ?>
  </p>
  <button type="submit">Submit that shit</button>
</form>
</body>
</html>
