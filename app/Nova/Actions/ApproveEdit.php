<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

use App\Opportunity;

class ApproveEdit extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach($models as $model)
        {
            $opportunity = Opportunity::find($model->opportunity_id);

            if($model->field == 'file') {
                $opportunity->addMedia($model->value)
                            ->toMediaCollection('file');
                continue;
            }

            $isTranslation = false;
            $exploded = explode("_",$model->field);
            if(count($exploded) == 2 && ($exploded[1] == 'ka' || $exploded[1] == 'en'))
            {
                $isTranslation = true;
            }
            if($isTranslation)  
            {
                $opportunity->setTranslation($exploded[0], $exploded[1], $model->value);
            }
            else
            {
                $opportunity->{$model->field} = $model->value;
            }

            $opportunity->update();
            $model->forceDelete();
        }

        return Action::message('Edit approved');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
