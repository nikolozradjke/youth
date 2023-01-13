<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Waynestate\Nova\CKEditor;
use \Spatie\NovaTranslatable\Translatable;
use Laravel\Nova\Http\Requests\NovaRequest;

class QueryQuestion extends Resource
{
    /**
     * The logical category associated with the resource.
     *
     * @var string
     */
    public static $category = 'Queries & Query Attributes';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\QueryQuestion';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    public function title()
    {
        return strip_tags($this->text);
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'text', 'details'
    ];

    public static function label()
    {
        return 'Questions';
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
                Text::make('Text')->rules('required'),
                CKEditor::make('Details')->rules('required')->hideFromIndex()
            ]),
            BelongsToMany::make('Queries', 'queries')->fields(function () {
                return [
                    Number::make('Order'),
                ];
            }),
            HasMany::make('Answers', 'answers', 'App\Nova\QueryQuestionAnswer')
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
