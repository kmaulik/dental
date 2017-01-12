<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2016, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$CI =& get_instance();

if($CI->session->userdata('language') == 'english'){

	$lang['upload_userfile_not_set'] = 'Unable to find a post variable called userfile.';
	$lang['upload_file_exceeds_limit'] = 'The uploaded file exceeds the maximum allowed size in your PHP configuration file.';
	$lang['upload_file_exceeds_form_limit'] = 'The uploaded file exceeds the maximum size allowed by the submission form.';
	$lang['upload_file_partial'] = 'The file was only partially uploaded.';
	$lang['upload_no_temp_directory'] = 'The temporary folder is missing.';
	$lang['upload_unable_to_write_file'] = 'The file could not be written to disk.';
	$lang['upload_stopped_by_extension'] = 'The file upload was stopped by extension.';
	$lang['upload_no_file_selected'] = 'You did not select a file to upload.';
	$lang['upload_invalid_filetype'] = 'The filetype you are attempting to upload is not allowed.';
	$lang['upload_invalid_filesize'] = 'The file you are attempting to upload is larger than the permitted size.';
	$lang['upload_invalid_dimensions'] = 'The image you are attempting to upload doesn\'t fit into the allowed dimensions.';
	$lang['upload_destination_error'] = 'A problem was encountered while attempting to move the uploaded file to the final destination.';
	$lang['upload_no_filepath'] = 'The upload path does not appear to be valid.';
	$lang['upload_no_file_types'] = 'You have not specified any allowed file types.';
	$lang['upload_bad_filename'] = 'The file name you submitted already exists on the server.';
	$lang['upload_not_writable'] = 'The upload destination folder does not appear to be writable.';
}else{
	$lang['upload_userfile_not_set'] = 'Eine Postvariable namens userfile konnte nicht gefunden werden.';
	$lang['upload_file_exceeds_limit'] = 'Die hochgeladene Datei überschreitet die maximal zulässige Größe in Ihrer PHP-Konfigurationsdatei.';
	$lang['upload_file_exceeds_form_limit'] = 'Die hochgeladene Datei überschreitet die maximal zulässige Größe des Formulars.';
	$lang['upload_file_partial'] = 'Die Datei wurde nur teilweise hochgeladen.';
	$lang['upload_no_temp_directory'] = 'Der temporäre Ordner fehlt.';
	$lang['upload_unable_to_write_file'] = 'Die Datei konnte nicht auf Festplatte geschrieben werden.';
	$lang['upload_stopped_by_extension'] = 'Der Datei-Upload wurde durch die Erweiterung gestoppt.';
	$lang['upload_no_file_selected'] = 'Sie haben keine hochzuladende Datei ausgewählt.';
	$lang['upload_invalid_filetype'] = 'Der Dateityp, den Sie hochladen möchten, ist nicht zulässig.';
	$lang['upload_invalid_filesize'] = 'Die Datei, die Sie hochladen möchten, ist größer als die zulässige Größe.';
	$lang['upload_invalid_dimensions'] = 'Das Bild, das Sie hochladen möchten, passt nicht in die zulässigen Dimensionen.';
	$lang['upload_destination_error'] = 'Beim Versuch, die hochgeladene Datei an das endgültige Ziel zu verschieben, trat ein Problem auf.';
	$lang['upload_no_filepath'] = 'Der Uploadpfad scheint nicht gültig zu sein.';
	$lang['upload_no_file_types'] = 'Sie haben keine zulässigen Dateitypen angegeben.';
	$lang['upload_bad_filename'] = 'Der eingegebene Dateiname ist bereits auf dem Server vorhanden.';
	$lang['upload_not_writable'] = 'Der Zielordner für das Hochladen ist nicht schreibbar.';
}
