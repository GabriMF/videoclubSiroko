<?php

declare(strict_types=1);

namespace Exceptions;

use Exception;

final class FilmIsNotRentedException extends Exception{
    
    public function __construct() {
        parent::__construct("La película que deseas devolver no estaba alquilada");
    }
}