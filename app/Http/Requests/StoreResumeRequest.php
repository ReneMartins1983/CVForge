<?php

namespace App\Http\Requests;

use App\Models\Resume;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreResumeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * O builder envia o currículo serializado no campo "payload".
     * Decodificamos para "data" antes de validar.
     */
    protected function prepareForValidation(): void
    {
        $decoded = json_decode((string) $this->input('payload'), true);

        $this->merge([
            'data' => is_array($decoded) ? $decoded : [],
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:120'],
            'template' => ['required', Rule::in(array_keys(Resume::TEMPLATES))],
            'photo' => ['nullable', 'image', 'max:2048'],

            'data' => ['required', 'array'],
            'data.personal' => ['required', 'array'],
            'data.personal.name' => ['required', 'string', 'max:120'],
            'data.personal.title' => ['nullable', 'string', 'max:120'],
            'data.personal.email' => ['nullable', 'email', 'max:120'],
            'data.personal.phone' => ['nullable', 'string', 'max:60'],
            'data.personal.location' => ['nullable', 'string', 'max:120'],
            'data.personal.website' => ['nullable', 'string', 'max:200'],
            'data.personal.linkedin' => ['nullable', 'string', 'max:200'],
            'data.personal.github' => ['nullable', 'string', 'max:200'],
            'data.personal.summary' => ['nullable', 'string', 'max:2000'],

            'data.experiences' => ['array'],
            'data.experiences.*.role' => ['nullable', 'string', 'max:120'],
            'data.experiences.*.company' => ['nullable', 'string', 'max:120'],
            'data.experiences.*.start' => ['nullable', 'string', 'max:40'],
            'data.experiences.*.end' => ['nullable', 'string', 'max:40'],
            'data.experiences.*.description' => ['nullable', 'string', 'max:2000'],

            'data.education' => ['array'],
            'data.education.*.degree' => ['nullable', 'string', 'max:120'],
            'data.education.*.institution' => ['nullable', 'string', 'max:120'],
            'data.education.*.start' => ['nullable', 'string', 'max:40'],
            'data.education.*.end' => ['nullable', 'string', 'max:40'],
            'data.education.*.description' => ['nullable', 'string', 'max:2000'],

            'data.skills' => ['array'],
            'data.skills.*' => ['string', 'max:60'],

            'data.projects' => ['array'],
            'data.projects.*.name' => ['nullable', 'string', 'max:120'],
            'data.projects.*.link' => ['nullable', 'string', 'max:200'],
            'data.projects.*.description' => ['nullable', 'string', 'max:2000'],

            'data.languages' => ['array'],
            'data.languages.*.name' => ['nullable', 'string', 'max:60'],
            'data.languages.*.level' => ['nullable', 'string', 'max:60'],
        ];
    }

    public function messages(): array
    {
        return [
            'data.personal.name.required' => 'Informe ao menos o nome no currículo.',
        ];
    }
}
