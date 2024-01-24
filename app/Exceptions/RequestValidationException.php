<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;

class RequestValidationException extends Exception
{



    public static function validationFail(MessageBag $messages): RequestValidationException
    {
        $resp = [];
        foreach ($messages->toArray() as $key => $msgs) {
            foreach ($msgs as $msg) {
                $resp[] = $msg;
            }
        }
        return new RequestValidationException(implode(',', $resp), 400);
    }

    public function render(Request $request): Response
    {
        return response(view(('components.info.error'),['message'=>$this->getMessage()]),$this->getCode());
    }
}
