<?php
	// we will only need sessions when we use this file.
	session_start();

	// removes all form data from the session.
	function clear_formdata()
	{
		$_SESSION['formdata'] = [];
	}

	// retrieves the form data we stored in a session, and clears the same session.
	function get_formdata()
	{
		// retrieve the form data into a variable.
		$data = isset($_SESSION['formdata']) ? $_SESSION['formdata'] : [];

		// clear the information from the session.
		clear_formdata();

		// give the other page this information.
		return $data;
	}

	// retrieves the value of an item.
	function get_value($haystack = [], $needle = '')
	{
		if (!isset($haystack[$needle]) || !isset($haystack[$needle]['value']))
		{
			return '';
		}

		return htmlspecialchars($haystack[$needle]['value']);
	}

	// checks if the form key has any errors.
	function get_error($haystack = [], $needle = '')
	{
		if (!isset($haystack[$needle]) || !isset($haystack[$needle]['error']))
		{
			return '';
		}

		return $haystack[$needle]['error'];
	}

	// checks if the form key has any errors.
	function has_error($haystack = [], $needle = '')
	{
		if (!isset($haystack[$needle]) || !isset($haystack[$needle]['error']))
		{
			return FALSE;
		}

		return $haystack[$needle]['error'] !== FALSE;
	}

	// places an error into our sessioned information.
	function set_error($key, $error = FALSE)
	{
		// if there is no form data set, we'll create a new template.
		if (!isset($_SESSION['formdata']))
		{
			$_SESSION['formdata'] = [
				$key => [
					'value'	=> '',
					'error'	=> $error
				]
			];
		}

		//  if there is form data but no key.
		else if (!isset($_SESSION['formdata'][$key]))
		{
			$_SESSION['formdata'][$key] = [
				'value'	=> '',
				'error'	=> $error
			];
		}

		// if everything is fine.
		else
		{
			$_SESSION['formdata'][$key]['error'] = $error;
		}

		return TRUE;
	}

	// stores the form inputs in a session.
	// we can set the information using a custom parameter.
	function set_formdata($info = [])
	{
		// the inputs will be stored in arrays for easy access.
		clear_formdata();

		foreach ($info as $input => $value)
		{
			$_SESSION['formdata'][$input] = [
				'value'		=> $value,
				'error'		=> FALSE
			];
		}
	}

	// Converts database records into formdata we can use.
	function to_formdata($info = [])
	{
		foreach ($info as $input => $value)
		{
			$info[$input] = [
				'value'		=> $value,
				'error'		=> FALSE
			];
		}

		return $info;
	}
?>
