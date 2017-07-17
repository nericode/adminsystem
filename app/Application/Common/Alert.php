<?php

namespace App\Application\Common;

class Alert
{
	public function message($message, $response)
	{
		session()->flash('alert', $message);
        session()->flash('response', $response);
	}

	public function flush()
	{
		session()->flush();
	}
}