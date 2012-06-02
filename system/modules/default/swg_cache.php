<?php
//j// BOF

/*n// NOTE
----------------------------------------------------------------------------
secured WebGine
net-based application engine
----------------------------------------------------------------------------
(C) direct Netware Group - All rights reserved
http://www.direct-netware.de/redirect.php?swg

This work is distributed under the W3C (R) Software License, but without any
warranty; without even the implied warranty of merchantability or fitness
for a particular purpose.
----------------------------------------------------------------------------
http://www.direct-netware.de/redirect.php?licenses;w3c
----------------------------------------------------------------------------
#echo(sWGcoreVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* default/swg_cache.php
*
* @internal   We are using phpDocumentor to automate the documentation process
*             for creating the Developer's Manual. All sections including
*             these special comments will be removed from the release source
*             code.
*             Use the following line to ensure 76 character sizes:
* ----------------------------------------------------------------------------
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage basic_functions
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

/*#use(direct_use) */
use dNG\sWG\directFileFunctions;

/* #\n*/
/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Basic configuration

/* -------------------------------------------------------------------------
Direct calls will be honored with an "exit ()"
------------------------------------------------------------------------- */

if (!defined ("direct_product_iversion")) { exit (); }

//j// Script specific commands

if (!isset ($direct_settings['swg_content_modification_check'])) { $direct_settings['swg_content_modification_check'] = true; }

if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }

