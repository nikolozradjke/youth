@extends('layouts.master')
@section('content')

<form name="YES_NO" method="POST" action="/query/{{$opportunity_id}}">
    @csrf
    <input type="hidden" name="user_id" value={{$user_id}}>

    <div class="query-main">
        <div class="wrapper">
            <div class="query-nav">
                <div class="back">
                    <img src="{{ asset('img/icons/back-blue.svg') }}" alt="back" draggable="false">
                    <span>უკან დაბრუნება</span>
                </div>
            </div>
            <div class="yes-no query-tab active">
                <span class="attribute attribute--tick">
                </span>
                <p class="query-heading query-heading--primary">დაესწარით თუ არა შესაძლებლობას?</p>
                <div class="yes-no-checkboxes">
                    <label class="checkbox-container checkbox--query">
                        <input type="radio" name="attend" value="1" class="attended" checked></input>
                        <span class="checkmark"></span>
                        <span>კი</span>
                    </label>
                    <label class="checkbox-container checkbox--query">
                        <input type="radio" name="attend" value="0"></input>
                        <span class="checkmark"></span>
                        <span>არა</span>
                    </label>
                </div>
                <p class="paragraph--query">რამე ტექსტი, ინვეთის აღწერილობა, რამე ორსიტყვიანი რომ მარტივად მიხვდე რა ხდება, სანამ შიგნით შეხვალ. რამე ტექსტი, ინვეთის აღწერილობა, რამე ორსიტყვიანი რომ მარტივად მიხვდე რა ხდება, სანამ შიგნით შეხვალ. რამე ტექსტი, ინვეთის აღწერილობა.</p>
                <div class="button button--red check-attendance">
                    <span class="d-inline-block">გაგრძელება</span>
                    <img src="{{ asset('img/icons/arrow-right-white-thin.svg') }}" alt="registration" class="d-inline-block ml-2">
                </div>
            </div>
            <div class="yes">
                @php
                $questions = $query->questions;
                $properties = $query->properties;
                @endphp
                <div class="ratings query-tab">
                    <span class="attribute attribute--star">
                    </span>
                    <p class="query-heading query-heading--primary">შეაფასე შესაძლებლობა და ორგანიზატორი</p>
                    <div class="wizard__header">
                        <div class="wizard__steps">
                            @foreach($questions as $i=>$question)
                            <div class="wizard__step wizard__step--blue {{$i==0 ? 'active' : ''}} ">
                                <span class="step-number"></span>{!! $question->text !!}
                            </div>
                            @endforeach
                            <div class="wizard__indicator wizard__indicator--blue">
                                <span class="bar"></span>
                            </div>
                        </div>
                    </div>
                    <div class="wizard__tabs query-wizard-tabs">
                        <div class="wrapper">
                            @foreach($questions as $i=>$question)
                            <div class="wizard__tab {{$i==0 ? 'active' : ''}} ">
                                <div class="paragraph--query">{!!$question->details!!}</div>
                                <div class="rating-single">
                                    <input type="number" name="answers[{{$question->id}}]" class="form__input">
                                    <div class="star">
                                        <svg viewBox="0 0 386 369" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M207.765 9.18454L254.65 104.256C255.831 106.651 257.577 108.724 259.736 110.294C261.896 111.864 264.405 112.885 267.047 113.269L371.885 128.515C385.39 130.478 390.782 147.087 381.01 156.62L305.148 230.622C303.236 232.487 301.806 234.789 300.982 237.33C300.157 239.871 299.962 242.574 300.413 245.207L318.322 349.701C320.629 363.161 306.511 373.426 294.432 367.071L200.662 317.736C198.299 316.492 195.67 315.843 193 315.843C190.331 315.843 187.702 316.492 185.339 317.736L91.5688 367.071C79.4895 373.426 65.3724 363.161 67.6789 349.701L85.5877 245.207C86.0388 242.574 85.8435 239.871 85.0187 237.33C84.1938 234.789 82.7642 232.487 80.8528 230.622L4.99097 156.62C-4.78252 147.088 0.610585 130.479 14.1148 128.515L118.953 113.27C121.595 112.886 124.103 111.865 126.263 110.294C128.422 108.724 130.168 106.652 131.35 104.257L178.235 9.18532C184.275 -3.06165 201.725 -3.06164 207.765 9.18454Z" fill="$white" />
                                        </svg>
                                    </div>
                                    <div class="star">
                                        <svg viewBox="0 0 386 369" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M207.765 9.18454L254.65 104.256C255.831 106.651 257.577 108.724 259.736 110.294C261.896 111.864 264.405 112.885 267.047 113.269L371.885 128.515C385.39 130.478 390.782 147.087 381.01 156.62L305.148 230.622C303.236 232.487 301.806 234.789 300.982 237.33C300.157 239.871 299.962 242.574 300.413 245.207L318.322 349.701C320.629 363.161 306.511 373.426 294.432 367.071L200.662 317.736C198.299 316.492 195.67 315.843 193 315.843C190.331 315.843 187.702 316.492 185.339 317.736L91.5688 367.071C79.4895 373.426 65.3724 363.161 67.6789 349.701L85.5877 245.207C86.0388 242.574 85.8435 239.871 85.0187 237.33C84.1938 234.789 82.7642 232.487 80.8528 230.622L4.99097 156.62C-4.78252 147.088 0.610585 130.479 14.1148 128.515L118.953 113.27C121.595 112.886 124.103 111.865 126.263 110.294C128.422 108.724 130.168 106.652 131.35 104.257L178.235 9.18532C184.275 -3.06165 201.725 -3.06164 207.765 9.18454Z" fill="$white" />
                                        </svg>
                                    </div>
                                    <div class="star">
                                        <svg viewBox="0 0 386 369" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M207.765 9.18454L254.65 104.256C255.831 106.651 257.577 108.724 259.736 110.294C261.896 111.864 264.405 112.885 267.047 113.269L371.885 128.515C385.39 130.478 390.782 147.087 381.01 156.62L305.148 230.622C303.236 232.487 301.806 234.789 300.982 237.33C300.157 239.871 299.962 242.574 300.413 245.207L318.322 349.701C320.629 363.161 306.511 373.426 294.432 367.071L200.662 317.736C198.299 316.492 195.67 315.843 193 315.843C190.331 315.843 187.702 316.492 185.339 317.736L91.5688 367.071C79.4895 373.426 65.3724 363.161 67.6789 349.701L85.5877 245.207C86.0388 242.574 85.8435 239.871 85.0187 237.33C84.1938 234.789 82.7642 232.487 80.8528 230.622L4.99097 156.62C-4.78252 147.088 0.610585 130.479 14.1148 128.515L118.953 113.27C121.595 112.886 124.103 111.865 126.263 110.294C128.422 108.724 130.168 106.652 131.35 104.257L178.235 9.18532C184.275 -3.06165 201.725 -3.06164 207.765 9.18454Z" fill="$white" />
                                        </svg>
                                    </div>
                                    <div class="star">
                                        <svg viewBox="0 0 386 369" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M207.765 9.18454L254.65 104.256C255.831 106.651 257.577 108.724 259.736 110.294C261.896 111.864 264.405 112.885 267.047 113.269L371.885 128.515C385.39 130.478 390.782 147.087 381.01 156.62L305.148 230.622C303.236 232.487 301.806 234.789 300.982 237.33C300.157 239.871 299.962 242.574 300.413 245.207L318.322 349.701C320.629 363.161 306.511 373.426 294.432 367.071L200.662 317.736C198.299 316.492 195.67 315.843 193 315.843C190.331 315.843 187.702 316.492 185.339 317.736L91.5688 367.071C79.4895 373.426 65.3724 363.161 67.6789 349.701L85.5877 245.207C86.0388 242.574 85.8435 239.871 85.0187 237.33C84.1938 234.789 82.7642 232.487 80.8528 230.622L4.99097 156.62C-4.78252 147.088 0.610585 130.479 14.1148 128.515L118.953 113.27C121.595 112.886 124.103 111.865 126.263 110.294C128.422 108.724 130.168 106.652 131.35 104.257L178.235 9.18532C184.275 -3.06165 201.725 -3.06164 207.765 9.18454Z" fill="$white" />
                                        </svg>
                                    </div>
                                    <div class="star">
                                        <svg viewBox="0 0 386 369" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M207.765 9.18454L254.65 104.256C255.831 106.651 257.577 108.724 259.736 110.294C261.896 111.864 264.405 112.885 267.047 113.269L371.885 128.515C385.39 130.478 390.782 147.087 381.01 156.62L305.148 230.622C303.236 232.487 301.806 234.789 300.982 237.33C300.157 239.871 299.962 242.574 300.413 245.207L318.322 349.701C320.629 363.161 306.511 373.426 294.432 367.071L200.662 317.736C198.299 316.492 195.67 315.843 193 315.843C190.331 315.843 187.702 316.492 185.339 317.736L91.5688 367.071C79.4895 373.426 65.3724 363.161 67.6789 349.701L85.5877 245.207C86.0388 242.574 85.8435 239.871 85.0187 237.33C84.1938 234.789 82.7642 232.487 80.8528 230.622L4.99097 156.62C-4.78252 147.088 0.610585 130.479 14.1148 128.515L118.953 113.27C121.595 112.886 124.103 111.865 126.263 110.294C128.422 108.724 130.168 106.652 131.35 104.257L178.235 9.18532C184.275 -3.06165 201.725 -3.06164 207.765 9.18454Z" fill="$white" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="ratings-buttons">
                        <div class="button button--red wizard-stars-previous disabled active">
                            <img src="{{ asset('img/icons/arrow-right-white-thin.svg') }}" alt="registration">
                            <span class="d-inline-block">უკან დაბრუნება</span>
                        </div>
                        <div class="button button--red wizard-next-step active">
                            <span class="d-inline-block">გაგრძელება</span>
                            <img src="{{ asset('img/icons/arrow-right-white-thin.svg') }}" alt="registration">
                        </div>
                        <div class="button button--red query-next-step">
                            <span class="d-inline-block">გაგრძელება</span>
                            <img src="{{ asset('img/icons/arrow-right-white-thin.svg') }}" alt="registration">
                        </div>
                    </div>
                </div>
                <div class="query-checkboxes query-tab">
                    <span class="attribute attribute--tick"></span>
                    <p class="query-heading query-heading--primary">ჩამოთვლილიდან მონიშნე ის, რაც ამ შესაძლებლობას გამოარჩევდა</p>
                    <div class="checkboxes-container">
                        @foreach ($properties as $property)
                        <label class="checkbox-container checkbox--query">
                            <input type="hidden" name="all_properties[]" value={{$property->id}}>
                            <input type="checkbox" name="checked_properties[]" value={{$property->id}}></input>
                            <span class="checkmark"></span>
                            <span>{!!$property->text!!}</span>
                        </label>
                        @endforeach
                    </div>
                    <div class="button button--red query-next-step">
                        <span class="d-inline-block">გაგრძელება</span>
                        <img src="{{ asset('img/icons/arrow-right-white-thin.svg') }}" alt="registration" class="d-inline-block ml-2">
                    </div>
                </div>
                <div class="feedback query-tab">
                    <span class="attribute attribute--feedback"></span>
                    <p class="query-heading query-heading--primary">დატოვე უკუკავშირი</p>
                    <p class="query-heading query-heading--secondary">დაწერე საჯარო შეფასება</p>
                    <p class="paragraph--query">აღნიშნული კომენტარი საჯაროდ გამოჩნდება შესაძლებლობის შეფასების ნაწილში. შეფასება შეგიძლია გამოაქვეყნო როგორც შენი სახელით, ისე ანონიმურად</p>
                    <div class="switch">
                        <div class="switch__item active">შენი სახელით</div>
                        <div class="switch__item anonymous">ანონიმური</div>
                    </div>
                    <input name="no_anonym_opportunity" type="checkbox" checked>
                    <textarea class="feedback-input" name="feedback_oppurtunity"></textarea>
                    <div class="button button--red query-next-step">
                        <span class="d-inline-block">გაგრძელება</span>
                        <img src="{{ asset('img/icons/arrow-right-white-thin.svg') }}" alt="registration" class="d-inline-block ml-2">
                    </div>
                </div>
                <div class="feedback query-tab">
                    <span class="attribute attribute--feedback"></span>
                    <p class="query-heading query-heading--primary query-heading-primary">დატოვე უკუკავშირი</p>
                    <p class="query-heading query-heading--secondary">დაუტოვე პირადი შეტყობინება ორგანიზატორს</p>
                    <p class="paragraph--query">აღნიშნული კომენტარი საჯაროდ გამოჩნდება შესაძლებლობის შეფასების ნაწილში. შეფასება შეგიძლია გამოაქვეყნო როგორც შენი სახელით, ისე ანონიმურად</p>
                    <div class="switch">
                        <div class="switch__item active">შენი სახელით</div>
                        <div class="switch__item anonymous">ანონიმური</div>
                    </div>
                    <input name="no_anonym_company" type="checkbox" checked>
                    <textarea class="feedback-input" name="feedback_company"></textarea>
                    <button class="button button--red" type="submit">
                        <span class="d-inline-block">გაგზავნა</span>
                        <img src="{{ asset('img/icons/arrow-right-white-thin.svg') }}" alt="registration" class="d-inline-block ml-2">
                    </button>
                </div>
            </div>
            <div class="no">
                <div class="query-checkboxes absent query-tab">
                    <span class="attribute attribute--tick"></span>
                    @foreach($query->unattended_questions as $question)
                    <p class="query-heading query-heading--primary">{{$question->text}}</p>
                    <div class="checkboxes-container checkboxes-container--slender">
                        <input type="hidden" name="question_id" value={{$question->id}}>
                        <input type="hidden" name="opportunity_id" value={{$opportunity_id}}>
                        @foreach ($question->options as $option)
                        <label class="checkbox-container checkbox--query">
                            <input type="radio" name="option_id" value={{$option->id}} class={{$option->has_text_field ? "other":""}}>
                            <span class="checkmark"></span>
                            <span>{{$option->text}}</span>
                        </label>
                        @endforeach
                    </div>
                    @endforeach
                    <textarea name='text' class="feedback-input" placeholder="მოგვწერეთ რატომ ვერ დაესწარით შესაძლებლობას?"></textarea>
                    <div class="button button--red">
                        <span class="d-inline-block">გაგრძელება</span>
                        <img src="{{ asset('img/icons/arrow-right-white-thin.svg') }}" alt="registration" class="d-inline-block ml-2">
                    </div>
                </div>
                <div class="feedback query-tab">
                    <span class="attribute attribute--feedback"></span>
                    <p class="mb-5 query-heading query-heading--primary">დატოვე უკუკავშირი</p>
                    <p class="query-heading query-heading--secondary">დაწერე საჯარო შეფასება</p>
                    <p class="paragraph--query">აღნიშნული კომენტარი საჯაროდ გამოჩნდება შესაძლებლობის შეფასების ნაწილში. შეფასება შეგიძლია გამოაქვეყნო როგორც შენი სახელით, ისე ანონიმურად</p>
                    <div class="switch">
                        <div class="switch__item active">შენი სახელით</div>
                        <div class="switch__item anonymous">ანონიმური</div>
                    </div>
                    <input name="no_anonym" type="checkbox" checked>
                    <textarea class="feedback-input" name="feedback"></textarea>
                    <button class="button button--red">
                        <span class="d-inline-block">გაგზავნა</span>
                        <img src="{{ asset('img/icons/arrow-right-white-thin.svg') }}" alt="registration" class="d-inline-block ml-2">
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- <div id="wrapper">
        <label for="yes_no_radio">დაესწარით თუ არა შესაძლებლობას?</label>
        <p>
            <input type="radio" name="yes_no" value="1" checked>Yes</input>
        </p>
        <p>
            <input type="radio" name="yes_no" value="0">No</input>
        </p>
        {{-- ATTENDED --}}
        <h1>YES:</h1>
        <div>
            <br>
            <h3>კითხვები</h3>
            @foreach ($query->questions as $question)
            <li>{{$question->text}}</li>
            {{$question->details}}
            @endforeach
        </div>

        <div>
            <br>
            <h4>ჩამოვლილიდან მონიშნე ის რაც ამ შესაძლებლობას გამოარჩევდა</h4>
            @foreach ($query->properties as $property)
            <li>{{$property->text}}</li>
            @endforeach
        </div>

        {{-- NOT ATTENDED --}}
        <h1>NO:</h1>
        <div>
            <br>
            <h3>კითხვები (დაუსწრებელი)</h3>
            @foreach ($query->unattended_questions as $question)
            <li>{{$question->text}}</li>
            {{$question->details}}
            <ul>
                @foreach ($question->options as $option)
                <li>{{$option->text}}</li>
                @endforeach
            </ul>
            @endforeach
        </div>
        <p>
            <input type="submit" value="Submit">
        </p>

    </div>-->
@endsection