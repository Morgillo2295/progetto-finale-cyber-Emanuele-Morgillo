<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    private const ROLE_FIELDS = ['is_admin', 'is_revisor', 'is_writer'];

    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user()->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Campi ammessi per il mass assignment sul profilo.
     */
    public function profileAttributes(): array
    {
        $data = $this->safe()->only(['name', 'email']);

        if ($this->filled('password')) {
            $data['password'] = $this->input('password');
        }

        return $data;
    }

    public function attemptedRoleEscalation(): bool
    {
        foreach (self::ROLE_FIELDS as $field) {
            if ($this->has($field)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return list<string>
     */
    public function submittedRoleFields(): array
    {
        return array_values(array_filter(
            self::ROLE_FIELDS,
            fn (string $field) => $this->has($field)
        ));
    }
}
