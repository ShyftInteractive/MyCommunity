<?php declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Components;

use App\Actions\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ComponentShow extends Controller
{
    public function __invoke(string $componentID, Request $request)
    {
        return Storage::disk('components')->get("{$componentID}.htm");
    }
}
