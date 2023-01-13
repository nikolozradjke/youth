<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Waynestate\Nova\CKEditor;
use \Spatie\NovaTranslatable\Translatable;

class StaticDataMainPage extends Resource
{
    /**
     * The logical category associated with the resource.
     *
     * @var string
     */
    public static $category = 'pages & Content';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\StaticDataMainPage';

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
        'id',
    ];

    public static function label()
    {
        return 'Main Page Content';
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
                Text::make('User Section Title', 'user_section_title'),
                Text::make('User Section Subtitle', 'user_section_subtitle'),
                CKEditor::make('User Section Text', 'user_section_text')->hideFromIndex(),
            ]),
            Number::make('Order', 'order'),
            Boolean::make('For Company', 'for_company'),
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