if ($direct_globals['kernel']->serviceInitDefault ())
{
//j// BOA
$g_dfile = (isset ($direct_settings['dsd']['dfile']) ? ($direct_globals['basic_functions']->inputfilterFilePath ($direct_settings['dsd']['dfile'])) : "");
if (!$g_dfile) { $g_dfile = (isset ($direct_settings['dsd']['dyn_img']) ? ($direct_globals['basic_functions']->inputfilterFilePath ($direct_settings['dsd']['dyn_img'])) : ""); }

$direct_globals['output']->header (true,false);

if (file_exists ($g_dfile))
{
	if (preg_match ("#^(.*?).swglink.php$#i",$g_dfile))
	{
		$g_dfile = direct_file_get ("s",$g_dfile);
		if ((!$g_dfile)||(!file_exists ($g_dfile))) { $g_dfile = ""; }
	}
}
else { $g_dfile = ""; }

if ($g_dfile)
{
	$g_continue_check = true;
	$g_modification_check = true;

	if (($direct_settings['swg_content_modification_check'])&&(isset ($_SERVER['HTTP_IF_MODIFIED_SINCE'])))
	{
		$g_client_last_modified = strtotime ($_SERVER['HTTP_IF_MODIFIED_SINCE']);

		if ($g_client_last_modified > -1)
		{
			$g_server_last_modified = filemtime ($g_dfile);

			if ($g_server_last_modified <= $g_client_last_modified)
			{
				$direct_globals['output']->outputHeader ("HTTP/1.1","HTTP/1.1 304 Not Modified",true);
				$g_modification_check = false;
			}
		}
	}
}
else { $g_continue_check = false; }

if (($g_continue_check)&&($g_modification_check))
{
	if ($direct_settings['swg_content_modification_check'])
	{
		if (!isset ($g_server_last_modified)) { $g_server_last_modified = filemtime ($g_dfile); }
		$direct_globals['output']->lastModified ($g_server_last_modified);
	}

	if (preg_match ("#^(.*?)\.php\.(css|js)$#i",$g_dfile,$g_result_array))
	{
		if ($g_result_array[2] == "css") { $direct_globals['output']->outputHeader ("Content-Type","text/css"); }
		else { $direct_globals['output']->outputHeader ("Content-Type","text/javascript"); }

		ob_start ();

		if ($direct_globals['basic_functions']->includeFile ($g_dfile,2))
		{
/*#ifndef(PHP4) */
			$direct_globals['output']->output_data = ob_get_flush ();
/* #*//*#ifdef(PHP4):
			$direct_globals['output']->output_data = ob_get_contents ();
			ob_end_clean ();
:#\n*/
		}
		else
		{
			ob_end_clean ();
			$direct_globals['output']->outputHeader ("HTTP/1.1","HTTP/1.1 415 Unsupported Media Type",true);
		}
	}
	elseif (preg_match ("#^(.*?)\.(css|gif|jar|jpg|jpeg|js|png|swf)$#i",$g_dfile,$g_extension_result_array))
	{
		$g_range_start = 0;
		$g_range_size = 0;
		$g_range_end = 0;

		if (isset ($_SERVER['HTTP_RANGE']))
		{
			$g_continue_check = false;

			if (preg_match ("#^bytes(.*?)=(.*?)-(.*?)$#i",$_SERVER['HTTP_RANGE'],$g_range_result_array))
			{
				$g_range_start = preg_replace ("#(\D+)#","",$g_range_result_array[2]);
				$g_range_end = preg_replace ("#(\D+)#","",$g_range_result_array[3]);
				$g_file_size = filesize ($g_dfile);

				if ($g_range_start)
				{
					if ($g_range_end)
					{
						if (($g_range_start >= 0)&&($g_range_start <= $g_range_end)&&($g_range_end < $g_file_size)) { $g_continue_check = true; }
					}
					elseif (($g_range_start >= 0)&&($g_range_start < $g_file_size))
					{
						$g_continue_check = true;
						$g_range_end = ($g_file_size - 1);
					}
				}

				if ($g_continue_check)
				{
					$direct_globals['output']->outputHeader ("HTTP/1.1","HTTP/1.1 206 Partial Content",true);
					$direct_globals['output']->outputHeader ("Content-Range",$g_range_start."-{$g_range_end}/".$g_file_size);

					$g_range_size = (1 + $g_range_end - $g_range_start);
					$direct_globals['output']->outputHeader ("Content-Length",$g_range_size);
				}
			}
		}

		$g_binary_check = false;

		switch ($g_extension_result_array[2])
		{
		case "css":
		{
			$g_file_mode = "r";
			$g_file_type = "text/css";
			break 1;
		}
		case "gif":
		{
			$g_binary_check = true;
			$g_file_mode = "rb";
			$g_file_type = "image/gif";
			break 1;
		}
		case "jar":
		{
			$g_file_mode = "rb";
			$g_file_type = "application/java-archive";
			break 1;
		}
		case "js":
		{
			$g_file_mode = "r";
			$g_file_type = "text/javascript";
			break 1;
		}
		case "png":
		{
			$g_binary_check = true;
			$g_file_mode = "rb";
			$g_file_type = "image/png";
			break 1;
		}
		case "swf":
		{
			$g_binary_check = true;
			$g_file_mode = "rb";
			$g_file_type = "application/x-shockwave-flash";
			break 1;
		}
		default:
		{
			$g_binary_check = true;
			$g_file_mode = "rb";
			$g_file_type = "image/jpeg";
		}
		}

		$g_file_object = new directFileFunctions ();
		$g_file_object->open ($g_dfile,true,$g_file_mode);

		if ($g_file_object->resourceCheck ())
		{
			ob_start ();

			if ($g_range_start) { $g_file_object->seek ($g_range_start); }
			$g_timeout_time = ($direct_cachedata['core_time'] + $direct_settings['timeout'] + $direct_settings['timeout_core']);

			if ($g_range_size)
			{
				do
				{
					$g_block_size = (($g_range_size > 4096) ? 4096 : $g_range_size);

					if ($g_binary_check) { echo $g_file_object->read ($g_block_size); }
					else
					{
						$g_block_data = $g_file_object->read ($g_block_size);
						if (INFO_magic_quotes_runtime) { $direct_globals['basic_functions']->magicQuotesFilter ($g_block_data); }
						echo $g_block_data;
					}

					$g_range_size -= $g_block_size;
				}
				while (($g_range_size > 0)&&(!$g_file_object->eofCheck ())&&($g_timeout_time > (time ())));

				$g_continue_check = (($g_range_size > 0) ? false : true);
			}
			else
			{
				while ((!$g_file_object->eofCheck ())&&($g_timeout_time > (time ())))
				{
					if ($g_binary_check) { echo $g_file_object->read (4096); }
					else
					{
						$g_block_data = $g_file_object->read (4096);
						if (INFO_magic_quotes_runtime) { $direct_globals['basic_functions']->magicQuotesFilter ($g_block_data); }
						echo $g_block_data;
					}
				}

				$g_continue_check = $g_file_object->eofCheck ();
			}

			if ($g_continue_check)
			{
				$direct_globals['output']->outputHeader ("Content-Type",$g_file_type);
/*#ifndef(PHP4) */
				$direct_globals['output']->output_data = ob_get_flush ();
/* #*//*#ifdef(PHP4):
				$direct_globals['output']->output_data = ob_get_contents ();
				ob_end_clean ();
:#\n*/
			}
			else
			{
				ob_end_clean ();
				$direct_globals['output']->outputHeader ("HTTP/1.1","HTTP/1.1 504 Gateway Timeout",true);
			}

			$g_file_object->close ();
		}
		else { $direct_globals['output']->outputHeader ("HTTP/1.1","HTTP/1.1 404 Not Found",true); }
	}
	else { $direct_globals['output']->outputHeader ("HTTP/1.1","HTTP/1.1 415 Unsupported Media Type",true); }
}
elseif (!$g_continue_check) { $direct_globals['output']->outputHeader ("HTTP/1.1","HTTP/1.1 404 Not Found",true); }

$direct_globals['output']->outputSend (NULL);
//j// EOA
}

$direct_cachedata['core_service_activated'] = true;

//j// EOF
?>