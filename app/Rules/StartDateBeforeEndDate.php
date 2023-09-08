<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class StartDateBeforeEndDate implements Rule
{
    public function passes($attribute, $value)
    {
        // Retrieve the start date from the request data
        $startDate = Carbon::parse(request()->input('startDate'));
        
        // Parse the end date provided as the value
        $endDate = Carbon::parse($value);

        // Check if start date is before or equal to end date
        return $startDate->lte($endDate);
    }

    public function message()
    {
        return 'The start date must be before or equal to the end date.';
    }
}
