<?php
/**
 * set the includepath for SetaPDF APIs
 * You have to point the the root directory "SetaPDF"
 */
set_include_path(get_include_path() . PATH_SEPARATOR . realpath(dirname(__FILE__).'/../../'));


// define Font-Path
define('SETAPDF_FORMFILLER_FONT_PATH','FormFiller/font/');

// require API
require_once('FormFiller/SetaPDF_FormFiller.php');

/**
 * init a new instance of the FormFiller
 */
$FormFiller = SetaPDF_FormFiller::factory(
    "Sunnysunday-Example.pdf" /* Path to original document */, 
    "" /* Owner- or User-Passwort */, 
    "I", /* How to output the document: "F" = to File, "I" = Inline, "D" = Download */
    false, // Don't stream
    false, // render the appearances by the API
    'UTF-8' // get field names and values in UTF-8
);

// Check for errors
if (SetaPDF::isError($FormFiller)) {
    echo "<pre>";
    print_r($FormFiller);
    echo "</pre>";
    die();
}

/**
 * Use Update or create a whole new document 
 */
$FormFiller->setUseUpdate(false);

// Get all Form Fields
$fields =& $FormFiller->getFields();
// Check for errors
if (SetaPDF::isError($fields)) {
    die($fields->message);
}


/**
 *  to get the fieldnames you can print them with this snipped on your screen
 */
// echo "<pre>";
// print_r(array_keys($fields));
// echo "</pre>";
// flush();
/*
Array
(
    [0] => How many balloons
    [1] => Balloon color
    [2] => Favorite Cake
    [3] => Pet kind
    [4] => Pet name
    [5] => Arrival
    [6] => Departure
    [7] => Balloons
    [8] => Pets
)
*/

// Radio Buttons
$buttons =& $fields['Balloons']->getButtons();
$buttons['/Yes']->push();
// or
// $buttons['/No']->push();

// Fill in Textfields
$fields['How many balloons']->setValue("10");

// Choose a random color in the select field
$colors = $fields['Balloon color']->getOptions();
$colorKey = array_rand($colors);
$fields['Balloon color']->setValue($colorKey);

// Multiline Textfield
$fields['Favorite Cake']->setValue('I like every kind of cake! Just make sure it is enough! Like '
                                  .'this text in the multiline textfield. ;-)');

$buttons =& $fields['Pets']->getButtons();
$buttons['/No']->push();

$fields['Pet kind']->setValue('...nothing?');
$fields['Pet name']->setValue('...aehm?');

// We are going to arrive at 3pm
$fields['Arrival']->setValue(2);
// and we are going to leave at 9pm
$fields['Departure']->setValue(4);

// Ouput the new PDF
$FormFiller->fillForms('NewPDF.pdf');
