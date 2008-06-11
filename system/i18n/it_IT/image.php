<?php defined('SYSPATH') or die('No direct script access.'); 

$lang = array
(
	'getimagesize_missing'    => 'La libreria Image richiede la funzione PHP <tt>getimagesize</tt>, che non è disponibile nella tua intallazione.',
	'driver_not_supported'    => 'Il driver per immagini %s non esiste.',
	'unsupported_method'      => 'Il driver impostato in configurazione non supporta il tipo di trasformazione %s.',
	'file_not_found'          => 'L\'immagine specificata, %s, non è stata trovata. Verificarne l\'esistenza con <tt>file_exists</tt> prima di manipolarla.',
	'type_not_allowed'        => 'Il tipo d\'immagine specificato, %s, non è permesso.', 
	'invalid_width'           => 'La larghezza specificata, %s, non è valida.',
	'invalid_height'          => 'L\'altezza specificata, %s, non è valida.',
	'invalid_dimensions'      => 'Le dimensioni specificate per %s non sono valide.',
	'invalid_master'          => 'Master dimension specificato non valido.',
	'invalid_flip'            => 'La direzione di rotazione specificata non è valida.',

	// ImageMagick specific messages
	'imagemagick' => array
	(
	    'not_found'           => 'La cartella di ImageMagick specificata, non contiene il programma richiesto, %s.', 
	),

	// GD specific messages
	'gd' => array
	(
    	'requires_v2'         => 'La libreria Image richiede GD2. Leggere http://php.net/gd_info per maggiori informazioni.',
	),
);