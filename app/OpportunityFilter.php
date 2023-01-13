<?php

namespace App;

use App\Opportunity;
use DB;

use function GuzzleHttp\Promise\queue;

class OpportunityFilter
{

    private static $filterKeysArr = array(
        // 'regions' => 'App\OpportunityFilter::filterByRegions',
        'companies' => 'App\OpportunityFilter::filterByCompanies',
        'types' => 'App\OpportunityFilter::filterByTypes', // 0
        'subtypes' => 'App\OpportunityFilter::filterBySubtypes', // 1
        'categories' => 'App\OpportunityFilter::filterByCategories', // 2
        'municipalities' => 'App\OpportunityFilter::filterByMunicipalities', // 3
        'disabilities' => 'App\OpportunityFilter::filterByDisabilities', // 5
        'minAge' => 'App\OpportunityFilter::filterByMinAge', // 6
        'maxAge' => 'App\OpportunityFilter::filterByMaxAge', // 7
    );


    private static $orderKeysArr = array(
        'start_date' => 'App\OpportunityFilter::orderByStartDate',
        'schedule_date' => 'App\OpportunityFilter::orderByAddDate',
        'order' => 'App\OpportunityFilter::orderByOrder'
    );


    private static function filterByRegions($query = null, $ids)
    {
        if (!$ids || count($ids) == 0) {
            return $query;
        }
        if (!$query) {
            $query = new Opportunity();
        }
        return $query->whereHas('regions', function ($q) use ($ids) {
            $q->whereIn('region_id', $ids)->orWhere('is_general', 1);
        });
    }

    // Page Filter 0: Type  
    private static function filterByTypes($query = null, $ids)
    {
        // dd($ids);
        if (!$ids || count($ids) == 0 || in_array('all', $ids)) {
            return $query;
        }
        if (!$query) {
            $query = new Opportunity();
        }
        return $query->whereHas('opportunity_subtypes', function ($q) use ($ids) {
            $q->whereHas('opportunity_type', function ($p) use ($ids, $q) {
                $p->whereIn('opportunity_type_id', $ids);
            });
        });
    }


    // Events filter 1: Subtypes  
    private static function filterBySubtypes($query = null, $ids)
    {
        if (!$ids || count($ids) == 0) {
            return $query;
        }
        if (!$query) {
            $query = new Opportunity();
        }
        return $query->whereHas('opportunity_subtypes', function ($q) use ($ids) {
            $q->whereIn('opportunity_subtype_id', $ids);
        });
    }

    // Events filter 2: Categories  
    private static function filterByCategories($query = null, $ids)
    {
        if (!$ids || count($ids) == 0) {
            return $query;
        }
        if (!$query) {
            $query = new Opportunity();
        }

        return $query->whereHas('categories', function ($q) use ($ids) {
            $q->whereIn('category_id', $ids);
        });
    }

    // Events filter 3: Municipalities
    private static function filterByMunicipalities($query = null, $ids)
    {
        if (!$ids || count($ids) == 0) {
            return $query;
        }
        if (!$query) {
            $query = new Opportunity();
        }
        return $query->whereHas('municipalities', function ($q) use ($ids) {
            $q->whereIn('municipality_id', $ids);
        });
    }

    // Events filter 4: Disabilities
    private static function filterByDisabilities($query = null, $ids)
    {
        if (!$ids || count($ids) == 0) {
            return $query;
        }
        if (!$query) {
            $query = new Opportunity();
        }
        return $query->whereHas('disabilities', function ($q) use ($ids) {
            $q->whereIn('disability_id', $ids);
        });
    }

    // Events filter 5: Min Age
    private static function filterByMinAge($query = null, $ids)
    {
        if (!$ids) {
            return $query;
        }
        if (!$query) {
            $query = new Opportunity();
        }
        return $query->where('max_age', '>=', $ids)->orWhereNull('max_age');
    }

    // Events filter 6: Max Age
    private static function filterByMaxAge($query = null, $ids)
    {
        if (!$ids) {
            return $query;
        }
        if (!$query) {
            $query = new Opportunity();
        }
        return $query->where('min_age', '<=', $ids)->orWhereNull('min_age');
    }

    private static function filterByCompanies($query = null, $ids)
    {
        if (!$ids || count($ids) == 0) {
            return $query;
        }
        if (!$query) {
            $query = new Opportunity();
        }
        return $query->whereIn('company_id', $ids);
    }

    private static function orderByAddDate($query = null, $order)
    {
        if (!$query) {
            $query = new Opportunity();
        }
        return $query->orderBy('schedule_date', $order);
    }

