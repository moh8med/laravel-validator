<?php namespace Moh8med\LaravelValidator;

use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Validator;
use Symfony\Component\Translation\TranslatorInterface;

class LaravelValidator extends Validator {

	/**
	 * The numeric related validation rules.
	 *
	 * @var array
	 */
	protected $customNumericRules = array('Intval', 'Unsigned', 'Float', 'Price');

	/**
	 * Custom validation rules that imply the field is required.
	 *
	 * @var array
	 */
	protected $customImplicitRules = array('Trim', 'ToLower', 'ToUpper', 'Intval', 'Unsigned', 'Float', 'Price', 'Md5', 'CurrentIp');

	/**
	 * Create a new Validator instance.
	 *
	 * @param  \Symfony\Component\Translation\TranslatorInterface  $translator
	 * @param  array  $data
	 * @param  array  $rules
	 * @param  array  $messages
	 * @param  array  $customAttributes
	 * @return void
	 */
	public function __construct(TranslatorInterface $translator, array $data, array $rules, array $messages = array(), array $customAttributes = array())
	{
		parent::__construct($translator, $data, $rules, $messages, $customAttributes);

		// add custom numeric rules
		$this->numericRules = array_merge($this->numericRules, $this->customNumericRules);

		// add custom implicit rules
		$this->implicitRules = array_merge($this->implicitRules, $this->customImplicitRules);
	}

	/**
	 * Trim an attribute value
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @param  array   $parameters
	 * @return bool
	 */
	protected function validateTrim($attribute, $value)
	{
		Request::merge([ $attribute => trim((string) Request::get($attribute)) ]);
		return true;
	}

	/**
	 * Convert an attribute value to lowercase
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validateToLower($attribute, $value)
	{
		Request::merge([ $attribute => strtolower((string) Request::get($attribute)) ]);
		return true;
	}

	/**
	 * Convert an attribute value to uppercase
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validateToUpper($attribute, $value)
	{
		Request::merge([ $attribute => strtoupper((string) Request::get($attribute)) ]);
		return true;
	}

	/**
	 * Convert an attribute value to signed decimal number (negative, zero or positive)
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validateIntval($attribute, $value)
	{
		Request::merge([ $attribute => intval(Request::get($attribute)) ]);
		return true;
	}

	/**
	 * Convert an attribute value to unsigned decimal number (equal to or greater than 0)
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validateUnsigned($attribute, $value)
	{
		$value = ($value = (int) Request::get($attribute)) < 0 ? -$value : $value;

		Request::merge([ $attribute => $value ]);
		return true;
	}

	/**
	 * Convert an attribute value to floating-point number
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validateFloat($attribute, $value)
	{
		Request::merge([ $attribute => (float) Request::get($attribute) ]);
		return true;
	}

	/**
	 * Convert an attribute value to currency number format (e.g: 1.00, 5.49, 0.99, etc..)
	 *
	 * To add commas to the convrted value use number_format() function
	 * example: echo '$'.number_format($converted_value);
	 * The above line will convert 1999.49 to $1,999.49
	 * 
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validatePrice($attribute, $value)
	{
		Request::merge([ $attribute => sprintf('%0.2f', Request::get($attribute)) ]);
		return true;
	}

	/**
	 * Convert an attribute value to md5 hash string
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validateMd5($attribute, $value)
	{
		Request::merge([ $attribute => md5((string) Request::get($attribute)) ]);
		return true;
	}

	/**
	 * Convert an attribute value to current user IP address (e.g: 127.0.0.1)
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validateCurrentIp($attribute, $value)
	{
		Request::merge([ $attribute => (string) _current_ip() ]);
		return true;
	}

}