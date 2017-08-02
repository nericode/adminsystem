<?php

namespace App\src\Common;

class Alert
{
	public function message($message, $response)
	{
		session()->flash('alert', $message);
        session()->flash('response', $response);
	}
}