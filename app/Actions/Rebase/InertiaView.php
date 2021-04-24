<?php declare(strict_types=1);

namespace App\Actions\Rebase;

use ReflectionClass;
use Illuminate\Support\Str;
use App\Contracts\Rebase\Actionable;

class InertiaView implements Actionable
{
    public static function handle(...$payload): string
    {
        [$class, $name] = $payload;

        $fullControllerPath = (new ReflectionClass($class))->name;

        $controllerName = Str::afterLast($fullControllerPath, '\\');
        $swappedName = str_replace($controllerName, $name, $fullControllerPath);

        return config('paths.views.pages').str_replace(ucfirst(config('paths.controllers')), '', str_replace('\\', '/', $swappedName));
    }
}
