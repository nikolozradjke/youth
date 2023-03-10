<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\NovaTranslatable\Translatable;

class CompanyWorkingType extends Resource
{
    /**
     * The logical category associated with the resource.
     *
     * @var string
     */
    public static $category = 'Organizations & org. attributes';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\CompanyWorkingType';

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
            ID::make()->sortable(),
            Translatable::make([
                Text::make('Name', 'name')
                    ->sortable()
                    ->rules('required', 'max:255'),
            ]),
            Translatable::make([
                Text::make('Description', 'description')
                    ->sortable()
                    ->rules('required', 'max:255'),
            ]),
            Boolean::make('can_be_filled'),
            HasMany::make('Company Working Subtype', 'CompanyWorkingSubtype', 'App\Nova\CompanyWorkingSubtype'),
            BelongsToMany::make('Companies', 'companies', 'App\Nova\Company'),
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
        return [];
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
        return [];
    }
}
