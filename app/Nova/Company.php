<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Textarea;
use Waynestate\Nova\CKEditor;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Date;
use \Spatie\NovaTranslatable\Translatable;

use App\Nova\Actions\ApproveCompany;

class Company extends Resource
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
    public static $model = 'App\Company';

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
        'id', 'name', 'phone', 'registration_id', 'description1',
        'description2', 'fb_page', 'linkedin_page', 'web_page'
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
                Text::make('Name')->rules('required', 'string')->sortable(),
                Text::make('Address')->rules('required'),
                CKEditor::make('Description1')->rules('required')->hideFromIndex(),
                Text::make('Mission', 'mission'),
            ]),
            Text::make('Email')
                ->rules('required', 'email')
                ->creationRules('unique:companies,email')
                ->updateRules('unique:companies,email,{{resourceId}}'),
            Text::make('Phone'),
            Text::make('Phone2'),
            Text::make('Registartion ID', 'registration_id')->rules('required'),
            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),
            Text::make('Facebook Page', 'fb_page'),
            Text::make('Linkedin Page', 'linkedin_page'),
            Text::make('Web Page', 'web_page'),
            Boolean::make('Approved'),
            //File::make('Document'),
            Image::make('Image'),
            Image::make('Cover image', 'cover_image'),
            Date::make('Registration Date', 'registration_date'),
            Select::make('Type')->options([
                'local' => 'Local',
                'international' => 'International',
            ]),
            Select::make('Areal')->options([
                'local' => 'Local',
                'international' => 'International',
            ]),
            HasOne::make('Place Of Registration', 'place_of_registration'),
            BelongsToMany::make('Working Regions', 'workingRegions', 'App\Nova\Region'),
            BelongsToMany::make('Working Municipalities', 'workingMunicipalities', 'App\Nova\Municipality'),
            BelongsTo::make('Number Of Employees', 'number_of_employees', 'App\Nova\NumberOfEmployees'),
            BelongsToMany::make('Categories', 'categories', 'App\Nova\Category')->fields(function () {
                return [
                    Textarea::make('Description', 'description')->sortable()
                ];
            }),
            BelongsToMany::make('Roles', 'roles'),
            BelongsToMany::make('Regions', 'regions'),
            BelongsToMany::make('Users', 'users'),
            BelongsToMany::make('Subscribed Companies', 'subscribedCompanies', 'App\Nova\Company'),
            BelongsToMany::make('Subscriber Companies', 'subscriberCompanies', 'App\Nova\Company'),
            HasMany::make('Opportunities', 'opportunities', 'App\Nova\Opportunity'),
            HasMany::make('Query Messages', 'queryMessages', 'App\Nova\QueryMessage'),
            BelongsToMany::make('Favorite Opportunitites', 'favoriteOpportunities', 'App\Nova\Opportunity'),
            HasMany::make('Notifications'),
            BelongsToMany::make('Company Statuses', 'company_statuses', 'App\Nova\CompanyStatus')->fields(function () {
                return [
                    Textarea::make('Description', 'description')->sortable()
                ];
            }),
            BelongsToMany::make('Company Working Types', 'companyWorkingTypes', 'App\Nova\CompanyWorkingType'),
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
        return [
            new ApproveCompany(),
        ];
    }
}
