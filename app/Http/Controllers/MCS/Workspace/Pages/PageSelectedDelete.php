<?php

declare(strict_types=1);

namespace App\Http\Controllers\MCS\Workspace\Pages;

use App\Actions\Action;
use Illuminate\Http\Request;
use Dompdf\FrameReflower\Page;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class PageSelectedDelete extends Controller
{
    public function __invoke(Request $request)
    {
        Page::destroy($request->input('selected'));

        return redirect()->back()->with(['success' => 'Pages Removed']);
    }
}
