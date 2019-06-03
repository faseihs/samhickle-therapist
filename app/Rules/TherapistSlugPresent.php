<?php

namespace App\Rules;

use App\Model\Therapist;
use Illuminate\Contracts\Validation\Rule;

class TherapistSlugPresent implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        $therapist = Therapist::findBySlug($value);
        return $therapist?true:false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute does not match any record';
    }
}
