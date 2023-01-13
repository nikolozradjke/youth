@extends('layouts.master')

@section('content')

<div id='all-companies-list-id'>
    <div class="page-bgs">
      <div></div>
      <div></div>
    </div>
    @include('templates.organizations')
</div>

@if($companyCount > $numberPerPage)
    <nav id="organization-pagination" class="pagination-container opportunity-pagination ">
        @include('renders.paginationRender',[
            'opportunityCount' => $companyCount,
            'numberPerPage'    => $numberPerPage,
            'page'             => $page,
            'term'             => ""
        ]) 
    </nav>
@endif

@endsection