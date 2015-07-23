<?
require_once( 'forge_fdf.php' );

// use this array for text fields, combo box, and list box form field values
$fdf_data_strings= array( 'city'  => 'San Francisco',
                          'state' => 'California' );

// use this array for check box and radio button values
$fdf_data_names= array();

// these aren't used in this example
$fields_hidden= array();
$fields_readonly= array();

$fdf= forge_fdf(	'',
                        $fdf_data_strings,
                        $fdf_data_names,
                        $fields_hidden,
                        $fields_readonly );

$fdf_fn= tempnam( '.', 'fdf' );
$fp= fopen( $fdf_fn, 'w' );
if( $fp ) {
   fwrite( $fp, $fdf );
   fclose( $fp );

   // serve PDF, but prompt the user to save it to disk
   header( 'Content-type: application/pdf' );
   header(	'Content-disposition: attachment; '.
                'filename=filled_form.pdf' );

   // our pdftk magic; "flatten" merges data with the page
   passthru(   'pdftk form.pdf fill_form '. $fdf_fn.
                                         ' output - flatten' );
	
   unlink( $fdf_fn ); // delete temp file
}
else { // error
   echo 'Error: unable to write temp fdf file: '. $fdf_fn;
}
?>
