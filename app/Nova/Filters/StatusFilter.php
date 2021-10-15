<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use OptimistDigtal\NovaMultiselectFilter\MultiselectFilter;

class StatusFilter extends MultiselectFilter
{

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        $query->whereIn('status', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'Success' => 'success',
            'Failed' => 'failed',
            'Waiting' => 'waiting',
            'Refused' => 'refused',
            'Liked' => 'liked'
        ];
    }
}
