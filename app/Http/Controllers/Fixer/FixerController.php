<?php

namespace App\Http\Controllers\Fixer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FixerController extends Controller
{
    protected $service;
    public function __construct(FixerService $service)
    {
        $this->service = $service;
    }

    public function proxy(Request $request, $path)
    {
        $request->merge([
            'path' => $path
        ]);

        $validator = Validator::make($request->all(), [
            'path' => 'required|string|in:latest,symbols'
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        return $this->service->proxy($_SERVER['REQUEST_METHOD'], $path);

    }
}
