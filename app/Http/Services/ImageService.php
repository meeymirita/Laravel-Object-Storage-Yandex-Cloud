<?php

namespace App\Http\Services;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class ImageService
{
    /**
     * @param $files
     * @return JsonResponse
     */
    public function storeFiles($files): \Illuminate\Http\JsonResponse
    {
        $path_pull = [];
        $count = 0;
        foreach ($files as $file) {

            $path = 'anime/' . $this->createNameFile($file);

            Storage::disk('s3')->put(
                $path,
                file_get_contents($file->getRealPath())
            );

            $path_pull[] = $path;
            $count+= 1;
        }
        return response()->json([
            'paths' => $path_pull,
            'count' => $count,
        ]);
    }

    /**
     * @param $file
     * @return string
     */
    private function createNameFile($file): string
    {
        $name = Str::lower(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        return $name . '-' . date('Y-m-d_H-i-s') . '.' . $file->extension();
    }

    public function getAllFiles(): \Illuminate\Pagination\LengthAwarePaginator
    {
        $perPage = 10;
        $page = request()->integer('page', 1);

        $files = collect(Storage::disk('s3')->files('anime'))
            ->map(fn (string $path) => [
                'path' => $path,
                'url' => Storage::disk('s3')->url($path),
            ]);

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $files->forPage($page, $perPage)->values(),
            $files->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }


}