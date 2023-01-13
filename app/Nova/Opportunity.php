<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Waynestate\Nova\CKEditor;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Http\Requests\NovaRequest;
use \Spatie\NovaTranslatable\Translatable;
use Ebess\AdvancedNovaMediaLibrary\Fields\Files;

class Opportunity extends Resource
{
    /**
     * The logical category associated with the resource.
     *
     * @var string
     */
    public static $category = 'Opportunities & Opp. Attributes';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Opportunity';

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
                Text::make('Name')->rules('required', 'string')->sortable(),
                CKEditor::make('Description')->rules('required')->hideFromIndex(),
                CKEditor::make('Address')->rules('required_if:is_virtual,==,0')->hideFromIndex()
            ]),
            Text::make('Phone'),
            Number::make('min_age'),
            Number::make('max_age'),
            Text::make('Email')->rules('email', 'max:254')->creationRules('nullable')->updateRules('nullable'),
            Text::make('Latitude')->hideFromIndex(),
            Text::make('Longitude')->hideFromIndex(),
            Date::make('Start Date', 'start_date')->rules('required'),
            Date::make('End Date', 'end_date')->rules('required'),
            Date::make('Schedule Date', 'schedule_date')->rules('required'),
            Number::make('Order')->step(1),
            Image::make('Image'),
            Text::make('Facebook Page', 'fb_page'),
            Text::make('Linkedin Page', 'linkedin_page'),
            Text::make('Web Page', 'web_page'),
            Text::make('Application Url', 'application_url'),
            Boolean::make('Is Draft?', 'is_draft'),
            Boolean::make('Inactive?', 'inactive'),
            Boolean::make('Is Virtual', 'is_virtual'),
            Text::make('Virtual Link', 'vitual_link'),
            Text::make('Live Translation Link', 'live_translation_link'),

            //File::make('Files', 'file')->path('opportunity_files'),
            Files::make('Files', 'file'),
            Boolean::make('Query Sent', 'query_sent'),
            BelongsTo::make('Company', 'company')->nullable(),
            BelongsTo::make('User', 'user')->nullable(),
            HasMany::make('Pending Opportunity Attributes', 'pending_opportunity_attributes'),
            BelongsToMany::make('Categories', 'categories'),
            BelongsToMany::make('Regions', 'regions'),
            BelongsTo::make('Query', 'get_query', 'App\Nova\Query')->nullable(),
            HasMany::make('Query Messages', 'queryMessages', 'App\Nova\QueryMessage'),
            BelongsToMany::make('Favorite Companies', 'favoriteCompanies', 'App\Nova\Company'),
            BelongsToMany::make('Favorite Users', 'favoriteUsers', 'App\Nova\User'),
            BelongsToMany::make('Going Users', 'goingUsers', 'App\Nova\User')->fields(function () {
                return [
                    Boolean::make('Attended', 'attended'),
                    Boolean::make('Approved', 'approved'),
                    Text::make('Token', 'random_id')
                ];
            }),
            BelongsToMany::make('Subtypes', 'opportunity_subtypes', 'App\Nova\OpportunitySubtype'),
            BelongsToMany::make('Municipalities', 'municipalities'),
            BelongsToMany::make('Disabilities', 'disabilities', 'App\Nova\Disability'),
            HasMany::make('FAQs', 'faqs', 'App\Nova\FAQ'),
            HasMany::make('Media', 'opportunity_medias', 'App\Nova\OpportunityMedia')
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
