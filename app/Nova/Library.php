<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use \Spatie\NovaTranslatable\Translatable;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Boolean;

class Library extends Resource
{
    public static function label() {
        return 'ბიბლიოთეკა';
    }
    public static $category = 'ბიბლიოთეკა & აქტივობები';
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Library';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name'
    ];
    
    public static function relatableUsers(NovaRequest $request, $query)
    {
        return $query->where('company', 1);
    }

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
                Text::make('Name')->rules('required', 'string')->sortable()
            ]),
            Text::make('Youtube')->rules('string')->sortable(),
            BelongsTo::make('Category', 'category', 'App\Nova\LibraryCategory')->nullable(),
            BelongsTo::make('Company', 'company')->nullable(),
            BelongsTo::make('User', 'user')->nullable(),
            File::make('file'),
            Boolean::make('Status')
                ->trueValue(1)
                ->falseValue(0),
            Boolean::make('Research')
                ->trueValue(1)
                ->falseValue(0)    
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
