<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class Validation implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'svg', 'webp', 'ico'];

        return in_array(strtolower(pathinfo($value->getClientOriginalName(), PATHINFO_EXTENSION)), $allowedExtensions);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El archivo debe ser de tipo JPEG, JPG, PNG, GIF, BMP, SVG, WebP o ICO.';
    }
}
