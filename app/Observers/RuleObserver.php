<?php

namespace App\Observers;

use App\Models\Rule;
use App\Models\Word;
use Illuminate\Support\Facades\Artisan;

class RuleObserver
{
    /**
     * Handle the Rule "created" event.
     *
     * @param  \App\Models\Rule  $rule
     * @return void
     */
    public function created(Rule $rule)
    {
        Artisan::call('rule:apply');
    }

    /**
     * Handle the Rule "updated" event.
     *
     * @param  \App\Models\Rule  $rule
     * @return void
     */
    public function updated(Rule $rule)
    {
        //
    }

    /**
     * Handle the Rule "deleting" event.
     *
     * @param  \App\Models\Rule  $rule
     * @return void
     */
    public function deleting(Rule $rule)
    {
        foreach (Word::where('status', 'refused')->cursor() as $word) {
            if (preg_match('/'.$rule->regex.'/', $word->name)) {
                $word->status = 'success';
                $word->save();
            }
        }
    }

    /**
     * Handle the Rule "deleted" event.
     *
     * @param  \App\Models\Rule  $rule
     * @return void
     */
    public function deleted(Rule $rule)
    {
        //
    }

    /**
     * Handle the Rule "restored" event.
     *
     * @param  \App\Models\Rule  $rule
     * @return void
     */
    public function restored(Rule $rule)
    {
        //
    }

    /**
     * Handle the Rule "force deleted" event.
     *
     * @param  \App\Models\Rule  $rule
     * @return void
     */
    public function forceDeleted(Rule $rule)
    {
        //
    }
}
