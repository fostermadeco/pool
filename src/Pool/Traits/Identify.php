<?php

namespace FosterMadeCo\Pool\Traits;

use FosterMadeCo\Pool\Calls\Identify as IdentifyCall;

trait Identify
{
    public static function bootIdentify()
    {
        static::created(function($model) {
            // Check the model to see if it is in a state for it to be sent to Segment
            if (!method_exists($model, 'canIdentify') || $model->canIdentify()) {
                IdentifyCall::call($model);
            }
        });

        static::updated(function($model) {
            // Check the model to see if it is in a state for it to be sent to Segment
            // TODO (maybe) - only update if the traits are dirty. This is complicated
            // because not all traits may be attributes of the model, so we'd need to
            // engineer a solution to check if those had changed since the model was
            // loaded. This is a 'maybe' not because this may be difficult, but because
            // it may be standard to make the Identify call when the model is updated
            // even if the traits aren't dirty.
            // TODO (maybe) - have a way for this to be triggered when one of its traits
            // that is a related model is updated.
            if (!method_exists($model, 'canIdentify') || $model->canIdentify()) {
                IdentifyCall::call($model);
            }
        });
    }
}