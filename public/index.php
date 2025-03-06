<?php

require_once __DIR__ . '/Application/RentAFilmUseCase.php';
require_once __DIR__ . '/Application/ReturnAFilmUseCase.php';
require_once __DIR__ . '/Infrastructure/FilmRepository.php';
require_once __DIR__ . '/Domain/Film.php';
require_once __DIR__ . '/Exceptions/FilmNotFoundException.php';
require_once __DIR__ . '/Exceptions/FilmIsRentedException.php';
require_once __DIR__ . '/Exceptions/FilmIsNotRentedException.php';

/** DDD (Domain Drive Design) */

use Application\RentAFilmUseCase;
use Application\ReturnAFilmUseCase;
use Exceptions\FilmIsRentedException;
use Exceptions\FilmIsNotRentedException;
use Exceptions\FilmNotFoundException;
use Infrastructure\FilmRepository;

$filmTitle = 'Gladiator';

$filmRepository = new FilmRepository();
/*
$useCase = new RentAFilmUseCase($filmRepository);

try {
    $useCase->rentAFilm($filmTitle);
    echo"Pelicula alquilada con exito.";
} catch (FilmNotFoundException|FilmIsRentedException $exception) {
    echo $exception->getMessage();
}
*/

$useCase = new ReturnAFilmUseCase($filmRepository);

try{
    $useCase->returnAFilm($filmTitle);
    echo"Pelicula devuelta con exito.";
}catch(FilmNotFoundException|FilmIsNotRentedException $exception){
    echo $exception->getMessage();
}
