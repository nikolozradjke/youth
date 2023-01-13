<?php

namespace App\Nova;

use App\Nova\Actions\ExportCompany;
use App\Nova\Filters\CompanyOrUser;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Waynestate\Nova\CKEditor;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Select;
use \Spatie\NovaTranslatable\Translatable;

class User extends Resource
{
    /**
     * The logical category associated with the resource.
     *
     * @var string
     */
    public static $category = 'Users & user attributes';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\\User';

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
        'id', 'first_name', 'last_name', 'private_number', 'email',
    ];

    public function title()
    {
        return $this->first_name . ' - ' . $this->last_name;
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
                Text::make('First Name', 'first_name')
                    ->sortable()
                    ->rules('required', 'max:255'),

                Text::make('Last Name', 'last_name')
                    ->sortable()
                    ->rules('required', 'max:255')
            ]),
            Boolean::make('ახალგაზრდა მუშაკი', 'company'),
            Date::make('Birth Date', 'birth_date')
                ->rules('required'),

            Text::make('Personal Number', 'private_number')
                ->rules('required', 'min:11', 'max:11'),

            Select::make('Gender')->options([
                'female' => 'female',
                'male' => 'male',
            ])->rules('required'),

            Image::make('Image'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Text::make('Phone')
                ->rules('required', 'max:255'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),

            Boolean::make('Is Complete', 'is_complete'),

            HasOne::make('Place Of Residence', 'place_of_residence'),
            BelongsToMany::make('Roles', 'roles'),
            BelongsToMany::make('Categories', 'categories'),
            BelongsToMany::make('Companies', 'companies'),
            BelongsToMany::make('Favorite Opportunitites', 'favoriteOpportunities', 'App\Nova\Opportunity'),
            BelongsToMany::make('Going Opportunitites', 'goingOpportunities', 'App\Nova\Opportunity')->fields(function () {
                return [
                    Boolean::make('Attended', 'attended'),
                    Boolean::make('Approved', 'approved'),
                    Text::make('Token', 'random_id')
                ];
            }),
            HasMany::make('notifications'),
            BelongsToMany::make('Interacted Query Messages', 'interactedQueryMessages', 'App\Nova\QueryMessage')->fields(function () {
                return [
                    Boolean::make('Liked', 'delta')->sortable(),
                ];
            }),
            BelongsToMany::make('User Disablities', 'userDisabilities', 'App\Nova\UserDisability')->fields(function () {
                return [
                    Textarea::make('Description', 'description')->sortable()
                ];
            }),
            BelongsTo::make('User Occupation', 'userOccupation', 'App\Nova\UserOccupation'),
            BelongsTo::make('User Ocupation Work', 'UserOcupationWork', 'App\Nova\UserOcupationWork'),
            BelongsTo::make('User Ocupation Study', 'UserOcupationStudy', 'App\Nova\UserOcupationStudy'),
            BelongsToMany::make('User Educations', 'userEducations', 'App\Nova\UserEducation'),
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
            new CompanyOrUser()
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
            new ExportCompany()
        ];
    }
}
