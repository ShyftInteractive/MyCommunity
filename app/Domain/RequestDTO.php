<?php declare(strict_types=1);

namespace App\Domain;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

abstract class RequestDTO {

    protected Collection $items;

    public function __construct(Request $request)
    {
        $this->items = collect($request->input());
    }

    abstract public function toArray(): array;

    public function merge(array $items): void
    {
        $this->items->mergeRecursive($items);
    }

    public function get(string $key): mixed
    {
        return $this->items->get($key);
    }

    public function update(string $key, mixed $value): void
    {
        $this->items->update($key, $value);
    }
}
