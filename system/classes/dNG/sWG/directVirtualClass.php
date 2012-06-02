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
* OOP (Object Oriented Programming) requires an abstract data
* handling. The sWG is OO (where it makes sense).
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
* @since      v0.1.03
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
/*#ifdef(PHP5n) */

namespace dNG\sWG;
/* #\n*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

if (!defined ("CLASS_directVirtualClass"))
{
/**
* This is the root for all other classes and provides our "Virtual Binding"
* functionality.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage basic_functions
* @since      v0.1.05
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class directVirtualClass
{
/**
	* @var array $functions Array to save active functions
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $functions;

/* -------------------------------------------------------------------------
Construct the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (direct_virtual_class)
	*
	* @since v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -virtualClass->__construct (VirtualClass)- (#echo(__LINE__)#)"); }

		$this->functions = array ();

/* -------------------------------------------------------------------------
Informing the system about available functions
------------------------------------------------------------------------- */

		$this->functions['debug'] = true;
		$this->functions['debugWalker'] = true;
		$this->functions['vCall'] = true;
		$this->functions['vCallCheck'] = true;
		$this->functions['vCallGet'] = true;
		$this->functions['vCallRref'] = true;
		$this->functions['vCallSet'] = true;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) VirtualClass
	*
	* @since v0.1.01
*\/
	function VirtualClass () { $this->__construct (); }
:#\n*/
/**
	* Destructor (PHP5) __destruct (VirtualClass)
	*
	* @since v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function __destruct ()
	{
		// Nothing to do for me
	}

/* -------------------------------------------------------------------------
This clone function is not defined because we are happy with PHP's default
behavior
------------------------------------------------------------------------- */

	// Run PHP-internal function __clone () { ... }
/*#ifdef(DEBUG):
/**
	* This operation prints $f_data to the browser (and exists) or to
	* $direct_cachedata['core_debug'].
	*
	* @param boolean $f_exit True to print_r and exit
	* @param array $f_data External array (will overwrite the $this->var
	*        output)
	* @since v0.1.03
*\/
	/*#ifndef(PHP4) *\/public /* #*\/function debug ($f_exit = false,$f_data = "")
	{
		global $direct_cachedata;

		if (!is_array ($f_data)) { $f_data = get_object_vars ($this); }

		if ($f_exit)
		{
			if (!headers_sent ()) { header ("Content-Type: text/plain; charset=UTF-8",true); }
			echo $this->debugWalker ($f_data);
			echo "\n\n".$this->debugWalker ($direct_cachedata['core_debug']);
			echo "\n\n".$this->debugWalker ($direct_cachedata['core_error']);
			exit ();
		}
		else
		{
$direct_cachedata['output_warning'][] = array ("title" => direct_html_encode_special ("sWG/#echo(__FILEPATH__)# -virtualClass->debug (+f_exit,+f_data)- (#echo(__LINE__)#)"),"text" => ($this->debugWalker ($f_data))."

".($this->debugWalker ($direct_cachedata['core_error'])));
		}
	}

/**
	* Recursively read, convert and return given input data.
	*
	* @param  array $f_data Input array to walk through
	* @return string List of variable types and contents
	* @since  v0.1.03
*\/
	/*#ifndef(PHP4) *\/protected /* #*\/function debugWalker ($f_data)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -virtualClass->debugWalker (+f_data)- (#echo(__LINE__)#)"); }
		$f_return = "";

		if (is_array ($f_data))
		{
			foreach ($f_data as $f_key => $f_value)
			{
				if ($f_return) { $f_return .= "\n"; }
				$f_return .= $f_key.": ".(direct_debug_value ($f_value));
			}
		}

		return /*#ifdef(DEBUG):direct_debug (9,"sWG/#echo(__FILEPATH__)# -virtualClass->debugWalker ()- (#echo(__LINE__)#)",:#*\/$f_return/*#ifdef(DEBUG):,true):#*\/;
	}
:#*/
/**
	* The sWG provides a method called "Virtual Binding" to add non class methods
	* or functions virtually to the object. This method is used to call these
	* virtual methods (or real ones if not applicable). Normally we use
	* "call_user_func" to support "Virtual Binding". This is about 4 times slower
	* than dynamic function calls ($example->$callme ()). We strongly recommend
	* to use and support v_ function calls if possible.
	*
	* @return mixed Returned data from method (NULL on error)
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vCall ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -virtualClass->vCall (...)- (#echo(__LINE__)#)"); }

		$f_data = func_get_args ();
		$f_return = NULL;

		if (!empty ($f_data))
		{
			$f_function = $f_data[0];
			unset ($f_data[0]);

			if ($this->vCallCheck ($f_function))
			{
				if (is_array ($this->functions[$f_function])) { $f_return = (empty ($f_data) ? $this->functions[$f_function][0]->{$this->functions[$f_function][1]} () : call_user_func_array ($this->functions[$f_function],$f_data)); }
				else { $f_return = (empty ($f_data) ? $this->{$f_function} () : call_user_func_array ((array (&$this,$f_function)),$f_data)); }
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -virtualClass->vCall ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Check if a method exists.
	*
	* @param  string $f_function Function name
	* @param  boolean $f_virtual_type True to check for "Virtual Bindings"
	* @return boolean True if the method is available
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vCallCheck ($f_function,$f_virtual_type = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -virtualClass->vCallCheck ($f_function,+f_virtual_type)- (#echo(__LINE__)#)"); }

		$f_data = func_get_args ();
		$f_return = false;

		if ((is_string ($f_function))&&(!empty ($f_function)))
		{
			if (isset ($this->functions[$f_function]))
			{
				if (($f_virtual_type)&&(isset ($this->functions[$f_function]))&&(!empty ($this->functions[$f_function]))) { $f_return = true; }
				elseif ((!$f_virtual_type)&&($this->functions[$f_function])) { $f_return = true; }
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -virtualClass->vCallCheck ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Returns the callable array or false if it is either a invalid function name
	* or not allowed to be a "Virtual Binding".
	*
	* @param  string $f_function Function name
	* @return mixed Callable array or false on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */protected /* #*/function vCallGet ($f_function)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -virtualClass->vCallGet ($f_function)- (#echo(__LINE__)#)"); }
		return ($this->vCallCheck ($f_function,true) ? $this->functions[$f_function] : false);
	}

