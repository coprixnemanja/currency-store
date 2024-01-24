<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DatabaseException extends Exception
{
    


    public static function modelNotFoundException(string $modelName,int $id):DatabaseException{
        return new DatabaseException("$modelName model with id $id not found!!",404);
    }

    public static function connectionException():DatabaseException{
        return new DatabaseException("There was a database connection error.",500);
    }
    public function render(?Request $request): Response
    {
        return response(view(('components.info.error'),['message'=>$this->getMessage()]),$this->getCode());
    }
}
