<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Waynestate\Nova\CKEditor;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Http\Requests\NovaRequest;

class QueryMessage extends Resource
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
    public static $model = 'App\QueryMessage';

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
        'id', 'message'
    ];

    public static function label()
    {
        return 'Messages';
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
            CKEditor::make('Message')->rules('required')->hideFromIndex(),
            Boolean::make('Private', 'is_private'),
            //Number::make('Likes')->rules('required')->sortable(),
            //Number::make('Dislikes')->rules('required')->sortable(),
            BelongsTo::make('User', 'user'),
            BelongsTo::make('Opportunity', 'opportunity')->nullable(),
            BelongsTo::make('Company', 'company')->nullable(),
            BelongsToMany::make('Interacted Users', 'interactedUsers', 'App\Nova\User')->fields(function () {
                return [
                    Boolean::make('Liked', 'delta')->sortable(),
                ];
            })
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
