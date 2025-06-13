<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class HSKController extends Controller
{
    public function index()
    {
        return view('hsk.show');
    }

    public function getRandomWord($level)
    {
        $path = public_path("hsk/hsk{$level}.json");

        if (!file_exists($path)) {
            return response()->json(['error' => 'Không tìm thấy file'], 404);
        }

        $data = json_decode(file_get_contents($path), true);
        if (empty($data)) {
            return response()->json(['error' => 'File trống'], 500);
        }

        $randomWord = $data[array_rand($data)];
        return response()->json($randomWord);
    }
}
