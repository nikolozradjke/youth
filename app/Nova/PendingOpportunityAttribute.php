<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Waynestate\Nova\CKEditor;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Actions\ApproveEdit;
use \Spatie\NovaTranslatable\Translatable;

class PendingOpportunityAttribute extends Resource
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
    public static $model = 'App\PendingOpportunityAttribute';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    public function title()
    {
        return $this->opportunity_id . ' - ' . $this->field;
    }

    public static function label() {
        return 'Pending Changes';
    }
    
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
            Select::make('Field')->options([
                'name_ka' => 'name_ka',
                'name_en' => 'name_en',
                'date_ka' => 'date_ka',
                'date_en' => 'date_en',
                'description_ka' => 'description_ka',
                'description_en' => 'description_en',
                'address_ka' => 'address_ka',
                'address_en' => 'address_en',
                'start_date' => 'start_date',
                'end_date' => 'end_date',
                'schedule_date' => 'schedule_date',
                'opportunity_status_id' => 'opportunity_status_id',
                'image' => 'image',
                'latitude' => 'latitude',
                'longitude' => 'longitude',
                'fb_page' => 'fb_page',
                'linkedin_page' => 'linkedin_page',
                'web_page' => 'web_page',
                'phone' => 'phone',
                'application_url' => 'application_url',
                'email' => 'email',
                //'file' => 'file'
            ]),
            CKEditor::make('Value'),
            BelongsTo::make('Opportunity', 'opportunity')
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
            new ApproveEdit
        ];
    }
}
