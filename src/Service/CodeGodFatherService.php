<?php
namespace App\Service;

class CodeGodFatherService
{
	public function generateCode()
	{
		$alfa='abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
    	return substr(str_shuffle($alfa),0,8);

	}
}