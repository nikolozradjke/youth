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
                            <div class="col s12">
                                <h5 class="question-title mb-2">Questions and Feedback</h5>
                                <ul class="collapsible categories-collapsible">
                                    @foreach($questions as $id=>$question)
                                        @if(isset($answers[$id]))
                                            <li class="active">
                                                <div class="collapsible-header">{{ $question }}<i class="material-icons">
                                                        keyboard_arrow_right </i></div>
                                                <div class="collapsible-body">
                                                    {{$answers[$id][0]}}
                                                    @if(isset($answers[$id][1]) && $answers[$id][1])
                                                        {{$answers[$id][1]}}
                                                    @endif
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