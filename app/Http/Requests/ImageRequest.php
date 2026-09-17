<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'files.*' => 'required|image|mimes:jpg,png,webp,gif|max:10240'
        ];
    }

    public function authorize(): true
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'files.*.required' => 'Выберите хотя бы один файл.',
            'files.*.image' => 'Один из файлов не является изображением.',
            'files.*.mimes' => 'Файлы должны быть в формате: jpg, png, webp или gif.',
            'files.*.max' => 'Каждый файл должен быть не больше 10 МБ.',
        ];
    }
}
