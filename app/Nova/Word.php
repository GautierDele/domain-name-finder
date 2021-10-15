<?php

namespace App\Nova;

use App\Nova\Actions\AcceptWord;
use App\Nova\Actions\LikeWord;
use App\Nova\Actions\RefuseWord;
use App\Nova\Filters\StatusFilter;
use App\Nova\Filters\WordLengthFilter;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Word extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Word::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('Name', 'name')->sortable(),
            Badge::make('Status')->map([
                'waiting' => 'info',
                'success' => 'success',
                'like' => 'success',
                'failed' => 'danger',
                'refused' => 'warning',
            ])->sortable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            StatusFilter::make(),
            WordLengthFilter::make(),
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            AcceptWord::make()
                ->canSee(function () {
                    return !$this->resource->exists || $this->resource->status === 'refused' || $this->resource->status === 'liked';
                })
                ->showOnTableRow(),
            RefuseWord::make()
                ->canSee(function () {
                    return !$this->resource->exists || $this->resource->status === 'success' || $this->resource->status === 'liked';
                })
                ->showOnTableRow(),
            LikeWord::make()
                ->canSee(function () {
                    return !$this->resource->exists || $this->resource->status === 'success' || $this->resource->status === 'refused';
                })
                ->showOnTableRow(),
        ];
    }
}
