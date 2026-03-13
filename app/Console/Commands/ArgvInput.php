<?php

namespace EgorNovikov\TodoCli\Console\Commands;

class ArgvInput 
{
  public function __construct(private array $argv) {}


  public function fromGlobals(): array {
    return [
      'filename' => $this->argv[0],
      'command' => $this->argv[1] ?? null,
      'arguments' => $this->normalizeArguments(array_slice($this->argv, 2) ?? null),
    ];
  }

  public static function normalizeArguments(?array $arguments): ?array {
    if (!$arguments) return null;

    $flags = array_values(array_filter($arguments, fn($arg) => str_starts_with($arg, '--')));

    $attributes = array_map(function($argument) {
      $list = explode('=', $argument);
      return [
        'key' => $list[0],
        'value' => $list[1] ?? null,
      ];
    }, array_filter($arguments, fn($arg) => str_contains($arg, '=') && !str_starts_with($arg, '--')));

    $other = array_filter($arguments, fn($arg) => !str_starts_with($arg, '--') && !str_contains($arg, '='));

    return [
      'flags' => $flags,
      'attributes' => $attributes,
      'other' => $other,
    ];

    
  }
}