/**
	* This method is similar to vCall but will return a reference to the
	* resulting object.
	*
	* @param  string $f_function Function name
	* @return mixed Returned data from method (NULL on error)
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function &vCallRref ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -virtualClass->vCallRref (...)- (#echo(__LINE__)#)"); }

		$f_data = func_get_args ();
		$f_return = NULL;

		if (!empty ($f_data))
		{
			$f_function = $f_data[0];
			unset ($f_data[0]);

			if ($this->vCallCheck ($f_function))
			{
				if (is_array ($this->functions[$f_function]))
				{
					if (empty ($f_data)) { $f_return =& $this->functions[$f_function][0]->{$this->functions[$f_function][1]} (); }
					else { $f_return =& call_user_func_array ($this->functions[$f_function],$f_data); }
				}
				else
				{
					if (empty ($f_data)) { $f_return =& $this->{$f_function} (); }
					else { $f_return =& call_user_func_array ((array (&$this,$f_function)),$f_data); }
				}
			}
		}

		return $f_return;
	}

/**
	* Sets and overwrites a "Virtual Binding".
	*
	* @param  string $f_function Function name
	* @return mixed Callable array or false on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vCallSet ($f_function_virtual,&$f_object,$f_function)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -virtualClass->vCallSet ($f_function_virtual,+f_object,$f_function)- (#echo(__LINE__)#)"); }
		$f_return = false;

		if ((is_string ($f_function_virtual))&&(!empty ($f_function_virtual)))
		{
			if (isset ($this->functions[$f_function_virtual]))
			{
				if (is_array ($this->functions[$f_function_virtual]))
				{
					$this->functions[$f_function_virtual] = array ($f_object,$f_function);
					$f_return = true;
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -virtualClass->vCallSet ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Define this class
------------------------------------------------------------------------- */

define ("CLASS_directVirtualClass",true);
}

//j// EOF
?>