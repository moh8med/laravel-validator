<?php

/**
 * Get current user IP address
 *
 * @return string             IP address (e.g: 127.0.0.1)
 */
if ( ! function_exists('_current_ip'))
{
function _current_ip()
{
	if (isset($_SERVER['HTTP_CLIENT_IP']) && ! empty($_SERVER['HTTP_CLIENT_IP']))
	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ! empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
	}

	return ( filter_var($ip, FILTER_VALIDATE_IP) !== false ) ? $ip : null;
}
}
