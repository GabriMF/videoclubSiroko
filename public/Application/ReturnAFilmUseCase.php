<?php

declare(strict_types=1);

namespace Application;

use Domain\Film;
use Exception;
use Exceptions\FilmIsRentedException;
use Exceptions\FilmIsNotRentedException;
use Exceptions\FilmNotFoundException;
use Infrastructure\FilmRepository;

final readonly class ReturnAFilmUseCase{

    public function __construct(private FilmRepository $filmRepository)
    {
    }

    /** @throws Exception */
    public function returnAFilm(string $filmTitle): void
    {
        $film = $this->filmRepository->byTitle($filmTitle);

        $this->assertThatFilmExists($film);
        $this->assertThatFilmIsNotRented($film);

        $film->setRent(false);
    }

    /**
     * @throws FilmNotFoundException
     */
    private function assertThatFilmExists(?Film $film): void
    {
        if (null === $film) {
            throw new FilmNotFoundException();
        }
    }

    /**
     * @throws FilmIsNotRentedException
     */
    private function assertThatFilmIsNotRented(Film $film): void{
        
        if ($film->isRented()===false) {
            throw new FilmIsNotRentedException();
        }
    }
}