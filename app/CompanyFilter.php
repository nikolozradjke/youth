<?php

namespace App;

use App\Company;
use App\Region;
use App\Municipality;
use DB;

class CompanyFilter
{

    private static $filterKeysArr = array(
        'registration' => 'App\CompanyFilter::filterByRegistration',
        'companyStatuses' => 'App\CompanyFilter::filterByCompanyStatuses',
        'opportunitySubtypes' => 'App\CompanyFilter::filterByOpportunitySubtypes',
        'companyWorkingType' => 'App\CompanyFilter::filterByCompanyWorkingType',
        'companyTypes' => 'App\CompanyFilter::filterByCompanyTypes',
        'registrationMunicipalities' => 'App\CompanyFilter::filterByRegistrationMunicipalities',
        'workingMunicipalities' => 'App\CompanyFilter::filterByWorkingMunicipalities',
    );

    private static $orderKeysArr = array(
        'create_date' => 'App\CompanyFilter::orderByCreateDate',
    );


    private static function filterByRegistration($query = null, $ids)
    {
        if (!$ids || count($ids) == 0 || (!isset($ids['regions']) && !isset($ids['municipalities'])) || (empty($ids['regions']) && empty($ids['municipalities']))) {
            return $query;
        }
        if (!$query) {
            $query = new Company();
        }

        if (!isset($ids['regions']) || empty($ids['regions'])) {
            $municipalityIds = $ids['municipalities'];
            return $query->whereHas('place_of_registration', function ($q) use ($municipalityIds) {
                $q->whereIn('municipality_id', $municipalityIds);
            });
        }

        if (!isset($ids['municipalities']) || empty($ids['municipalities'])) {
            $regionIds = $ids['regions'];
            return $query->whereHas('place_of_registration', function ($q) use ($regionIds) {
                $q->whereIn('region_id', $regionIds);
            });
        }

        $municipalityIds = $ids['municipalities'];
        $regionIds = $ids['regions'];

        return $query->whereHas('place_of_registration', function ($q) use ($regionIds, $municipalityIds) {
            $q->whereIn('region_id', $regionIds)->orWhereIn('municipality_id', $municipalityIds);
        });
    }

    // 1. Company Statuses
    private static function filterByCompanyStatuses($query = null, $ids)
    {
        if (!$ids || count($ids) == 0) {
            return $query;
        }
        if (!$query) {
            $query = new Company();
        }
        return $query->whereHas('company_statuses', function ($q) use ($ids) {
            $q->whereIn('company_status_id', $ids);
        });
    }

    // 2. Company Working Types
    private static function filterByCompanyWorkingType($query = null, $ids)
    {
        if (!$ids || count($ids) == 0) {
            return $query;
        }
        if (!$query) {
            $query = new Company();
        }
        return $query->whereHas('companyWorkingTypes', function ($q) use ($ids) {
            $q->whereIn('company_working_type_id', $ids);
        });
    }

    // 3. Company Type
    private static function filterByCompanyTypes($query = null, $ids)
    {
        if (!$ids || count($ids) == 0) {
            return $query;
        }
        if (!$query) {
            $query = new Company();
        }
        return $query->whereIn('type', $ids);
    }

    // 4. Company Place of Registration
    private static function filterByRegistrationMunicipalities($query = null, $ids)
    {
        if (!$ids || count($ids) == 0) {
            return $query;
        }
        if (!$query) {
            $query = new Company();
        }
        return $query->whereHas('place_of_registration', function ($q) use ($ids) {
            $q->whereHas('municipality', function ($p) use ($ids) {
                $p->whereIn('municipality_id', $ids);
            });
        });
    }

    // 5. Company Place of Work
    private static function filterByWorkingMunicipalities($query = null, $ids)
    {
        if (!$ids || count($ids) == 0) {
            return $query;
        }
        if (!$query) {
            $query = new Company();
        }
        return $query->whereHas('workingMunicipalities', function ($q) use ($ids) {
            $q->whereIn('municipality_id', $ids);
        });
    }

    private static function orderByCreateDate($query = null, $order)
    {
        if (!$query) {
            $query = new Company();
        }
        return $query->orderBy('created_at', $order);
    }


    public static function filterCompanies($filterData = [], $orderKey = null, $order = 'desc', $skip = 0, $limit = null, $return_query = false)
    {
        $query = Company::where('approved', '1');

        foreach ($filterData as $filterKey => $filterValue) {
            $function = CompanyFilter::$filterKeysArr[$filterKey];
            if ($function) {
                $query = call_user_func($function, $query, $filterValue);
            }
        }

        if ($orderKey) {
            $function = CompanyFilter::$orderKeysArr[$orderKey];
            if ($function) {
                $query = call_user_func($function, $query, $order);
            }
        }

        if ($skip) {
            $query = $query->skip($skip);
        }

        if ($limit) {
            $query = $query->take($limit);
        }

        // dd($query->toSql());

        //with(['company', 'categories']);

        if ($return_query) {
            return $query;
        } else {
            return $query->get();
        }
        return null;
    }
}
