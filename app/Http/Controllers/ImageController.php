<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Services\ImageService;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    private ImageService $imageService;
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        return $this->imageService->getAllFiles();
    }

    /**
     * @param ImageRequest $request
     * @return JsonResponse
     */
    public function upload(ImageRequest $request) : JsonResponse
    {
        $images = $request->validated();
        return $this->imageService->storeFiles($images['files']);
    }
}
