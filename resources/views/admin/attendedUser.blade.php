@extends('admin.layouts.layout')

@section('content')   

<!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <!-- FAQ -->
                    <div class="section" id="faq">
                        <div class="faq row">
                            <div class="col s12 m3 l3">
                                <div class="card mt-2">
                                    <div class="card-content">
                                        <span class="card-title">Selected Properties</span>
                                        <div class="category-list">
                                            @foreach($properties as $property => $selected)
                                                @if($selected)
                                                    <div class="mt-4 category-item"><i class="material-icons vertical-text-sub green-text"> panorama_fish_eye </i>{{ $property }}
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <span class="card-title unselected">Unselected Properties</span>
                                        <div class="category-list">
                                            @foreach($properties as $property => $selected)
                                                @if(!$selected)
                                                    <div class="mt-4 category-item"><i class="material-icons vertical-text-sub red-text"> panorama_fish_eye </i>{{ $property }}
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 m9 l9">
                                <h5 class="question-title mb-2">Questions and Feedback</h5>
                                <ul class="collapsible categories-collapsible">
                                    @foreach($questions as $id=>$question)
                                        @if(isset($answers[$id]))
                                            <li class="active">
                                                <div class="collapsible-header">{{ $question }}<i class="material-icons">
                                                        keyboard_arrow_right </i></div>
                                                <div class="collapsible-body">
                                                    <p>{{$answers[$id]}}</p>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                    @if($opportunityMessage)
                                        <li class="active">
                                            <div class="collapsible-header">Opportunity Feedback<i class="material-icons">
                                                    keyboard_arrow_right </i></div>
                                            <div class="collapsible-body">
                                                <div>{!!$opportunityMessage!!}</div>
                                            </div>
                                        </li>
                                    @endif
                                    @if($companyMessage)
                                        <li class="active">
                                            <div class="collapsible-header">Company Feedback<i class="material-icons">
                                                    keyboard_arrow_right </i></div>
                                            <div class="collapsible-body">
                                                <div>{!!$companyMessage!!}</div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-overlay"></div>
            </div>
        </div>
    </div>
    <!-- END: Page Main-->

@endsection