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
* This is a "wrapper" file including "ext_core/file.php" automatically.
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
* @subpackage developer
* @since      v0.1.08
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

/* -------------------------------------------------------------------------
Testing for required classes
------------------------------------------------------------------------- */

$g_continue_check = true;
if (defined ("CLASS_direct_developer_builder")) { $g_continue_check = false; }
if (($g_continue_check)&&(!defined ("CLASS_direct_file"))) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/ext_core/file.php",1); }
if (($g_continue_check)&&(!defined ("CLASS_direct_php_builder"))) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/ext_core/php_builder.php",1); }
if (($g_continue_check)&&(!defined ("CLASS_direct_xml"))) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_xml.php",1); }
if (($g_continue_check)&&(!function_exists ("direct_dir_exists"))) { $g_continue_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/swg_dir_functions.php",1); }

if ($g_continue_check)
{
//c// direct_developer_builder
/**
* This wrapper class extends "ext_core/file.php" and sets our default
* parameters.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage basic_functions
* @uses       CLASS_direct_php_builder
* @since      v0.1.08
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_developer_builder extends direct_php_builder
{
/**
	* @var string $output_array Pathes and settings to generate the output files
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $output_array;
/**
	* @var string $output_iversion Internal version for output
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $output_iversion;
/**
	* @var string $output_name Package name
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $output_name;
/**
	* @var string $output_package Package node name
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $output_package;
/**
	* @var integer $output_package_level Package level
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $output_package_level;
/**
	* @var integer $output_position Current output array position we are working
	*      with
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $output_position;
/**
	* @var string $output_version Version for output
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $output_version;
/**
	* @var string $output_version_tag Version tag for #echo()#
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $output_version_tag;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_developer_builder->__construct () and direct_developer_builder->direct_developer_builder ()
/**
	* Constructor (PHP5) __construct (direct_developer_builder)
	*
	* @uses  direct_basic_functions::include_file()
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -developer_builder_class->__construct (direct_developer_builder)- (#echo(__LINE__)#)"); }

		$direct_classes['basic_functions']->include_file ("makefile.php");

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ("","","class,css,gif,htm,html,ipd,jpg,js,php,png,swf,txt,xhtm,xhtml,xml",@$direct_settings['swg_umask_change'],@$direct_settings['swg_chmod_files_change'],@$direct_settings['swg_chmod_dirs_change'],$direct_cachedata['core_time'],($direct_settings['timeout'] + $direct_settings['timeout_core']),USE_debug_reporting);

/* -------------------------------------------------------------------------
Set up additional variables
------------------------------------------------------------------------- */

		$this->output_array = array ();
		$this->output_iversion = "";
		$this->output_name = "";
		$this->output_package = "";
		$this->output_package_level = 0;
		$this->output_position = 0;
		$this->output_version = "";
		$this->output_version_tag = "";
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_developer_builder (direct_developer_builder)
	*
	* @since v0.1.08
	function direct_developer_builder () { $this->__construct (); }
:#*/
	//f// direct_developer_builder->file_write ($f_file_content,$f_file_path,$f_file_mode = "w+b")
/**
	* Write the given file to the defined location. Create subdirectories if
	* needed.
	*
	* @param  string $f_file_content Parsed content
	* @param  string $f_file_path Path to the output file
	* @param  string $f_file_mode Filemode to use
	* @uses   direct_php_builder::file_write()
	* @return boolean True on success
	* @since  v0.1.08
*/
	/*#ifndef(PHP4) */protected /* #*/function file_write ($f_file_content,$f_file_path,$f_file_mode = "w+b")
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -developer_builder_class->file_write (+f_file_content,$f_file_path,$f_file_mode)- (#echo(__LINE__)#)"); }

		if ($this->get_variable ("DEBUG") == NULL) { $f_file_content = preg_replace (array ("#\/\* ---(.*?)--- \*\/\n\n#si","#\n\/\*\*\n(.*?)\n\*\/\n#si"),(array ("","\n")),$f_file_content); }
		if (preg_match ("#.js$#",$f_file_path)) { $f_file_content = trim (preg_replace (array ("#\/\*(.*?)\*\/#s","#^(.*?)//(.*?)$#m","#(\t|\r|\n|\r\n)+#"),(array ("","\\1"," ")),$f_file_content)); }

		if ((isset ($this->output_array[$this->output_position]))&&(parent::file_write ($f_file_content,($this->output_array[$this->output_position]['path'].$f_file_path),$f_file_mode))) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -developer_builder_class->file_write ()- (#echo(__LINE__)#)",(:#*/md5 ($f_file_content)/*#ifdef(DEBUG):),true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -developer_builder_class->file_write ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
	}

	//f// direct_developer_builder->get_package_xml ()
/**
	* Gets the package XML object for the current output position.
	*
	* @param  string $f_name Variable name
	* @uses   direct_xml::node_add()
	* @uses   direct_xml::node_cache_pointer()
	* @uses   direct_xml::node_change_attributes()
	* @return direct_xml Variable content; NULL if undefined
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */protected /* #*/function get_package_xml ()
	{
		if (USE_debug_reporting) { direct_debug (7,"sWG/#echo(__FILEPATH__)# -developer_builder_class->get_package_xml ()- (#echo(__LINE__)#)"); }
		$f_return = NULL;

		if (isset ($this->output_array[$this->output_position]))
		{
			$f_continue_check = isset ($this->output_array[$this->output_position]['xml']);

			if ($f_continue_check) { $f_return =& $this->output_array[$this->output_position]['xml']; }
			else
			{
$f_package_array = array (
"level" => $this->output_package_level,
"package" => $this->output_name,
"swgversion" => $this->output_version,
"swgiversion" => $this->output_iversion
);

				$this->output_array[$this->output_position]['xml'] = new direct_xml ();
				$f_return =& $this->output_array[$this->output_position]['xml'];

				$f_file_data = (file_exists ($this->output_array[$this->output_position]['path']."data/settings/swg_packages_installed.php") ? direct_file_get ("s0",$this->output_array[$this->output_position]['path']."data/settings/swg_packages_installed.php") : NULL);

				if ($f_return)
				{
					if (isset ($f_file_data)) { $f_return->xml2array ($f_file_data,true,false); }

					if ($f_return->node_cache_pointer ("swg_packages_file_v1 packages ".$this->output_package)) { $f_return->node_change_attributes ("swg_packages_file_v1 packages ".$this->output_package,$f_package_array); }
					else
					{
						if (!isset ($f_file_data))
						{
							$f_return->node_add ("swg_packages_file_v1","",(array ("xmlns" => "urn:de.direct-netware.xmlns:swg.packages.v1")));
							$f_return->node_add ("swg_packages_file_v1 phpexit","<?php exit (); ?>");
						}

						$f_return->node_add ("swg_packages_file_v1 packages ".$this->output_package,"",$f_package_array);
						$f_return->node_cache_pointer ("swg_packages_file_v1 packages ".$this->output_package);
					}
				}
			}
		}

		return $f_return;
	}

	//f// direct_developer_builder->get_variable ($f_name)
/**
	* Gets the variable content with the given name.
	*
	* @param  string $f_name Variable name
	* @return mixed Variable content; NULL if undefined
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */protected /* #*/function get_variable ($f_name)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -developer_builder_class->get_variable ($f_name)- (#echo(__LINE__)#)"); }

		$f_return = NULL;

		if (isset ($this->output_array[$this->output_position]))
		{
			if ($f_name == "DEBUG")
			{
				if ($this->output_array[$this->output_position]['development']) { $f_return = true; }
			}
			elseif ($f_name == $this->output_version_tag) { $f_return = $this->output_version; }
			elseif (preg_match ("#^PHP(.+?)$#",$f_name,$f_result_array))
			{
				if ($f_result_array[1] == $this->output_array[$this->output_position]['phpversion']) { $f_return = true; }
			}
			elseif (defined ($f_name)) { $f_return = constant ($f_name); }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -developer_builder_class->get_variable ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_developer_builder->make_all ()
/**
	* Parse and rewrite all directories and files given as include definitions.
	*
	* @uses   direct_developer_builder::file_parse()
	* @uses   direct_developer_builder::get_package_xml()
	* @uses   direct_php_builder::workdir_scan()
	* @uses   direct_xml::node_add()
	* @uses   direct_xml::node_change_value()
	* @uses   direct_xml::node_get()
	* @return boolean True on success
	* @since  v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function make_all ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -developer_builder_class->make_all ()- (#echo(__LINE__)#)"); }
		$f_return = false;

		if ((!empty ($this->dir_array))&&(!empty ($this->filetype_array))) { $this->workdir_scan (); }
		$f_continue_check = false;

		if (empty ($this->file_array)) { trigger_error ("sWG/#echo(__FILEPATH__)# -developer_builder_class->make_all ()- (#echo(__LINE__)#) reports: No valid files found for parsing",E_USER_ERROR); }
		else
		{
			$f_strip_prefix = preg_quote ($this->output_strip_prefix);

			foreach ($this->file_array as $f_file_md5 => $f_file)
			{
				$f_file_stripped = preg_replace ("#^$f_strip_prefix#","",$f_file);
				echo "\n>> Parsing $f_file_stripped ...";
				$this->output_position = 0;

				while (isset ($this->output_array[$this->output_position]))
				{
					$f_xml_object =& $this->get_package_xml ();

					if ($f_xml_object)
					{
						$f_continue_check = true;
						$f_target_file = $this->output_array[$this->output_position]['path'].$f_file_stripped;

						if (file_exists ($f_target_file))
						{
							$f_target_node_array = $f_xml_object->node_get ("swg_packages_file_v1 packages ".$this->output_package." ".$f_file_md5);
							$f_target_file_md5 = md5_file ($f_target_file);

							if ((isset ($f_target_node_array['value']))&&($f_target_file_md5)&&($f_target_node_array['value'] != $f_target_file_md5)) { $f_continue_check = false; }
						}
						else { $f_target_node_array = $f_xml_object->node_get ("swg_packages_file_v1 packages ".$this->output_package." ".$f_file_md5); }

						$f_parsed_file_md5 = ($f_continue_check ? $this->file_parse ($f_file) : false);

						if (is_string ($f_parsed_file_md5))
						{
							if (isset ($f_target_node_array/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_target_node_array['value']))
							{
								if ($f_parsed_file_md5 != $f_target_node_array['value']) { $f_xml_object->node_change_value ("swg_packages_file_v1 packages ".$this->output_package." ".$f_file_md5,$f_parsed_file_md5); }
							}
							else { $f_xml_object->node_add ("swg_packages_file_v1 packages ".$this->output_package." ".$f_file_md5,$f_parsed_file_md5,(array ("path" => $f_file_stripped))); }
						}
						elseif ($f_continue_check) { echo "\n!>> Failed to write the output file ... ".$this->output_array[$this->output_position]['path']; }
						else { echo "\n!>> File has been modified ... ".$this->output_array[$this->output_position]['path']; }
					}
					else { echo "\n!>> XML package file data not available"; }

					$this->output_position++;
				}
			}

			foreach ($this->output_array as $f_output_array)
			{
				echo "\n> Saving new swg_packages_installed.php for {$f_output_array['path']} ... ";

				if ((isset ($f_output_array['xml']))&&($f_output_array['xml']))
				{
					$f_file_data = "<?xml version='1.0' encoding='UTF-8' ?>\n".($f_output_array['xml']->cache_export (true,false));
					echo (direct_file_write ($f_file_data,$f_output_array['path']."data/settings/swg_packages_installed.php","s0") ? "done" : "failed");
				}
				else { echo "failed"; }
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -developer_builder_class->make_all ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_developer_builder->set_include ($f_include)
/**
	* Add "include" definitions for directories and files.
	*
	* @param  string $f_include String (delimiter is ",") with include names or
	*         pathes
	* @since  v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function set_include ($f_include)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -developer_builder_class->set_include ($f_include)- (#echo(__LINE__)#)"); }

		if (is_string ($f_include))
		{
			$f_include_array = explode (",",$f_include);

			foreach ($f_include_array as $f_include)
			{
				if (is_dir ($f_include)) { $this->dir_array[] = $f_include; }
				elseif (is_file ($f_include)) { $this->file_array[md5 ($f_include)] = $f_include; }
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -developer_builder_class->set_include ()- (#echo(__LINE__)#)",:#*/(((count ($this->dir_array))||(count ($this->file_array))) ? true : false)/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_developer_builder->set_target_metadata ($f_package,$f_name,$f_level,$f_version,$f_iversion = NULL)
/**
	* Set output specific metadata for output.
	*
	* @param  string $f_package Package node name
	* @param  string $f_name Package name
	* @param  integer $f_level Package level
	* @param  string $f_version Output version
	* @param  string $f_iversion Internal output version (fallback is
	*         $f_version)
	* @since  v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function set_target_metadata ($f_package,$f_name,$f_level,$f_version,$f_iversion = NULL)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -developer_builder_class->set_target_metadata ($f_package,$f_name,$f_level,$f_version,+f_iversion)- (#echo(__LINE__)#)"); }

		$f_version_tag = (preg_match ("#^swg_(.+?)$#i",$f_name) ? "sWG".(substr ($f_name,4))."Version" : $f_name."Version");

		if (preg_match_all ("#_(\w)#",$f_version_tag,$f_result_array,PREG_PATTERN_ORDER))
		{
			foreach ($f_result_array[1] as $f_rewrite_char) { $f_version_tag = str_replace ("_".$f_rewrite_char,(strtoupper ($f_rewrite_char)),$f_version_tag); }
		}

		$this->output_name = $f_name;
		$this->output_package = $f_package;
		$this->output_package_level = $f_level;
		$this->output_version = $f_version;
		$this->output_version_tag = $f_version_tag;
		if ($f_iversion == NULL) { $f_iversion = $f_version; }
		$this->output_iversion = $f_iversion;
	}

	//f// direct_developer_builder->target_check ()
/**
	* Check the targets defined in the given XML array and cache settings for
	* later use.
	*
	* @param array $f_targets_array Target XML array tree
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function target_check ($f_targets_array)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -developer_builder_class->target_check (+f_data)- (#echo(__LINE__)#)"); }
		$f_return = false;

		if ((is_array ($f_targets_array))&&(!empty ($f_targets_array)))
		{
			if (isset ($f_targets_array['target']['xml.mtree']))
			{
				$f_targets_array = $f_targets_array['target'];
				unset ($f_targets_array['xml.mtree']);
			}

			echo "\n> Found ".(count ($f_targets_array))." potential target definitions";

			foreach ($f_targets_array as $f_target_array)
			{
				$f_path = (isset ($f_target_array['attributes']['path']) ? $f_target_array['attributes']['path'] : "");
				$f_development_version = (isset ($f_target_array['attributes']['development']) ? $f_target_array['attributes']['development'] : 0);
				$f_php_target_version = (isset ($f_target_array['attributes']['phpversion']) ? $f_target_array['attributes']['phpversion'] : "4");

				if ($f_path)
				{
					echo "\n> Testing target $f_path ...";

					if (direct_dir_is_writable ($f_path))
					{
						if ($f_php_target_version == "e") { $f_php_target_version = 5; }
						$f_return = true;
						$this->output_array[$f_path] = array ("path" => $f_path,"development" => $f_development_version,"phpversion" => $f_php_target_version);
						echo "\n>> Location is writable";
					}
					else { echo "\n!> Location is not writable - ignoring"; }
				}
			}

			$this->output_array = array_values ($this->output_array);
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -developer_builder_class->target_check ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_direct_developer_builder",true);
}

//j// EOF
?>