    private static function orderByOrder($query = null, $order)
    {
        if (!$query) {
            $query = new Opportunity();
        }
        return $query->orderBy('order', $order)->take(5);
    }

    private static function orderByStartDate($query = null, $order)
    {
        if (!$query) {
            $query = new Opportunity();
        }
        return $query->orderByRaw('CASE WHEN start_date < NOW() THEN end_date WHEN start_date >= NOW() THEN start_date ELSE 9999-12-31 END ASC');
    }

    private static function buildSubscribeQuery($query, $subscribedCompanies, $subscribedCategories)
    {
        if (!$query) {
            $query = new Opportunity();
        }

        if (count($subscribedCompanies) && count($subscribedCategories)) {
            return $query->where(function ($q) use ($subscribedCompanies, $subscribedCategories) {
                $q->whereHas('categories', function ($q) use ($subscribedCategories) {
                    $q->whereIn('category_id', $subscribedCategories);
                })
                    ->orWhereIn('company_id', $subscribedCompanies);
            });
        } elseif (count($subscribedCompanies)) {
            return $query->whereIn('company_id', $subscribedCompanies);
        } elseif (count($subscribedCategories)) {
            return $query->whereHas('categories', function ($q) use ($subscribedCategories) {
                $q->whereIn('category_id', $subscribedCategories);
            });
        }
        return $query;
    }

    public static function getSubscribedOnly($subscribedCompanies, $subscribedCategories, $limit)
    {
        return Opportunity::select('opportunities.*')->where(function ($q) use ($subscribedCompanies, $subscribedCategories) {
            $q->whereHas('categories', function ($q) use ($subscribedCategories) {
                $q->whereIn('category_id', $subscribedCategories);
            })
                ->orWhereIn('company_id', $subscribedCompanies);
        })->with(['company', 'categories'])->orderBy('schedule_date', 'asc')->take($limit)
            ->join('companies', function ($join) {
                $join->on('opportunities.company_id', '=', 'companies.id');
            })->where([['companies.approved', 1], ['is_draft', 0], ['inactive', 0]])->get();
    }

    public static function filterOpportunities($filterData = [], $orderKey = null, $order = 'desc', $skip = 0, $limit = null, $return_query = false, $subscribe_query = false)
    {
        $query = Opportunity::select('opportunities.*')->whereRaw('schedule_date <= NOW()')->join('companies', function ($join) {
            $join->on('opportunities.company_id', '=', 'companies.id');
        })->where([['companies.approved', 1], ['is_draft', 0], ['inactive', 0]]);
        if ($subscribe_query === 'true' || $subscribe_query) {
            $subscribe_query = true;
        } else {
            $subscribe_query = false;
        }
        if ($subscribe_query) {
            $user = null;
            if (auth()->guard('web')->check()) {
                $user = auth()->guard('web')->user();
            } elseif (auth()->guard('company')->check()) {
                $user = auth()->guard('company')->user();
            }
            if (isset($user)) {
                $subscribedCompanies = [];
                $subscribedCategories = [];

                $otherCompanies = [];
                $otherCategories = [];

                if (isset($filterData['categories'])) {
                    $categories = $filterData['categories'];
                    foreach ($categories as $categoryId) {
                        if ($user->isSubscribedToCategory($categoryId)) {
                            $subscribedCategories[] = $categoryId;
                        } else {
                            $otherCategories[] = $categoryId;
                        }
                    }
                    $filterData['categories'] = $otherCategories;
                } else {
                    $subscribedCategories = $user->subscribedCategories->pluck('id')->toArray();
                }
                if (isset($filterData['companies'])) {
                    $companies = $filterData['companies'];
                    foreach ($companies as $companyId) {
                        if ($user->isSubscribedToCompany($companyId)) {
                            $subscribedCompanies[] = $companyId;
                        } else {
                            $otherCompanies[] = $companyId;
                        }
                    }
                    $filterData['companies'] = $otherCompanies;
                }
                $query = OpportunityFilter::buildSubscribeQuery($query, $subscribedCompanies, $subscribedCategories);
            }
        }

        foreach ($filterData as $filterKey => $filterValue) {
            $function = OpportunityFilter::$filterKeysArr[$filterKey];
            if ($function)
                $query = call_user_func($function, $query, $filterValue);
        }
        if ($orderKey) {
            $function = OpportunityFilter::$orderKeysArr[$orderKey];
            if ($function)
                $query = call_user_func($function, $query, $order);
        }

        if ($skip)
            $query = $query->skip($skip);

        if ($limit)
            $query = $query->take($limit);

        $query = $query->with(['company', 'categories']);

        if ($return_query)
            return $query;
        else
            return $query->get();

        return null;
    }
}
