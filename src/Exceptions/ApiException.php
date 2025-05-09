<?php

namespace Jollystrix\RemnawaveApi\Exceptions;

use Exception;

class ApiException extends Exception
{
	public function __construct(string $message = "API Error", int $code = 0, ?Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}
