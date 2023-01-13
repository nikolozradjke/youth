<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Waynestate\Nova\CKEditor;
use Laravel\Nova\Http\Requests\NovaRequest;
use \Spatie\NovaTranslatable\Translatable;

class QueryUnattendedQuestionOption extends Resource
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
    public static $model = 'App\QueryUnattendedQuestionOption';

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
        'id', 'text'
    ];

    public static function label()
    {
        return 'Unattended Question Options';
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
                Text::make('Text')->rules('required')->sortable()
            ]),
            Boolean::make('Has Text Field', 'has_text_field'),
            BelongsTo::make('Question', 'question', 'App\Nova\QueryUnattendedQuestion'),
            HasMany::make('Answers', 'answers', 'App\Nova\QueryUnattendedQuestionAnswer')
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
