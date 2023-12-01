<?php

namespace App\Http\Controllers;

use App\Models\WebAnalysis;
use Illuminate\Http\Request;

class WebAnalyticsController extends Controller
{
    public function store(Request $request)
    {
        $newRecord = new WebAnalysis();

        $newRecord->type = $request->type;
        $newRecord->save();
    }
}
