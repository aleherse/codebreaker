<?php

namespace PcComponentes\Codebreaker\View;

use Knp\Component\Pager\Pagination\AbstractPagination;
use PcComponentes\Codebreaker\Codebreaker;
use PcComponentes\Codebreaker\GameStats;

interface View
{
    public function welcome(Codebreaker $codebreaker): void;

    public function readGuess(Codebreaker $codebreaker): ?string;

    public function notAValidGuess(): void;

    public function guessMatches(Codebreaker $codebreaker): void;

    public function endOfGame(Codebreaker $codebreaker): void;

    public function chooseGame(array $games): ?Codebreaker;

    public function showStats(GameStats $stats);

    public function showPlayedGames(AbstractPagination $games);
}
