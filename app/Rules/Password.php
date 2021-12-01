<?php

namespace App\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class Password implements Rule
{
	/**
	 * Determine if the Length Validation Rule passes.
	 *
	 * @var boolean
	 */
	public $lengthPasses = true;

	/**
	 * Determine if the Uppercase Validation Rule passes.
	 *
	 * @var boolean
	 */
	public $uppercasePasses = true;

	/**
	 * Determine if the Numeric Validation Rule passes.
	 *
	 * @var boolean
	 */
	public $numericPasses = true;

	/**
	 * Determine if the Special Character Validation Rule passes.
	 *
	 * @var boolean
	 */
	public $specialCharacterPasses = true;

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param  string  $attribute
	 * @param  mixed  $value
	 * @return bool
	 */
	public function passes($attribute, $value)
	{
		$this->lengthPasses = (Str::length($value) >= 10);
		$this->uppercasePasses = (Str::lower($value) !== $value);
		$this->numericPasses = ((bool) preg_match('/[0-9]/', $value));
		$this->specialCharacterPasses = ((bool) preg_match('/[^A-Za-z0-9]/', $value));

		return ($this->lengthPasses && $this->uppercasePasses && $this->numericPasses && $this->specialCharacterPasses);
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message()
	{
		switch (true) {
			case !$this->uppercasePasses
				&& $this->numericPasses
				&& $this->specialCharacterPasses:
				return 'O :attribute deve ter pelo menos 10 caracteres e conter pelo menos uma letra maiúscula.';

			case !$this->numericPasses
				&& $this->uppercasePasses
				&& $this->specialCharacterPasses:
				return 'O :attribute deve ter pelo menos 10 caracteres e conter pelo menos um número.';

			case !$this->specialCharacterPasses
				&& $this->uppercasePasses
				&& $this->numericPasses:
				return 'O :attribute deve ter pelo menos 10 caracteres e conter pelo menos um caractere especial.';

			case !$this->uppercasePasses
				&& !$this->numericPasses
				&& $this->specialCharacterPasses:
				return 'O :attribute deve ter pelo menos 10 caracteres e conter pelo menos uma letra maiúscula e um número.';

			case !$this->uppercasePasses
				&& !$this->specialCharacterPasses
				&& $this->numericPasses:
				return 'O :attribute deve ter pelo menos 10 caracteres e conter pelo menos uma letra maiúscula e um caractere especial.';

			case !$this->uppercasePasses
				&& !$this->numericPasses
				&& !$this->specialCharacterPasses:
				return 'O :attribute deve ter pelo menos 10 caracteres e conter pelo menos uma letra maiúscula, um número, e um caractere especial.';

			default:
				return 'O :attribute deve ter pelo menos 10 caracteres.';
		}
	}
}
