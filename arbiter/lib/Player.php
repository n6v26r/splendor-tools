<?php

class Player {
  private string $binary;
  public string $name;

  public array $chips;
  public array $cards;
  public array $cardColors;
  public array $reserve; // vector de ReservedCard
  public array $nobles;

  public int $sumTimes;
  public int $maxTime;

  function __construct(string $binary, string $name) {
    $this->binary = $binary;
    $this->name = $name;
    Log::info('Am adăugat jucătorul %s cu binarul %s.', [ $name, $binary ]);

    $this->chips = array_fill(0, Config::NUM_COLORS + 1, 0); // inclusiv 0 aur
    $this->cards = [];
    $this->cardColors = array_fill(0, Config::NUM_COLORS + 1, 0);
    $this->reserve = [];
    $this->nobles = [];

    $this->sumTimes = 0;
    $this->maxTime = 0;
  }

  function getScore(): int {
    $score = count($this->nobles) * Config::NOBLE_POINTS;
    foreach ($this->cards as $id) {
      $score += Card::get($id)->points;
    }
    return $score;
  }

  function countChips(): int {
    return array_sum($this->chips);
  }

  function hasInReserve(int $cardId): bool {
    foreach ($this->reserve as $rc) {
      if ($rc->id == $cardId) {
        return true;
      }
    }
    return false;
  }

  function gainReserve(int $cardId, bool $secret): void {
    $this->reserve[] = new ReservedCard($cardId, $secret);
  }

  // $cardId nu este neapărat în rezervă. Dacă este, șterge-l.
  function loseReserve(int $cardId): void {
    foreach ($this->reserve as $i => $rc) {
      if ($rc->id == $cardId) {
        array_splice($this->reserve, $i, 1);
        return;
      }
    }
  }

  function payForCard(int $id): array {
    $card = Card::get($id);
    $chips = array_fill(0, Config::NUM_COLORS + 1, 0);

    for ($i = 0; $i < Config::NUM_COLORS; $i++) {
      $cost = max($card->cost[$i] - $this->cardColors[$i], 0);
      $actual = min($cost, $this->chips[$i]);
      $jokers = $cost - $actual;
      $this->chips[$i] -= $actual;
      $chips[$i] += $actual;
      $this->chips[Config::NUM_COLORS] -= $jokers;
      $chips[Config::NUM_COLORS] += $jokers;
    }

    return $chips;
  }

  function canBuyCard(int $id): bool {
    $card = Card::get($id);
    $goldNeeded = 0;
    for ($i = 0; $i < Config::NUM_COLORS; $i++) {
      $cost = $card->cost[$i];
      $have = $this->cardColors[$i] + $this->chips[$i];
      if ($cost > $have) {
        $goldNeeded += $cost - $have;
      }
    }
    return ($this->chips[Config::NUM_COLORS] >= $goldNeeded);
  }

  function canReceiveNoble(int $id): bool {
    $noble = Noble::get($id);
    for ($i = 0; $i < Config::NUM_COLORS; $i++) {
      if ($noble->cost[$i] > $this->cardColors[$i]) {
        return false;
      }
    }
    return true;
  }

  // Returnează ID-ul nobilului primit sau 0 dacă jucătorul nu primește niciun
  // nobil. Dacă există mai multe variante, o returnează mereu pe prima.
  function getVisitingNoble(array $nobleIds): int {
    foreach ($nobleIds as $id) {
      if ($this->canReceiveNoble($id)) {
        return $id;
      }
    }
    return 0;
  }

  function gainCard(int $id) {
    $card = Card::get($id);
    $this->cards[] = $id;
    $this->cardColors[$card->color]++;
    $this->loseReserve($id);
  }

  function requestAction(string $gameState): Output {
    Log::info('Aștept o acțiune de la %s', [ $this->name ]);
    $inter = new Interactor($this->binary, $gameState);
    $inter->run();
    $this->updateTimes($inter->getTime());
    return $inter->getOutput();
  }

  private function updateTimes(int $time): void {
    $this->sumTimes += $time;
    $this->maxTime = max($this->maxTime, $time);
  }

  // $reveal: Arătăm sau nu cărțile ascunse?
  function asInputFile(bool $reveal): string {
    $l = [];
    $l[] = implode(' ', $this->chips);
    $l[] = trim(count($this->cards) . ' ' . implode(' ', $this->cards));
    $l[] = $this->getReserveAsInputFile($reveal);
    $l[] = trim(count($this->nobles) . ' ' . implode(' ', $this->nobles));
    return implode("\n", $l);
  }

  function getReserveAsInputFile(bool $reveal): string {
    $arr = [];
    foreach ($this->reserve as $r) {
      if ($reveal || !$r->secret) {
        $arr[] = $r->id;
      } else {
        $arr[] = -Card::get($r->id)->level;
      }
    }
    return trim(count($arr) . ' ' . implode(' ', $arr));
  }

  function print(int $myId): void {
    Log::info('======== Jucătorul %d (%s)', [ $myId, $this->name ]);
    Log::info('    Scor: %d', [ $this->getScore() ]);
    $parts = [];
    for ($col = 0; $col <= Config::NUM_COLORS; $col++) {
      if ($this->cardColors[$col] || $this->chips[$col]) {
        $parts[] = Str::block($col, $this->cardColors[$col]) .
          Str::chips($col, $this->chips[$col]);
      }
    }
    Log::info('    Cărți și jetoane: ' . implode(' ', $parts));
    if (count($this->reserve)) {
      Log::info('    Rezervă:');
      foreach ($this->reserve as $rc) {
        $card = Card::get($rc->id);
        $card->print();
      }
    }
    if (count($this->nobles)) {
      Log::info('    Nobili:');
      foreach ($this->nobles as $id) {
        $noble = Noble::get($id);
        $noble->print();
      }
    }
  }
}
