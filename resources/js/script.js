const { ajax } = require("jquery");

// CSRF token for ajax requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//remove autocomplete and autofill
$(function () {
    $('input').attr('autocomplete', 'off');
    $('form').attr('autocomplete', 'off');
})
//remove autocomplete and autofill ends



//controls header form

$('.header-container .search input, .search-mobile .search input').focus(function () {
    $(this).closest('.search').addClass('focused');
})
$('.header-container .search input, .search-mobile .search input').blur(function () {
    $(this).closest('.search').removeClass('focused');
})

//controls header form ends

if ($(document).width() < 991) {
    $('.header-bottom-mobile').wrapAll('<div class="mobile-header-part"></div>');
}

$viewportWidth = $(window).width();


$headerHeight = $('.header-container .header').outerHeight();
$bannerheight = 0;

$bannersheight = 0;


$(function () {
    $yellowBannerHeight = $('.banner--yellow').outerHeight(true);

    $scrolled = $(window).scrollTop();

    if ($viewportWidth <= 991) {
        $('.mobile-header-part').css('top', $headerHeight + $yellowBannerHeight);
        $headerOverallHeight = $('.mobile-header-part').outerHeight() + parseInt($('.mobile-header-part').css('top'), 10);

        $('.banners').css('top', $headerOverallHeight + 'px');

        $('body').css('padding-top', $headerOverallHeight);


        $(window).on("scroll", function () {
            $scroll = $(window).scrollTop();

            if ($scroll > 70) {
                $('.mobile-header-part').css('top', $headerHeight + $yellowBannerHeight);
                // $('.mobile-header-part').css('top', $headerHeight + $bannersheight);
                $('.mobile-header-part').addClass('hidden');

                $('.banners').css('top', $headerHeight + $yellowBannerHeight);

                if ($scroll < $scrolled) {
                    // if($scrollSpeed < -50  && $('.mobile-header-part').hasClass('hidden')){

                    // }
                    $('.mobile-header-part').removeClass('hidden');
                    $('.banners').css('top', $headerOverallHeight + 'px');
                }
            }
            $scrolled = $scroll;
        });
    } else {
        if ($('.banners').length != 0) {
            $bannersheight = $('.banners').outerHeight();
        }
        $('.categorize').css('top', $headerHeight + $bannersheight + $yellowBannerHeight);

        $(window).on("scroll", function () {
            $bannersheight = $('.banners').outerHeight();
            $scroll = $(window).scrollTop();
            if ($scroll > 70) {
                $('.categorize').css('top', $headerHeight + $bannersheight + $yellowBannerHeight);
                $(".categorize").addClass('categorize--up');
                //$('body > .section-join-us').css('transform', 'translate3d(0, 0, 0)');
                //$('body > .section-highlighted').css('transform', 'translate3d(0, 0, 0)');
                //$('body > .wrapper').css('transform', 'translate3d(0, 0, 0)');
                $('.filters .filter').removeClass('active');

                $('.categories').removeClass('active');
                //$('.categories').css('height', '6rem');
                $('.categories-container .trigger').removeClass('active');

                if ($scroll < $scrolled) {
                    $(".categorize").removeClass('categorize--up');
                    //$('body > .section-join-us').css('transform', 'translate3d(0, ' + ($('.categorize').outerHeight()) + 'px, 0)');
                    //$('body > .section-highlighted').css('transform', 'translate3d(0, ' + ($('.categorize').outerHeight()) + 'px, 0)');
                    //$('body > .wrapper').css('transform', 'translate3d(0, ' + ($('.categorize').outerHeight()) + 'px, 0)');
                }
            }
            $scrolled = $scroll;
        });
    }
});

//header scroll behaviour


//categories dropdown

/*$(document).ready(function () {
    $categoriesHeight = $('.categories-container .categories').height();
    $('.categories-container .categories').removeClass('active');
    $('.categories-container .categories').height('6rem');
    setTimeout(() => {
        $('.categories-container').removeClass('initial');
        $('.header-container').removeClass('initial');
    }, 100);
    $('.categories-container .trigger').click(function () {
        $(this).toggleClass('active');
        $('.categories-container .categories').toggleClass('active');
        $('.categories-container .categories.active').height($categoriesHeight);
        $('.categories-container .categories:not(.active)').height('6rem');
    })
});*/

//categories dropdown

$('document').ready(function () {
    $('.sub-types .sub-type').on('click', function () {
        $(this).toggleClass('active');
    });

    /*$('.categories-container .categories .category').on('click', function() {
        $('.categories-container .categories .category').removeClass('active');
        $(this).addClass('active');
        const id = $(this).data('type-id');
        $('.sub-types').removeClass('active');
        $('.sub-types .sub-type').removeClass('active');
        if(!isNaN(id)) {
            $('.filter-wrapper.types-wrapper').removeClass('active');
            $('.sub-types[data-type-id="' + id + '"]').addClass('active');
            $('.filter-wrapper:nth-child(2)').addClass('filter-wrapper__expanded');
        }
        else {
            $('.filter-wrapper.types-wrapper').addClass('active');
            $('.filter-wrapper:nth-child(2)').removeClass('filter-wrapper__expanded');
        }
        $('body > .wrapper').css('transform', 'translate3d(0, '+($('.categorize').outerHeight() - 200) + 'px, 0)');
    })*/

    const params = getUrlVars();
    const id = params['type'];
    if (id) {
        $('.categories-container .category').removeClass('active');
        $('.categories-container .category[data-type-id="' + id + '"]').addClass('active')
        $('.sub-types').removeClass('active');
        $('.sub-types .sub-type').removeClass('active');
        if (!isNaN(id)) {
            $('.filter-wrapper.types-wrapper:first-child').removeClass('active');
            $('.filter-wrapper.types-wrapper[data-type-id="' + id + '"]').addClass('active');
            $('.categories-container').addClass('bordered');
            //$('.filter-wrapper:nth-child(2)').addClass('filter-wrapper__expanded');
        } else {
            $('.filter-wrapper.types-wrapper').removeClass('active');
            $('.filter-wrapper.types-wrapper:first-child').addClass('active');
            $('.categories-container').removeClass('bordered');
            //$('.filter-wrapper:nth-child(2)').removeClass('filter-wrapper__expanded');
        }
        //$('body > .wrapper').css('transform', 'translate3d(0, ' + ($('.categorize').outerHeight() - 200) + 'px, 0)');
    }
});


function ajaxValidation(input) {

    let fieldName = input.attr('name');
    let url = '';
    let data = {};

    if (fieldName == 'email') {
        url = '/ajax-check-email';
        data = {
            email: input.val()
        }
    } else if (fieldName == 'private_number') {
        if (input.val() == '') {
            return;
        }
        url = '/ajax-check-private-number';
        data = {
            private_number: input.val()
        }
    } else if (fieldName == 'registration_id') {
        url = '/ajax-check-registration-number';
        data = {
            registration_id: input.val()
        }
    } else if (fieldName == 'phone' || fieldName == 'phone2') {
        const number = input.val();
        if (!number) {
            return;
        }
        url = '/ajax-check-phone-number';
        data = {
            phone: input.val(),
            registration_type: input.attr('registration-type')
        }
    } else {
        return;
    }

    $.ajax({
        type: 'POST',
        url: $('body').data('url') + url,
        data: data,
        success: function (data) {
            if (data.status == 'success') {
                input.removeClass('fucked-up');
                input.removeClass('used-data');
                $defaultText = input.closest('.form__group').find('.form__tooltip div').attr('default-text');
                input.closest('.form__group').find('.form__tooltip div').text($defaultText);
                input.closest('.form__group').find('.form__tooltip').removeClass('.form__tooltip--error active');
            } else {
                input.addClass('fucked-up');
                input.addClass('used-data');
                $altText = input.closest('.form__group').find('.form__tooltip div').attr('alt-text');
                input.closest('.form__group').find('.form__tooltip div').text($altText);
                input.closest('.form__group').find('.form__tooltip').addClass('form__tooltip--error active');
            }
        },
        error: function () {
            input.addClass('fucked-up');
            input.addClass('used-data');
            $altText = input.closest('.form__group').find('.form__tooltip div').attr('alt-text');
            input.closest('.form__group').find('.form__tooltip div').text($altText);
        }
    });
}


//makes 'password visible' visible
function hideEye(input) {
    $value = input.val();
    if ($value.length != 0) {
        input.closest('.form__group').find('.password-visible').addClass('displayed');
    } else {
        input.closest('.form__group').find('.password-visible').removeClass('displayed');
    }
}

$("input[type='password']").on('input', function () {
    hideEye($(this));
})

//makes 'password visible' visible ends


//makes password visible
$('.password-visible').click(function () {
    $targetInput = $(this).closest('.form__group').find('input');
    $value = $targetInput.val();
    if ($value != '') {
        $type = $targetInput.attr('type');
        if ($type == 'password') {
            $targetInput.attr('type', 'text');
            $(this).addClass('active');
        } else {
            $targetInput.attr('type', 'password');
            $(this).removeClass('active');
        }
    }
})
//makes password visible ends

//checks if input is empty
function checkInput(input) {
    $value = input.val();
    if ($value != "") {
        input.closest('.form__group').addClass('filled');
        changeBgImg(input);
        return true;
    } else {
        input.closest('.form__group').removeClass('filled');
        input.parents('.level1.level2').removeClass('level2');
        changeBgImg(input);
        return false;
    }
}
//checks if input is empty

//Pattern validation
function validation(input) {
    $value = input.val();
    $pattern = input.attr('pattern');
    if (!new RegExp($pattern).test($value)) {
        input.addClass('fucked-up');
        return false;
    } else {
        input.removeClass('fucked-up');
    }
    input.parent().find('.form__tooltip.form__tooltip--error').removeClass('active');
    return true;
}
//Pattern validation ends

function checkAndValidate(input) {
    checkInput(input);
    return validation(input);
}

function comparePasswords(input) {
    $attr = input.attr('id');
    if ($attr == 'password_confirmation') {
        if ($('#password').val() != $('#password_confirmation').val()) {
            $('#password').addClass('fucked-up');
            $('#password_confirmation').parent().find('.form__tooltip').addClass('form__tooltip--error active');
            $('#password_confirmation').addClass('fucked-up');
            $isValid = false;
        } else {
            $('#password').removeClass('fucked-up');
            $('#password_confirmation').parent().find('.form__tooltip').removeClass('form__tooltip--error active');
            $('#password_confirmation').closest('form').find('button').removeAttr('disabled');
            $('#password_confirmation').closest('form').find('button').removeClass('disabled');
        }
    }
}

//terms and privacy policy validation
function validateTerms() {
    $termsValid = false;
    if ($('.confirmation-checkbox').find("input:checked").length > 1) {
        $('.final-registration').removeClass('disabled-2');
    } else {
        $('.final-registration').addClass('disabled-2');
    }
}
//terms and privacy policy validation ends


//Changes input icon into blue
function changeBgImg(input) {
    $bgUrl = '';
    $bgUrlBlue = '';
    if (input.hasClass('input-bg')) {
        $bgUrl = input.attr('bg-url');
        $bgUrlBlue = input.attr('bg-url-active');
        if (input.closest('.form__group').hasClass('filled')) {
            input.css('background-image', $bgUrlBlue);
        } else {
            input.css('background-image', $bgUrl);
        }
    }
}
//Changes input icon into blue ends

$('.form__input').focus(function () {
    if (!$(this).hasClass('readonly')) {
        $(this).closest('.form__group').addClass('filled');
        $(this).parents('.level1').addClass('level2');
        changeBgImg($(this));
    }
})

$(function () {
    $('.form__input').each(function () {
        $this = $(this);
        checkInput($this);
        if ($this.attr('type') == 'password') {
            hideEye($this);
        }
    });

    $('input.readonly').attr('tabindex', -1);

    $(document).on('focusin', '.form__input', function (e) {
        if (!$(this).hasClass('hasDatepicker')) {
            if (!$(this).parent().hasClass('form__group--dropdown')) {
                if (!$(this).hasClass('data-picker-plain')) {
                    $(this).removeAttr('readonly');
                }
            }
        }
    });

    setTimeout(function () {
        $('.form__input').each(function () {
            $(this).prop('readonly', true);
        });
    }, 0);

    $('.form__input').focusout(function () {

        if (!$(this).hasClass('hasDatepicker') && ($(this).prop('readonly') || $(this).parent().hasClass('form__group--dropdown'))) {
            return;
        }

        let $defaultTime = 0;
        if ($(this).hasClass('hasDatepicker')) {
            $defaultTime = 1000;
        }

        $this = $(this);
        setTimeout(function () {
            if (checkAndValidate($this) && ($this.parents('form.form-registration').length || $this.parents('form.form-edit-user').length)) {
                $this.parent().find('.form__tooltip').removeClass('form__tooltip--error');
                ajaxValidation($this);
            }
            comparePasswords($this);
        }, $defaultTime)
    });
    $('textarea').focusout(function () {
        $this = $(this);
        checkAndValidate($this);
    });
});


//org description tab
$('#saqmianobis-sfero').focus(function () {
    $('.blue-layout-md').animate({
        scrollTop: 0
    }, 600);
})
//org description tab ends

//registration address tab
$(function () {
    $('.wizard__tab--registration-place .country .checkbox-container').click(function () {
        $index = $(this).index();
        $(this).closest('.wizard__tab--registration-place').find('.address-dropdowns').removeClass('active');
        $(this).parent().find('.form__group').addClass('disabled');
        $('#foreign-address').prop('disabled', true);
        $('#foreign-address').removeAttr('pattern');
        $(this).closest('.wizard__tab--registration-place').find('.address-dropdowns').find('input[type="text"]').removeAttr('pattern');
        $(this).closest('.wizard__tab--registration-place').find('.address-dropdowns').find('input:not([type="text"])').prop('disabled', true);
        $(this).closest('.wizard__tab--registration-place').find('.address-dropdowns').find('input[type="text"]').val('');
        $('#foreign-address').val('');
        $(this).closest('.wizard__tab--registration-place').find('.form__input').removeClass('fucked-up filled');


        if ($index == 1) {
            $(this).closest('.wizard__tab--registration-place').find('.address-dropdowns').addClass('active');
            if ($(this).hasClass('required-address')) {
                $(this).closest('.wizard__tab--registration-place').find('.address-dropdowns').find('input[type="text"]').prop('pattern', '.{1}');
            }
            $(this).closest('.wizard__tab--registration-place').find('.address-dropdowns').find('input:not([type="text"])').prop('disabled', false);
        } else {
            $(this).parent().find('.form__group').removeClass('disabled');
            $('#foreign-address').removeClass('disabled');
            if ($(this).hasClass('required-address')) {
                $('#foreign-address').prop('pattern', '.{1}');
            }
            $('#foreign-address').prop('disabled', false);
            $('.address-dropdowns').find('input.user-input').prop('disabled', true);
        }
    })

    $('.dropdown-right-trigger, .form__group-arrow, .form__group--dropdown .input-wrapper').click(function () {
        if (!$(this).parent().hasClass('disabled')) {
            $('.form__group--dropdown').not($(this).parent()).removeClass('active');
            $('.form__group--dropdown .dropdown-right').removeClass('active');
            $(this).parent().toggleClass('active');
        }

        $(this).parent().find('.dropdown-right').each(function () {
            $customTopProperty = $(this).parent().prev('.form__group--dropdown').outerHeight(true);
            $(this).css('top', -$customTopProperty);
        })
    })


    $('.form__group--dropdown .dropdown-right label.radio').click(function () {

        $formGroup = $(this).closest('.form__group');
        $input = $(this).closest('.form__group').find('.form__input');

        $value = $(this).find('input').val();
        $input.val($(this).find('span').text());
        $input.removeClass('fucked-up');

        if ($formGroup.hasClass('linked')) {
            if ($input.val() != '') {
                $formGroup.nextAll('.form__group--dropdown').addClass('disabled');
                $formGroup.nextAll('.form__group--dropdown').find('.form__input').val('');
            }
            $formGroup.next('.form__group').removeClass('disabled');

            if ($formGroup.next('.form__group').find('.user-input').length) {
                $formGroup.next('.form__group').removeClass('disabled');
                $formGroup.next('.form__group').find('.user-input').removeAttr('disabled');
            }

            $formGroup.next('.form__group--dropdown').find('.dropdown-right').removeClass('selected');
            $formGroup.next('.form__group--dropdown').find('.dropdown-right[data-region-id = ' + $value + ']').addClass('selected');
        }

        $('.dropdown-right label').removeClass('active');
        $(this).addClass('active');
        $('.form__group--dropdown').removeClass('active');
        $('.form__group--dropdown .dropdown-right').removeClass('active');
    });


    function updateValues(checkboxes) {
        let values = '';
        checkboxes.each(function () {
            if (values == '') {
                values += ($(this).parent().find('span').text());
            } else {
                values += ', ' + ($(this).parent().find('span').text());
            }
        });
        return values;
    }

    $(document).on('click', '.selected-region', function (e) {
        $value = $(this).attr('data-id-region');
        $(this).closest('.form__group').find('input[value=' + $value + ']').prop('checked', false).trigger('change');
        $(this).remove();
    })

    $(document).on('click', '.selected-municipality', function (e) {
        const municipalityId = $(this).data('municipality-id');
        if (municipalityId) {
            const municipalityInput = $(this).parents('.filter-popup').find('.municipality-section input[data-id="' + municipalityId + '"]');
            municipalityInput.prop('checked', false);
            checkMunicipalityInFilterPopup(municipalityInput.get(0));
        } else {
            $value = $(this).attr('value');
            $(this).closest('.form__group').find('input[value=' + $value + ']').prop('checked', false).trigger('change');
            $(this).remove();
        }
    })

    $('.with-master-checkbox .checkbox-container:not(.master) input').on('change', function () {

        $checkboxes = $(this).closest('.dropdown-right__content').find('.checkbox-container:not(.master) input');
        $checkboxesChecked = $(this).closest('.dropdown-right__content').find('.checkbox-container:not(.master) input:checked');
        $checkboxMaster = $(this).parent().parent().find('.checkbox-container.master');


        $selectedValues = updateValues($checkboxesChecked);

        $checkboxMaster.removeClass('partially-selected all-selected');

        if ($checkboxesChecked.length != 0 && $checkboxes.length != $checkboxesChecked.length) {
            $checkboxMaster.find('input').prop('checked', false);
            $checkboxMaster.addClass('partially-selected');
        } else if ($checkboxesChecked.length == 0) {
            $checkboxMaster.find('input').prop('checked', false);
        } else {
            $checkboxMaster.addClass('all-selected');
            $checkboxMaster.find('input').prop('checked', true);
        }

        if ($(this).closest('.regions-multiple').length) {
            $(this).closest('.form__group').find('.form__input').val($selectedValues);
            if ($(this).closest('.form__group').find('.form__input').val() != '') {
                $(this).closest('.form__group').find('.form__input').removeClass('fucked-up');
            }
        }


        //update selected regions
        $id = $(this).val();
        if ($(this).is(':checked')) {
            if ($('.selected-regions').find('.selected-region[data-id-region=' + $id + ']').length == 0) {
                $text = $(this).parent().find('span').text();
                $('.selected-regions').append(
                    `
                            <div class="selected-region" data-id-region="` + $id + `"> ` + $text + `
                                <img src='../img/icons/x-white-rect.svg' alt="remove" draggable="false">
                            </div>
                            `
                )
            }
        } else {
            $('.selected-regions').find('.selected-region[data-id-region =' + $id + ']').remove();
        }
        //update selected regions ends

        if ($(this).is(':checked')) {
            $(this).closest('.wizard__tab').find('.municipalities .municipality input[data-id-region=' + $(this).val() + ']').parent().addClass('displayed');
        } else {
            $(this).closest('.wizard__tab').find('.municipalities .municipality input[data-id-region=' + $(this).val() + ']').prop('checked', false).trigger('change');
            $(this).closest('.wizard__tab').find('.municipalities .municipality input[data-id-region=' + $(this).val() + ']').parent().removeClass('displayed');
            $(this).closest('.wizard__tab').find('.municipalities .municipality input[data-id-region=' + $(this).val() + ']').parent().trigger('classChange');
        }

        if ($checkboxesChecked.length > 0) {
            $('.form__group.special').removeClass('disabled');
            $('.municipalities').parent().find('.form__input').prop('disabled', false);
            $('.municipalities').parent().find('.form__input').prop('readonly', false);
            //handles no result
            $('.form__group.special .no-result').removeClass('visible');
            //handles no result
        } else {
            $('.form__group.special').addClass('disabled');
            $('.municipalities').parent().find('.form__input').prop('disabled', true);
            $('.municipalities').parent().find('.form__input').prop('readonly', true);
        }
    })

    $('.checkbox-container.master input').on('click', function () {
        $(this).parent().removeClass('partially-selected all-selected');
        if ($(this).is(':checked')) {
            $(this).parent().addClass('all-selected');

            $(this).parent().parent().find('.checkbox-container:not(.master) input:not(.other-checkbox)').prop('checked', true).trigger('change');
        } else {
            $(this).parent().parent().find('.checkbox-container:not(.master) input:not(.other-checkbox)').prop('checked', false).trigger('change');
        }
    })

    $('.municipalities input:checkbox').on('change', function () {
        if ($(this).is(':checked')) {
            $(this).parent().addClass('active');
            $(this).closest('.form__group').find('.form__input').val('').trigger('keyup');
        } else {
            $(this).parent().removeClass('active');
        }

        //update selected municipalities
        $value = $(this).val();
        if ($(this).is(':checked')) {
            if ($('.selected-municipalities:not(.popup-municipalities)').find('.selected-region[value=' + $value + ']').length == 0) {
                $text = $(this).parent().find('span').text();
                $('.selected-municipalities:not(.popup-municipalities)').append(
                    `
                            <div class="selected-municipality" value="` + $value + `"> ` + $text + `
                                <img src='../img/icons/x-white-rect.svg' alt="remove" draggable="false">
                            </div>
                            `
                )
            }
        } else {
            $('.selected-municipalities:not(.popup-municipalities)').find('.selected-municipality[value =' + $value + ']').remove();
        }
        //update selected municipalities ends
    })

    $('.special').on('click', function () {
        if (!$(this).hasClass('disabled')) {
            $(this).addClass('active');
            $(this).prev('.form__group').removeClass('active');
        }
    })

    $('.special .form__input').on('keyup', function (e) {
        $keyword = $(this).val();
        if ($keyword != '') {
            $(this).closest('.form__group').find('input:checkbox').parent().addClass('hidden');
            $(this).closest('.form__group').find('input:checkbox').filter(
                function () {
                    return $(this).parent().find('span').text().startsWith($keyword);
                }
            ).parent().addClass('visible');

            if (e.keyCode === 13 && $(this).closest('.form__group').find('.displayed.visible:not(.active)').length == 1) {
                $(this).closest('.form__group').find('.displayed.visible:not(.active) input:checkbox').prop('checked', true).trigger('change');
            }

            //handles no result
            if ($(this).closest('.form__group').find('input:checkbox').parent('.visible').length == 0) {
                $(this).closest('.form__group').find('.no-result').addClass('visible');
            } else {
                $(this).closest('.form__group').find('.no-result').removeClass('visible');
            }
            //handles no result

        } else {
            $(this).closest('.form__group').find('input:checkbox').parent().removeClass('hidden visible');

            //handles no result
            $(this).closest('.form__group').find('.no-result').removeClass('visible');
            //handles no result
        }
    })

    $(document).on('click', function (e) {
        if ($(e.target).closest('.special').length == 0) {
            if (!$(e.target).hasClass('selected-municipality')) {
                $('.special').removeClass('active');
            }
        }
        if ($(e.target).closest('.form__group-regions').length == 0) {
            $('.form__group-regions').removeClass('active');
        }
    })

    $('.address-toggle').click(function () {
        $('.actual-address').removeClass('active');
        if ($('.address-toggle .right input').is(':checked')) {
            $('.actual-address').addClass('active');
            $('.actual-address').find('input').prop('pattern', '.{1}');
            $('.actual-address').find('input').removeAttr('disabled');
        } else {
            $('.actual-address').removeClass('active');
            $('.actual-address').find('input').removeAttr('pattern');
            $('.actual-address').find('input').val('');
            $('.actual-address').find('input').removeClass('fucked-up');
        }
    })

    $('[data-toggle="datepicker"]').datepicker({
        format: 'dd-mm-yyyy',
        startView: 2
    });
})

//registration address tab ends

//continue button class change from fixed to static

// if ($viewportWidth <= 991) {
//     $('.wizard__tab input').on('focus', function () {
//         $(this).closest('form').addClass('open-keyboard');
//     })
//     $('.wizard__tab input').on('blue', function () {
//         $(this).closest('form').removeClass('open-keyboard');
//     })
// }
//continue button class change from fixed to static ends


//registration - organization field select
$(function () {
    $('.wizard__tab--fields .checkbox-container:not(.master) input:checkbox:not(.other-checkbox)').on('change', function () {
        $selectedFields = $('.wizard__tab--fields input:checkbox:not(.other-checkbox):checked').parent();
        $lastIndex = $selectedFields.last().index();
        $('.wizard__tab--fields .subfields').removeClass('active');
        if ($lastIndex > -1) {
            $('.wizard__tab--fields .right > .tab-title').addClass('active');
            $('.wizard__tab--fields .subfields:nth-child(' + ($lastIndex + 1) + ')').addClass('active');
        } else {
            $('.wizard__tab--fields .right > .tab-title').removeClass('active');
        }


        $checkboxes = $(this).parent().parent().find('.checkbox-container:not(.master) input:checkbox:not(.other-checkbox)');
        $checkboxesChecked = $(this).parent().parent().find('.checkbox-container:not(.master) input:checked:not(.other-checkbox)');
        $checkboxMaster = $(this).parent().parent().find('.checkbox-container.master');

        $checkboxMaster.removeClass('partially-selected all-selected');

        if ($checkboxesChecked.length != 0 && $checkboxes.length != $checkboxesChecked.length) {
            $checkboxMaster.find('input').prop('checked', false);
            $checkboxMaster.addClass('partially-selected');
        } else if ($checkboxesChecked.length == 0) {
            $checkboxMaster.find('input').prop('checked', false);
        } else {
            $checkboxMaster.addClass('all-selected');
            $checkboxMaster.find('input').prop('checked', true);
        }
    })
})
//registration - organization field select ends

//toggle switch
$('.toggle-container input:radio').on('change', function () {
    $(this).closest('.toggle-container').find('.toggle-title').removeClass('active');
    $(this).closest('.toggle-container').find('.toggle').removeClass('right');
    if ($(this).is(':checked')) {
        $(this).parent().find('.toggle-title').addClass('active');
        if ($(this).parent().hasClass('left')) {
            $(this).closest('.toggle-container').find('.toggle').removeClass('right');
        } else {
            $(this).closest('.toggle-container').find('.toggle').addClass('right');
        }
    }
})

$('.toggle-container .toggle').on('click', function () {
    if ($(this).hasClass('right')) {
        $(this).parent().find('.left input:radio').prop('checked', true).change();
    } else {
        $(this).parent().find('.right input:radio').prop('checked', true).change();
    }
})
//toggle switch ends

//wizard
$('.wizard__tab--checkboxes input:checkbox, .wizard__tab--checkboxes input:radio').click(function () {
    if ($(this).hasClass('ignore')) {
        return;
    }
    if ($(this).prop("checked") == true) {
        $(this).closest('.wizard__tab').find('.hint').removeClass('hint--red');
    }
});

$('.user-disability input[type="checkbox"]').on('change', function () {
    if ($(this).parents('.disability').length) {
        if ($(this).prop('checked')) {
            $(this).parent().siblings('.disability-details').addClass('active');
            $(this).parent().siblings('.disability-details').find('input').removeAttr('disabled');
            $('.user-disability.no-disability input[type="checkbox"]').prop('checked', false);
            $(this).parents('.user-disability').addClass('level1');
        } else {
            $(this).parent().siblings('.disability-details').removeClass('active');
            $(this).parent().siblings('.disability-details').find('input').attr('disabled', '');
            $(this).parents('.user-disability').removeClass('level1');
            //$(this).parents('.user-disability').removeClass('level2');
        }
    } else if ($(this).parents('.no-disability').length) {
        if ($(this).prop('checked')) {
            $('.user-disability.disability').removeClass('level1');
            $('.user-disability.disability').removeClass('level2');
            $('.user-disability.disability input[type="checkbox"]').prop('checked', false);
            $('.user-disability.disability .disability-details input').attr('disabled', '');
            $('.user-disability.disability .disability-details').removeClass('active');
            $(this).parent().parent().parent().find('input[type="text"]').val('');
            $(this).parent().parent().parent().find('input[type="radio"]').prop('checked', false);
            $(this).parent().parent().parent().find('input[type="radio"]').parent().removeClass('active');
        } else {
            $('.user-disability.no-disability input[type="checkbox"]').prop('checked', true)
        }
    }
});

$('.education-wrapper .form__group input').on('input', function () {
    if ($(this).val() !== '') {
        $('.education-wrapper .user-disability.no-disability input[type="checkbox"]').prop('checked', false)
    }
})

$previousActive = 0;

if ($viewportWidth <= 991) {
    $('.wizard__indicator .bar').width($('.wizard__indicator').width() / $('.wizard__tab').length + 'px');

    //login small nav
    $('.open-registration-links').click(function () {
        if ($(this).closest('body').find('.reset-1').length != 0) {
            $(this).closest('body').find('.user-area-nav .go-back').removeAttr('href');
        }
        $('.registration-links').addClass('active');
        $('.go-back').addClass('active');
        $(this).closest('body').find('.go-back').unbind('click');
        $(this).closest('body').find('.go-back').click(function () {
            $('.registration-links').removeClass('active');
            $(this).removeClass('active');
            if ($(this).closest('body').find('.reset-1').length != 0) {
                $(this).addClass('active');
                setTimeout(() => {
                    $(this).attr('href', '/login');
                }, 100);
            }
        })
    })
    //login small nav
}

//option other
// $('.option-other input:checkbox').on('change', function () {
//     if ($(this).is(':checked')) {
//         $(this).closest('.option-other').find('.form__group').removeClass('disabled');
//         $(this).closest('.option-other').find('.form__group input').attr('disabled', false);
//         $(this).closest('.option-other').find('.form__group input:text').attr('pattern', '.{1}');
//     } else {
//         $(this).closest('.option-other').find('.form__group').addClass('disabled');
//         $(this).closest('.option-other').find('.form__group').removeClass('filled');
//         $(this).closest('.option-other').find('.form__group input').attr('disabled', true);
//         $(this).closest('.option-other').find('.form__group input').val('');
//         $(this).closest('.option-other').find('.form__group input:text').removeAttr('pattern');
//         $(this).closest('.option-other').find('.form__group input:text').removeClass('fucked-up');
//         $(this).closest('.option-other').find('.form__tooltip').removeClass('form__tooltip--error');
//     }
// })

$('.option-other .checkbox-container input').on('change', function () {
    if ($(this).is(':checked')) {
        $(this).closest('.option-other').find('.form__group input:text').attr('pattern', '.{1}');
        $(this).closest('.option-other').find('.form__input').attr('disabled', false);
        $(this).closest('.option-other').find('.form__group input:text').focus();
    } else {
        $(this).closest('.option-other').find('.form__group').removeClass('filled');
        $(this).closest('.option-other').find('.form__input').val('');
        $(this).closest('.option-other').find('.form__input').removeAttr('pattern');
        $(this).closest('.option-other').find('.form__input').removeClass('fucked-up');
        $(this).closest('.option-other').find('.form__input').attr('disabled', true);
        $(this).closest('.option-other').find('.form__group input:text').removeAttr('pattern');
    }
})

// $('.option-other input:text').on('input', function () {
//     if ($(this).val != '') {
//         $(this).attr('pattern', '.{1}');
//         $(this).closest('.option-other').find('.checkbox-container input:checkbox').prop('checked', true).change();
//     } else {
//         $(this).removeAttr('pattern');
//         $(this).closest('.option-other').find('.checkbox-container input:checkbox').prop('checked', true).change();
//     }
// })

// $('.width-option-other input:radio:not(.other-radio)').on('change', function () {
//     $('.option-other input:radio').change();
// })
//option other ends

$('.wizard__step').click(function () {
    if ($(this).hasClass('wizard__step--blue')) {
        return;
    }
    $activeTabIndex = $('.wizard__tab.active').index();

    $clickedIndex = $(this).index();

    if ($clickedIndex == $activeTabIndex) {
        return
    }

    $inputs = [];

    let selector = '';

    $isValid = true;

    for (var i = 1; i <= $clickedIndex; i++) {
        if ($(this).index() >= $activeTabIndex) {
            if ($(".wizard__tab:nth-child(" + i + ")").hasClass('wizard__tab--checkboxes')) {
                if (!$(".wizard__tab:nth-child(" + i + ") input:not(.ignore):checked").length) {
                    $('.wizard__tab--checkboxes:nth-child(' + i + ') .hint:not(.hint--fixed)').addClass('hint--red');
                    $isValid = false;
                }

                if ($(".wizard__tab:nth-child(" + i + ") .form__group").length != 0) {
                    selector += ".wizard__tab:nth-child(" + i + "),";
                }

            } else {
                selector += ".wizard__tab:nth-child(" + i + "),";
            }

            //input text in checkboxes
            if ($(".wizard__tab:nth-child(" + i + ")").hasClass('input-in-checkboxes')) {
                selector += ".wizard__tab:nth-child(" + i + "),";
            }
            //input text in checkboxes ends

        }
    }

    $inputs = $(selector.substring(0, selector.length - 1)).find('.form__input');

    $inputs.each(function () {
        $value = $(this).val();
        $pattern = $(this).attr('pattern');
        if (!new RegExp($pattern).test($value) || $(this).hasClass('fucked-up') || $(this).hasClass('used-data') || ($(this).parent().hasClass('rating-single') && $value < 1 || $(this).parent().hasClass('rating-single') && $value > 5) || ($(this).attr('type') == 'checkbox') && !$(this).prop('checked')) {
            $isValid = false;
            $(this).addClass('fucked-up');
            $(this).parent().find('.form__tooltip--error').addClass('active');
            $(this).parent().find('.form__tooltip--light').addClass('form__tooltip--error active');
        }
        comparePasswords($(this));
    })

    // $isValid = true;

    if (!$isValid) {
        return
    }

    $index = $(this).index();
    $('.wizard__step').removeClass('active');

    //handle step titles
    if ($viewportWidth > 991) {
        $('.wizard__step .title').removeClass('active');
        $(this).find('.title').addClass('active');
        $('.wizard__step').eq($index + 1).find('.title').addClass('active');
        if ($index > 0) {
            $('.wizard__step').eq($index - 1).find('.title').addClass('active');
        }
    }
    //handle step titles end

    $(this).addClass('active');
    $parentOffset = $('.wizard__steps').offset();
    $offset = $(this).offset();
    $stepWidth = $(this).width();
    $indicator = $('.wizard__indicator .bar');

    //indicator bar width
    if ($viewportWidth <= 991) {
        $wholeWidth = $('.wizard__indicator').width();
        $tabsCount = $('.wizard__tab').length;
        $indicator.width($wholeWidth / $tabsCount + 'px');
        $indicator.css('left', $indicator.width() * $('.wizard__step.active').index() + 'px');
    } else {
        $indicator.width($stepWidth + 'px');
        $indicator.css('left', $offset.left - $parentOffset.left + 'px');
    }
    //indicator bar width ends

    $('.wizard__tab').removeClass('active');
    if ($previousActive < $index) {
        $('.wizard__tab').removeClass('fadeInLeft fadeInRight');
        $(".wizard__tab:nth-child(" + ($index + 1) + ")").addClass('active fadeInRight');
    } else {
        $('.wizard__tab').removeClass('fadeInLeft fadeInRight');
        $(".wizard__tab:nth-child(" + ($index + 1) + ")").addClass('active fadeInLeft');
    }

    if ($('.wizard__tab.active').next().length == 0) {
        if ($('.wizard__tab').closest('.query-tab').length != 0) {
            $('.next-step').css('display', 'inline-flex');
        } else {
            $('.next-step').css('display', 'none');
            $('.final-registration').css('display', 'inline-flex');
        }
    } else {
        $('.next-step').css('display', 'inline-flex');
        $('.final-registration').css('display', 'none');
    }

    $previousActive = $index;

    if ($viewportWidth <= 991) {
        //wizard arrow button
        if ($('.wizard__tab.active').index() != 0) {
            $('.registration-container').closest('body').find('.user-area-nav .go-back').unbind('click');
            $('.registration-container').closest('body').find('.user-area-nav .go-back').click(function () {
                $tabIndex = $('.wizard__tab.active').index();
                $(".wizard__step:nth-child(" + ($tabIndex) + ")").click();
            })
        } else {

            $('.registration-container').closest('body').find('.go-back').click(function () {
                goBack();
            })
        }
        //wizard arrow functionality ends
    }
})

if ($viewportWidth <= 991) {

    // user wizard header navigation

    if ($('.user-registration-main').length) {
        const steps = $('.user-registration-main .wizard__step');
        let count = steps.length;
        if (count < 10) {
            count = '0' + count;
        }
        steps.each(function (index) {
            const text = $(this).text();
            $(this).text(text.replace('.', '/' + count + '  '));
        });
    }

    $('.user-registration-main img.first-tab').on('click', function () {
        if ($(this).hasClass('disabled')) {
            return;
        }
        $('.user-registration-main .wizard__steps .wizard__step').eq(0).click();
    });

    $('.user-registration-main img.last-tab').on('click', function () {
        if ($(this).hasClass('disabled')) {
            return;
        }
        let steps = $('.user-registration-main .wizard__steps .wizard__step');
        steps.eq(steps.length - 1).click();
    });

    $('.user-registration-main img.prev-tab').on('click', function () {
        if ($(this).hasClass('disabled')) {
            return;
        }
        const currentIndex = $('.user-registration-main .wizard__steps .wizard__step.active').index();
        $('.user-registration-main .wizard__steps .wizard__step').eq(currentIndex - 1).click();
    });

    $('.user-registration-main img.next-tab').on('click', function () {
        if ($(this).hasClass('disabled')) {
            return;
        }
        const currentIndex = $('.user-registration-main .wizard__steps .wizard__step.active').index();
        $('.user-registration-main .wizard__steps .wizard__step').eq(currentIndex + 1).click();
    });


    if ($('.org-registration-main').length) {
        const steps = $('.org-registration-main .wizard__step');
        let count = steps.length;
        if (count < 10) {
            count = '0' + count;
        }
        steps.each(function (index) {
            const text = $(this).text();
            $(this).text(text.replace('.', '/' + count + '  '));
        });
    }

    $('.org-registration-main img.first-tab').on('click', function () {
        if ($(this).hasClass('disabled')) {
            return;
        }
        $('.org-registration-main .wizard__steps .wizard__step').eq(0).click();
    });

    $('.org-registration-main img.last-tab').on('click', function () {
        if ($(this).hasClass('disabled')) {
            return;
        }
        let steps = $('.org-registration-main .wizard__steps .wizard__step');
        steps.eq(steps.length - 1).click();
    });

    $('.org-registration-main img.prev-tab').on('click', function () {
        if ($(this).hasClass('disabled')) {
            return;
        }
        const currentIndex = $('.org-registration-main .wizard__steps .wizard__step.active').index();
        $('.org-registration-main .wizard__steps .wizard__step').eq(currentIndex - 1).click();
    });

    $('.org-registration-main img.next-tab').on('click', function () {
        if ($(this).hasClass('disabled')) {
            return;
        }
        const currentIndex = $('.org-registration-main .wizard__steps .wizard__step.active').index();
        $('.org-registration-main .wizard__steps .wizard__step').eq(currentIndex + 1).click();
    });

    $('.org-registration-main img, .user-registration-main img').on('click', function () {
        const steps = $('.wizard__header .wizard__step');
        const currentIndex = $('.wizard__header .wizard__steps .wizard__step.active').index();

        $('.wizard__header img').removeClass('disabled');

        if (currentIndex == 0) {
            $('.wizard__header img.prev-tab').addClass('disabled');
            $('.wizard__header img.first-tab').addClass('disabled');
        } else if (currentIndex == (steps.length - 1)) {
            $('.wizard__header img.next-tab').addClass('disabled');
            $('.wizard__header img.last-tab').addClass('disabled');
        }
    })
    // end user wizard header navigation

    $('.user-area-nav .go-back').click(function () {
        goBack();
    })

    $('.registration-container').closest('body').find('.user-area-nav .go-back').addClass('active');

    $('.reset-1').closest('body').find('.user-area-nav .go-back').addClass('active');
    $('.reset-1').closest('body').find('.user-area-nav .go-back').unbind('click');
    $('.reset-1').closest('body').find('.user-area-nav .go-back').attr('href', '/login');

    // $('.user-area-nav .go-back').click(function () {
    //     goBack();
    // })

    if ($('.wizard__tab.active').index() != 0) {
        $('.registration-container').closest('body').find('.user-area-nav .go-back').click(function () {
            goBack();
        })
    }

    if ($('.profile-tab').hasClass('active') || $('.my-profile-tab').hasClass('active')) {
        $('.profile').closest('body').find('.user-area-nav .go-back').addClass('active');
        $('.profile').closest('body').find('.user-area-nav .go-back').unbind('click');
    }

    $('.profile').closest('body').find('.user-area-nav .go-back').click(function () {
        $('.profile-tab.active, .my-profile-tab.active').removeClass('active');
        $('.my-profile-button').removeClass('active');
        $(this).removeClass('active');
        var pageUrl = '?';
        window.history.pushState('', '', pageUrl);
    })


}

function goBack() {
    window.history.back();
}


$('.next-step').click(function () {
    $tabIndex = $('.wizard__tab.active').index();
    $(".wizard__step:nth-child(" + ($tabIndex + 2) + ")").click();
    // if ($('.wizard__tab.active').next().length == 0) {
    //     if ($('.wizard__tab').closest('.query-tab').length != 0) {
    //         $('.next-step').css('display', 'inline-flex');
    //     } else {
    //         $('.next-step').css('display', 'none');
    //         $('.final-registration').css('display', 'inline-flex');
    //     }
    // } else {
    //     $('.next-step').css('display', 'inline-flex');
    //     $('.final-registration').css('display', 'none');
    // }
    if ($viewportWidth <= 991) {
        $(this).removeClass('not-hover');
        $('.blue-layout-md').animate({
            scrollTop: 0
        }, 600);
        setTimeout(() => {
            // console.log($(this));
            $(this).addClass('not-hover');
        }, 500);
    }
})

$('.confirmation-checkbox').on('click', function () {
    validateTerms();
})

$('form .button:not(.final-registration)').on('click', function (e) {
    if ($(this).hasClass('non-submit')) {
        return false;
    }
    if ($(this).closest('.query-tab').length == 0) {
        if ($(this).hasClass('edit')) {
            e.preventDefault();
            $(this).parents('form').find('input, select').removeAttr('disabled');
            $(this).parents('form').find('.form__group').removeClass('disabled');
            $(this).removeClass('edit');
            $(this).addClass('save');
            return;
        } else {
            e.preventDefault();
            let inputs = [];
            let allowSubmit = true;
            //changed
            // inputs = $(this).parent().find('input');
            inputs = $(this).closest('form').find('input');
            //changed
            inputs.each(function () {
                if (!validation($(this))) {
                    allowSubmit = false;
                    $(this).parent().find('.form__tooltip--error').addClass('active');
                    $(this).parent().find('.form__tooltip--light').addClass('form__tooltip--error active');
                }
            })
            if (allowSubmit) {
                $(this).closest('form').submit();
            }
        }
    }
});


$('.final-registration').on('click', function (e) {
    e.preventDefault();
    validateTerms();
    let inputs = [];
    inputs = $('.form-registration').find("input");
    inputs.each(function (index) {
        if (!checkAndValidate($(this))) {
            $('.final-registration').addClass('disabled disabled-2');
        }
    })
    if ($(this).hasClass('disabled-2') || $(this).hasClass('disabled')) {
        return;
    } else {
        $(this).closest('form').submit();
    }
})
//wizard ends


//parse file name
function parseFileName(path, symbol) {
    return path.substring(path.lastIndexOf(symbol) + 1);
}
//parse file name ends

//image uploader

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            if ($('#uploadedImage').length) {
                $('#uploadedImage').attr('src', e.target.result);
            }
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$('#inputFile').change(function () {
    $limitExceeded = validateFileSize($(this));
    if ($limitExceeded) {
        $altText = $(this).closest('.form__group').find('.form__tooltip div').attr('alt-text');
        $(this).closest('.form__group').find('.form__tooltip div').text($altText);
        $(this).closest('.form__group').find('.form__tooltip').addClass('form__tooltip--error active');
        setTimeout(() => {
            $defaultText = $(this).closest('.form__group').find('.form__tooltip div').attr('default-text');
            $(this).closest('.form__group').find('.form__tooltip div').text($defaultText);
            $(this).closest('.form__group').find('.form__tooltip').removeClass('form__tooltip--error active');
        }, 5000);
        return;
    }

    $defaultText = $(this).closest('.form__group').find('.form__tooltip div').attr('default-text');
    $(this).closest('.form__group').find('.form__tooltip div').text($defaultText);
    $(this).closest('.form__group').find('.form__tooltip').removeClass('form__tooltip--error active');

    readURL(this);

    $imagePath = $(this).val();
    if ($imagePath.indexOf('\\') >= 0) {
        $fileName = parseFileName($imagePath, '\\');
    } else if ($imagePath.indexOf('/') >= 0) {
        $fileName = parseFileName($imagePath, '/');
    }
    if ($imagePath.length != 0) {
        $(this).closest('.file-uploader').addClass('filled');
        $(this).closest('.file-uploader').find('.img-src--filled .file-name').text($fileName);
    } else {
        $(this).closest('.file-uploader').removeClass('filled');
    }
})

$('.delete-img').click(function () {
    $(this).closest('.file-uploader').find('#inputFile').val('');
    $(this).closest('.file-uploader').removeClass('filled');
})

$('.popup .delete-img').click(function () {
    $(this).closest('form').find('.img-save').addClass('disabled');
    $(this).closest('form').find('.img-save').attr('disabled', true);
})

//filesize restriction

function validateFileSize(inputObj) {
    let input = inputObj[0];
    if (Math.round((input.files[0].size / 1024)) > 20480) {
        input.value = "";
        return true;
    } else {
        return false;
    }
}
//filesize restrictions ends

$('.profile-img-upload #inputFile').on('change', function () {
    if ($(this).val() != '') {
        $(this).closest('form').find('button').removeAttr('disabled')
        $(this).closest('form').find('button').removeClass('disabled');
    }
})

//image uploader ends



$(function () {
    var currentYear = new Date().getFullYear()
    $('.bdate').datepicker({
        dateFormat: 'dd.mm.yy',
        changeMonth: true,
        changeYear: true,
        yearRange: "1900:" + currentYear
    });

    $('.terms-button, a.terms').click(function (e) {
        e.preventDefault();
        var pageUrl = '?' + 'popup=terms';
        window.history.pushState('', '', pageUrl);
        setTimeout(function () {
            $('.popup-terms').addClass('popup-active');
            $('body').addClass('frozen');
        });
    })

    $('.privacy-policy-button, a.privacy').click(function (e) {
        e.preventDefault();
        var pageUrl = '?' + 'popup=privacy';
        window.history.pushState('', '', pageUrl);
        $('.popup-privacy').addClass('popup-active');
        $('body').addClass('frozen');
    })



    $('.profile-pic-upload').click(function (e) {
        e.preventDefault();
        $('.popup-profile-pic').addClass('popup-active');
        $('body').addClass('frozen');
    })

    $('.login-popup-trigger').click(function (e) {
        e.preventDefault();
        $('.popup-login').addClass('popup-active');
        $('body').addClass('frozen');

        $('.popup-login .title-default').css('display', 'block');
        $('.popup-login .title-subscription').css('display', 'none');
    })

    $(document).on('click', '.share, .event__share', function (e) {
        e.preventDefault();
        $('.popup-share').addClass('popup-active');
        $('body').addClass('frozen');
        let shareUrl = $(this).data('url');
        $('.share-link-container').val(shareUrl);
        let anchorUrl = $('.share-button--facebook').attr('href').split('href=')[0];
        $('.share-button--facebook').attr('href', anchorUrl + 'href=' + shareUrl);
        anchorUrl = $('.share-button--twitter').attr('href').split('url=')[0];
        $('.share-button--twitter').attr('href', anchorUrl + 'url=' + shareUrl);

        $('.share-link').find('.button').removeClass('active');
        $('.copy-button').addClass('active');
    })

    $('.copy-button').click(function () {
        copyFunction();
        $(this).closest('.share-link').find('.button').removeClass('active');
        $('.copied-button').addClass('active');
    })

    function copyFunction() {
        var copyText = document.getElementById("input-to-copy");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
    }

    $('.popup__close').click(function () {
        $('.popup').removeClass('popup-active');
        $('body').removeClass('frozen');
        window.history.pushState('', '', '?');
    })

    $(document).keydown(function (e) {
        if (e.keyCode == 27) {
            $('.popup').removeClass('popup-active');
            $('body').removeClass('frozen');
            window.history.pushState('', '', '?');
        }
    });

    $('.subscibed-organization .delete').on('click', function (e) {
        let $this = $(this);
        // let companyId = $this.data('company-id');
        // $.ajax({
        //     type: 'POST',
        //     url: $('body').data('url') + '/unsubscribe-company',
        //     data: {
        //         companyId: companyId,
        //         locale: $('body').data('locale')
        //     },
        //     success: function (data) {
        //         $this.parent().hide();
        //     }
        // });
        if ($this.hasClass('allow-delete')) {
            let companyId = $this.data('company-id');
            $.ajax({
                type: 'POST',
                url: $('body').data('url') + '/unsubscribe-company',
                data: {
                    id: companyId,
                    locale: $('body').data('locale')
                },
                success: function (data) {
                    $this.parent().hide();
                    if ($this.closest('.profile-grid').length) {
                        location.reload();
                    }
                }
            });
        } else {
            $this.addClass('allow-delete');
            setTimeout(() => {
                $this.removeClass('allow-delete');
            }, 5000);
        }
    });

    $('.profile-tab .subscibed-organization, .profile-tab .subscibed-category').on('click', function (e) {
        let target = $(e.target);
        if (!target.hasClass('delete') && !target.parents('.delete').length) {
            let href = $(this).attr('href');
            window.location.href = href;
        }
    })

    $('.subscribed-categories .subscibed-category .delete').on('click', function (e) {
        let $this = $(this);
        if ($this.hasClass('allow-delete')) {
            let categoryId = $this.data('category-id');
            $.ajax({
                type: 'POST',
                url: $('body').data('url') + '/unsubscribe-category',
                data: {
                    id: categoryId,
                    locale: $('body').data('locale')
                },
                success: function (data) {
                    $this.parent().hide();
                    if ($this.closest('.profile-grid').length) {
                        location.reload();
                    }
                }
            });
        } else {
            $this.addClass('allow-delete');
            setTimeout(() => {
                $this.removeClass('allow-delete');
            }, 5000);
        }
    });


    $('.switch .switch__item').on('click', function (e) {

        if ($(this).hasClass('disabled')) {
            return;
        }
        // $('.switch .switch__item').removeClass('active');
        $(this).parent().find('.switch__item').removeClass('active');
        $(this).addClass('active');
        if ($(this).parent().hasClass('no-ajax')) {
            return;
        }

        if ($(this).parents('.switch.search-switch').length == 0) {
            $('.opportunity-pagination .page-item.prev').addClass('disabled');
            $('.opportunity-pagination .page-item.next').removeClass('disabled');
            $('.opportunity-pagination .page-item').removeClass('active');
            $('.opportunity-pagination .page-link[data-new-page="1"]').parent().addClass('active');

            $('body').attr('data-page', 1);

            let sort = $(this).data('sort');
            let numberPerPage = $('body').data('number-per-page') || 9;

            fetchOpportunities(numberPerPage, 1, sort, false);
        }
    });

    $(document).on('click', '#opportunity-pagination .page-item .page-link', function (e) {
        if ($(this).parent().hasClass('disabled')) {
            return;
        }
        let page = parseInt($(this).data('new-page'));
        if (page > 1) {
            $('.opportunity-pagination .page-item.prev').removeClass('disabled');
        } else {
            $('.opportunity-pagination .page-item.prev').addClass('disabled');
        }
        if ($(this).parent().hasClass('last')) {
            $('.opportunity-pagination .page-item.next').addClass('disabled');
        } else {
            $('.opportunity-pagination .page-item.next').removeClass('disabled');
        }
        $('.opportunity-pagination .page-item').removeClass('active');
        $(this).parent().addClass('active');


        let sort = $('.switch .switch__item.active').data('sort');
        let numberPerPage = $('body').data('number-per-page') || 9;


        var cur_page = window.location.pathname
        window.history.pushState("", "", `${cur_page}?page=${page}`);

        fetchOpportunities(numberPerPage, page, sort, true);
    });

    $(document).on('click', '#organization-pagination .page-item .page-link', function (e) {
        if ($(this).parent().hasClass('disabled')) {
            return;
        }
        let page = parseInt($(this).data('new-page'));
        if (page > 1) {
            $('.opportunity-pagination .page-item.prev').removeClass('disabled');
        } else {
            $('.opportunity-pagination .page-item.prev').addClass('disabled');
        }
        if ($(this).parent().hasClass('last')) {
            $('.opportunity-pagination .page-item.next').addClass('disabled');
        } else {
            $('.opportunity-pagination .page-item.next').removeClass('disabled');
        }
        $('.opportunity-pagination .page-item').removeClass('active');
        $(this).parent().addClass('active');

        let sort = $('.switch .switch__item.active').data('sort');
        let numberPerPage = $('body').data('number-per-page') || 9;

        var cur_page = window.location.pathname
        window.history.pushState("", "", `${cur_page}?page=${page}`);

        fetchCompanies(numberPerPage, page, sort, true);
    });

    $(document).on('click', '.company-pagination .page-item .page-link', function (e) {
        if ($(this).parent().hasClass('disabled')) {
            return;
        }
        let page = parseInt($(this).data('new-page'));
        if (page > 1) {
            $('.company-pagination .page-item.prev').removeClass('disabled');
        } else {
            $('.company-pagination .page-item.prev').addClass('disabled');
        }
        if ($(this).parent().hasClass('last')) {
            $('.company-pagination .page-item.next').addClass('disabled');
        } else {
            $('.company-pagination .page-item.next').removeClass('disabled');
        }
        $('.company-pagination .page-item').removeClass('active');
        $(this).parent().addClass('active');

        let numberPerPage = $('body').data('company-number-per-page') || 9;

        fetchCompanies(numberPerPage, page, true);
    });

    $('#filter-opportunities-button').on('click', function (e) {
        let sort = $('.switch .switch__item.active').data('sort');
        let page = $('body').data('page') || 1;
        let numberPerPage = $('body').data('number-per-page') || 9;

        $('.opportunity-pagination .page-item.prev').addClass('disabled');
        $('.opportunity-pagination .page-item.next').removeClass('disabled');
        $('.opportunity-pagination .page-item').removeClass('active');
        $('.opportunity-pagination .page-link[data-new-page="1"]').parent().addClass('active');

        $('body').attr('data-page', 1);

        fetchOpportunities(numberPerPage, 1, sort, false);
    });

    $('#filter-opportunities-button-mobile').on('click', function (e) {
        let sort = $('.switch .switch__item.active').data('sort');
        let page = $('body').data('page') || 1;
        let numberPerPage = $('body').data('number-per-page') || 9;

        $('.opportunity-pagination .page-item.prev').addClass('disabled');
        $('.opportunity-pagination .page-item.next').removeClass('disabled');
        $('.opportunity-pagination .page-item').removeClass('active');
        $('.opportunity-pagination .page-link[data-new-page="1"]').parent().addClass('active');

        $('body').attr('data-page', 1);

        fetchOpportunities(numberPerPage, 1, sort, false);
    });

    $('#filter-companies-button').on('click', function (_e) {
        let sort = $('.switch .switch__item.active').data('sort');
        let page = $('body').data('page') || 1;
        let numberPerPage = $('body').data('number-per-page') || 9;

        $('.opportunity-pagination .page-item.prev').addClass('disabled');
        $('.opportunity-pagination .page-item.next').removeClass('disabled');
        $('.opportunity-pagination .page-item').removeClass('active');
        $('.opportunity-pagination .page-link[data-new-page="1"]').parent().addClass('active');

        $('body').attr('data-page', 1);

        fetchCompanies(numberPerPage, 1, sort, false);
    });

    $('#filter-companies-button-mobile').on('click', function (_e) {
        let sort = $('.switch .switch__item.active').data('sort');
        let page = $('body').data('page') || 1;
        let numberPerPage = $('body').data('number-per-page') || 9;

        $('.opportunity-pagination .page-item.prev').addClass('disabled');
        $('.opportunity-pagination .page-item.next').removeClass('disabled');
        $('.opportunity-pagination .page-item').removeClass('active');
        $('.opportunity-pagination .page-link[data-new-page="1"]').parent().addClass('active');

        $('body').attr('data-page', 1);

        fetchCompanies(numberPerPage, 1, sort, false);
    });

    $('.filters-container.mobile .toggle-filters').on('click', function () {
        $(this).parents('.filters-container').toggleClass('expanded');
    });

    $('.subscribe').on('click', function (e) {
        if ($('body').attr('is-logged-in') == 1 && !$(this).hasClass('subscribe-btn')) {
            let id = $(this).data('id');
            let url = $(this).data('url');
            subscriptionAction(id, url);
        } else {
            return;
        }
    });



    //code timer
    const FULL_DASH_ARRAY = 283;
    const WARNING_THRESHOLD = 10;
    const ALERT_THRESHOLD = 5;

    const COLOR_CODES = {
        info: {
            color: "#fff"
        },
        warning: {
            color: "#fff",
            threshold: WARNING_THRESHOLD
        },
        alert: {
            color: "#fff",
            threshold: ALERT_THRESHOLD
        }
    };

    const TIME_LIMIT = 30;
    let timePassed = 0;
    let timeLeft = TIME_LIMIT;
    let timerInterval = null;
    let remainingPathColor = COLOR_CODES.info.color;

    if ($('.wizard__tabs').length != 0 && !$('.wizard__tabs').hasClass('query-wizard-tabs')) {

        document.getElementById("code-timer").innerHTML = `
    <div class="base-timer">
      <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
        <g class="base-timer__circle">
          <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
          <path
            id="base-timer-path-remaining"
            stroke-dasharray="283"
            class="base-timer__path-remaining white"
            d="
              M 50, 50
              m -45, 0
              a 45,45 0 1,0 90,0
              a 45,45 0 1,0 -90,0
            "
          ></path>
        </g>
      </svg>
      <span id="base-timer-label" class="base-timer__label">${formatTime(
            timeLeft
        )}</span>
    </div>
    `;
    }

    function onTimesUp() {
        clearInterval(timerInterval);
    }

    function startTimer() {
        timePassed = 0;
        timerInterval = setInterval(() => {
            timePassed = timePassed += 1;
            timeLeft = TIME_LIMIT - timePassed;
            document.getElementById("base-timer-label").innerHTML = formatTime(
                timeLeft
            );
            setCircleDasharray();
            setRemainingPathColor(timeLeft);

            if (timeLeft === 0) {
                onTimesUp();
            }
        }, 1000);
    }

    function formatTime(time) {
        const minutes = Math.floor(time / 60);
        let seconds = time % 60;

        if (seconds < 10) {
            seconds = `0${seconds}`;
        }

        return `${minutes}:${seconds}`;
    }

    function setRemainingPathColor(timeLeft) {
        const { alert, warning, info } = COLOR_CODES;
        if (timeLeft <= alert.threshold) {
            document
                .getElementById("base-timer-path-remaining")
                .classList.remove(warning.color);
            document
                .getElementById("base-timer-path-remaining")
                .classList.add(alert.color);
        } else if (timeLeft <= warning.threshold) {
            document
                .getElementById("base-timer-path-remaining")
                .classList.remove(info.color);
            document
                .getElementById("base-timer-path-remaining")
                .classList.add(warning.color);
        }
    }

    function calculateTimeFraction() {
        const rawTimeFraction = timeLeft / TIME_LIMIT;
        return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
    }

    function setCircleDasharray() {
        const circleDasharray = `${(
            calculateTimeFraction() * FULL_DASH_ARRAY
        ).toFixed(0)} 283`;
        document
            .getElementById("base-timer-path-remaining")
            .setAttribute("stroke-dasharray", circleDasharray);
    }

    //code timer ends




    $isCodeActive = true;
    $delayTime = 30000;
    $('.send-code').on('click', function () {
        if ($isCodeActive) {
            $isCodeActive = false;
            $this = $(this);
            $.ajax({
                type: 'POST',
                url: $('body').data('url') + '/ajax-send-code',
                data: {
                    email: $('.wrapper #email').val()
                },
                success: function (data) {
                    //$this.css('width', '0');
                    startTimer();
                    $('.base-timer').addClass('active');
                    $('.send-code span').text($('.send-code').data('alternate-text'));
                    $this.addClass('show-tooltip');
                    $this.addClass('disabled');
                    //$('.code-container .text-red').text($('.code-container .text-red').data('alternate-text'));
                    //$redTextWidth = $('.code-container .text-red').outerWidth();
                    //$('.send-code').animate({ width: $redTextWidth + "px" }, $delayTime);
                    setTimeout(() => {
                        $isCodeActive = true;
                        $this.removeClass('disabled');
                        $('.base-timer').removeClass('active');
                    }, $delayTime);
                }
            });
        }
    });

    $('input[name="code"]').on('input', function () {
        let text = $(this).val();
        if (text.length > 4) {
            text = text.substring(0, 4);
        }
        $(this).val(text);
        $codeInput = $(this);
        if (text.length == 4) {
            $('.success-icon').removeClass('icon-success');
            $('.success-icon').removeClass('icon-fail');
            $('.success-icon').addClass('icon-loading');
            $.ajax({
                type: 'POST',
                url: $('body').data('url') + '/ajax-check-code',
                data: {
                    email: $('.wrapper #email').val(),
                    code: text
                },
                success: function (data) {
                    if (data.status == 'success') {
                        $('.button.final-registration').removeClass('disabled');
                        $('.success-icon').addClass('icon-success');
                    } else {
                        $('.button.final-registration').addClass('disabled');
                        $codeInput.addClass('fucked-up');
                        $('.success-icon').addClass('icon-fail');
                    }
                },
                error: function () {
                    $('.button.final-registration').addClass('disabled');
                    $codeInput.addClass('fucked-up');
                    $('.success-icon').addClass('active');
                    $('.success-icon').addClass('icon-fail');
                }
            });
        }
    });

    $('.form-registration').submit(function (e) {
        if ($(this).find('.button.final-registration').hasClass('disabled')) {
            return false;
        }
    });

    handleQueryString();

    $('.multiple-download').on('click', function (e) {
        e.preventDefault();
        $('.popup-file-downloader').addClass('popup-active');
        $('body').addClass('frozen');
    });

    // handle adding to goings and favorites
    $('.url-button[action]').on('click', function (e) {
        if ($('body').attr('is-logged-in') != 1) {
            e.preventDefault();
            return;
        }

        if ($(this).attr('action') == 'add-going' && $(this).hasClass('disabled')) {
            e.preventDefault();
            return;
        }

        if ($(this).attr('action') == 'add-favorite' && $(this).hasClass('disabled')) {
            e.preventDefault();
            return;
        }

        const ref = $(this);
        if (!ref.hasClass('open-url')) {
            e.preventDefault();
        }
        let action = '/ajax-add-opportunity-to-going';
        let actionAttr = ref.attr('action');
        let oppositeActionAttr = 'remove-going';

        switch (actionAttr) {
            case 'remove-going':
                action = '/ajax-remove-opportunity-from-going';
                oppositeActionAttr = 'add-going';
                break;
            case 'add-favorite':
                action = '/ajax-add-opportunity-to-favorites';
                oppositeActionAttr = 'remove-favorite';
                break;
            case 'remove-favorite':
                action = '/ajax-remove-opportunity-from-favorites';
                oppositeActionAttr = 'add-favorite';
                break;
            default:
                break;
        }

        $.ajax({
            type: 'POST',
            url: $('body').data('url') + action,
            data: {
                id: ref.data('opportunity-id')
            },
            success: function (data) {
                if (data.status == 'success' && !ref.hasClass('open-url')) {
                    ref.removeClass('active');
                    $('.url-button[action="' + oppositeActionAttr + '"]').addClass('active');
                }
            }
        });
    });

    $(document).on('click', '.profile-tab .pagination .page-item', function (e) {
        if ($(this).hasClass('disabled')) {
            return;
        }
        const wrapper = $(this).parents('.pagination-container');
        let page = 1;
        if ($(this).hasClass('prev')) {
            page = parseInt(wrapper.attr('page')) - 1;
        } else if ($(this).hasClass('next')) {
            page = parseInt(wrapper.attr('page')) + 1;
        } else {
            page = parseInt($(this).find('.page-link').data('new-page'));
        }
        const numberPerPage = wrapper.attr('number-per-page');
        const url = wrapper.attr('url');
        let container = wrapper.siblings('.profile-events');
        if (!container.length) {
            container = wrapper.siblings('.profile-grid');
        }
        $.ajax({
            type: 'GET',
            url: $('body').data('url') + url,
            data: {
                perPage: numberPerPage,
                page: page
            },
            success: function (data) {
                if (data.status && data.status == 'error') {
                    return;
                }
                container.html(data.opportunities);
                if (parseInt(data.count) == 0) {
                    container.find('.not-found').show();
                } else {
                    container.find('.not-found').hide();
                }
                wrapper.html(data.pagination);
                wrapper.attr('page', page);
                $("html, body").animate({
                    scrollTop: 0
                }, 600);
            }
        });
    });
})

function getUrlVars() {
    var vars = [],
        hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function handleQueryString() {
    let params = getUrlVars();
    let popupClass = params['popup'];

    if (popupClass) {
        $('.' + popupClass).click();
    }
}

function fetchCompanies(numberPerPage, page, changePage) {
    let $container = $('#all-companies-list-id');

    // 1. Organization Status
    var companyStatuses = [];
    var all_company_statuses = false
    $('#filter-by-categories-all input:checked').each(function () {
        all_company_statuses = true
    });
    if (!all_company_statuses) {
        $('#filter-by-categories input:checked').each(function () {
            companyStatuses.push($(this).data('id'));
        });
    }

    // 2. Company Working Type
    var companyWorkingType = [];
    var all_company_working_types = false
    $('#filter-by-working-type-all input:checked').each(function () {
        all_company_working_types = true
    });
    if (!all_company_working_types) {
        $('#filter-by-working-type input:checked').each(function () {
            companyWorkingType.push($(this).data('id'));
        });
    }

    // 3. Company Type
    var companyTypes = [];
    var all_company_types = false
    $('#filter-by-company-type-all input:checked').each(function () {
        all_company_types = true
    });
    if (!all_company_types) {
        $('#filter-by-company-type input:checked').each(function () {
            companyTypes.push($(this).data('id'));
        });
    }

    // 4. Registration Municipalities
    var registartion_municipalities = [];
    var all_registration_municipalities = false
    $('#filter-by-registration-municipalities-all input:checked').each(function () {
        all_registration_municipalities = true
    });
    if (!all_registration_municipalities) {
        $('#filter-by-registration-municipalities input:checked').each(function () {
            registartion_municipalities.push($(this).data('id'));
        });
    }

    // 5. Working Municipalities
    var working_municipalities = [];
    var all_working_municipalities = false
    $('#filter-by-working-municipalities-all input:checked').each(function () {
        all_working_municipalities = true
    });
    if (!all_working_municipalities) {
        $('#filter-by-working-municipalities input:checked').each(function () {
            working_municipalities.push($(this).data('id'));
        });
    }


    $.ajax({
        type: 'POST',
        url: $('body').data('url') + '/ajax-filter-companies',
        data: {
            numberPerPage: numberPerPage,
            filterByCompanyStatuses: companyStatuses,
            filterByCompanyWorkingType: companyWorkingType,
            filterByCompanyTypes: companyTypes,
            filterByRegistrationMunicipalities: registartion_municipalities,
            filterByWorkingMunicipalities: working_municipalities,
            page: page,
            locale: $('body').data('locale'),
            term: $('.pagination').length ? $('.pagination').data('search-term') : null
        },
        success: function (data) {
            $container.html(data.companies);
            $('.opportunity-pagination').html(data.pagination);

            $('.not-found').hide();
            if (parseInt(data.count) == 0) {
                $('.not-found').show();
            } else {
                $container.find('.not-found').hide();
            }
            adjustFooter()
            if (changePage) {
                $("html, body").animate({
                    scrollTop: 0
                }, 600);
            }
        }
    });
}

function fetchOpportunities(numberPerPage, page, sort, changePage) {
    let companies = [];
    let companyAttribute = $('body').data('company');
    if (companyAttribute) {
        companies.push(companyAttribute);
    }
    $('.filter--host input:checked').each(function () {
        companies.push($(this).data('id'));
    })


    let types = [];
    let typeAttr = $('body').data('type-id');
    if (typeAttr) {
        types.push(typeAttr);
    }
    // 1. Opportunity SubTypes
    var subtypes = [];
    $('#filter-by-subtypes input:checked').each(function () {
        subtypes.push($(this).data('id'));
    });

    // 2. Categories
    var categories = []
    var all_categories = false
    $('#filter-by-categories-all input:checked').each(function () {
        all_categories = true
    });
    if (!all_categories) {
        $('#filter-by-categories input:checked').each(function () {
            categories.push($(this).data('id'));
        });
    }
    // 3. Municipalities
    var municipalities = [];
    var all_municipalities = false
    $('#filter-by-municipalities-all input:checked').each(function () {
        all_municipalities = true
    });
    if (!all_municipalities) {
        $('#filter-by-municipalities input:checked').each(function () {
            municipalities.push($(this).data('id'));
        });
    }

    // 4. Disabilities
    var disabilities = [];
    var all_disabilities = false;
    $('#filter-by-disabilities-all input:checked').each(function () {
        all_disabilities = true
    });
    if (!all_disabilities) {
        $('#filter-by-disabilities input:checked').each(function () {
            disabilities.push($(this).data('id'));
        });
    }

    // 5. Min Age
    var minAge = null;
    if (!$('#no-min').is(":checked"))
        minAge = $('#min-age').val()

    // 6. Max Age
    var maxAge = null;
    if (!$('#no-max').is(":checked"))
        maxAge = $('#max-age').val()

    let subscribed = $('.filter--subscribed input:checked').first().data('id') == 'subscribed' ? true : false;
    let $container = $('.wrapper .events:not(.subscribed)');
    $.ajax({
        type: 'POST',
        url: $('body').data('url') + '/ajax-filter-opportunities',
        data: {
            numberPerPage: numberPerPage,
            page: page,
            sort: sort,
            filterCompanies: companies,
            // filterRegions: regions,
            filterSubscribed: subscribed,
            filterTypes: types, // 0
            filterSubtypes: subtypes, // 1
            filterCategories: categories, // 2
            filterMunicipalities: municipalities, // 3
            filterDisabilities: disabilities, // 4
            filterMinAge: minAge, // 5
            filterMaxAge: maxAge, // 6
            locale: $('body').data('locale'),
            term: $('.pagination').length ? $('.pagination').data('search-term') : null
        },
        success: function (data) {
            $container.html(data.opportunities);
            if (parseInt(data.count) == 0) {
                $('.not-found').show();
            } else {
                $container.find('.not-found').hide();
            }
            $('.opportunity-pagination').html(data.pagination);

            $('.not-found').hide();
            if (parseInt(data.count) == 0) {
                $('.not-found').show();
            } else {
                $container.find('.not-found').hide();
            }
            adjustFooter()
            if (changePage) {
                $('body').attr('data-page', page);
                $("html, body").animate({
                    scrollTop: 0
                }, 600);
            }
            adjustFooter();
        }
    });
}

function subscriptionAction(id, url = '/subscribe-company') {
    $.ajax({
        type: 'POST',
        url: $('body').data('url') + url,
        data: {
            id: id
        },
        success: function (data) {
            $('.subscribe').toggleClass('active');
            let subsTag = $('.subs-amount span');
            if (subsTag.length) {
                let numSubs = parseInt(subsTag.html());
                if (url.startsWith('/sub')) {
                    subsTag.html((numSubs + 1) + ' ');
                } else {
                    subsTag.html((numSubs - 1) + ' ');
                }
            }
        }
    });
}

$(document).click(function (event) {
    if ($(event.target).hasClass('popup') || $(event.target).hasClass('popup__close')) {
        $("body").find(".popup").removeClass("popup-active");
        $('body').removeClass('frozen');
        window.history.pushState('', '', '?');
        return;
    }

    if ((!$(event.target).hasClass('dropdown') && $(event.target).parents('.dropdown').length == 0) && (!$(event.target).hasClass('header__button--logged-in') && $(event.target).parents('.header__button--logged-in').length == 0)) {
        $('header .dropdown').removeClass('active');
    }

    if ((!$(event.target).hasClass('filter__dropdown') && $(event.target).parents('.filter__dropdown').length == 0) && (!$(event.target).hasClass('filter__button') && $(event.target).parents('.filter__button').length == 0)) {
        $('.filters .filter').removeClass('active');
    }
});

$('.header__button--logged-in').click(function () {
    $('header .dropdown').toggleClass('active');
})
$tabNamesCompany = ['tab=password', 'tab=organizations', 'tab=categories'];
$tabNames = ['tab=organizations', 'tab=categories'];
$profileTabNames = ['tab=private-info', 'tab=disabilities', 'tab=occupation', 'tab=education', 'tab=address', 'tab=password'];

$('.profile__nav:not(.company) li:not(.my-profile):not(.my-profile-button)').click(function () {
    // let curHeight = $('.profile__right').outerHeight();
    // $('.profile__right').outerHeight(curHeight);
    $('.profile__nav li').removeClass('active');
    $index = $(this).index();
    $(this).addClass('active');
    $('.profile-tab').removeClass('active');
    $('.my-profile-tab').removeClass('active');
    $('.my-profile-tab').removeClass('active-lg');
    $('.my-profile-nav').removeClass('active');
    $('.my-profile').removeClass('red');
    $('.profile-tab').eq($index - 2).addClass('active');

    // let nextHeight = $('.profile-tab:nth-child(' + ($index + 1) + ')').outerHeight(true);
    // if (nextHeight > curHeight) {
    //     $('.profile__right').outerHeight(nextHeight);
    // }

    var pageUrl = '?' + $tabNames[$index - 2];
    window.history.pushState('', '', pageUrl);

    if ($viewportWidth <= 991) {
        $('.profile').closest('body').find('.user-area-nav .go-back').addClass('active');
    }
})

$('.my-profile').on('click', function () {
    $(this).toggleClass('active');
    $('.my-profile-nav').toggleClass('active');
})

$('.my-profile-button').on('click', function () {
    $index = $(this).index();
    $('.profile__nav li:not(.my-profile)').removeClass('active');

    $('.my-profile').addClass('active');
    $('.my-profile').addClass('red');

    $(this).addClass('active');
    $('.my-profile-tab').removeClass('active');
    $('.profile-tab').removeClass('active');
    $('.my-profile-tab').removeClass('active-lg');
    $('.my-profile-tab').eq($index).addClass('active');


    var pageUrl = '?' + $profileTabNames[$index];
    window.history.pushState('', '', pageUrl);

    if ($viewportWidth <= 991) {
        $('.profile').closest('body').find('.user-area-nav .go-back').addClass('active');
    }
})

$('.profile__nav.company .tab-button-company').click(function () {
    $('.profile__nav.company .tab-button-company').removeClass('active');
    $index = $(this).index();
    $(this).addClass('active');
    $('.profile-tab').removeClass('active');
    $('.my-profile-tab').removeClass('active');
    $('.my-profile-tab').removeClass('active-lg');
    $('.my-profile-nav').removeClass('active');
    $('.profile-tab').eq($index - 1).addClass('active');

    var pageUrl = '?' + $tabNamesCompany[$index - 1];
    window.history.pushState('', '', pageUrl);

    if ($viewportWidth <= 991) {
        $('.profile').closest('body').find('.user-area-nav .go-back').addClass('active');
    }
})

$(function () {
    $('.profile .user-disability input:checkbox').on('change', function () {
        if ($(this).is(':checked')) {
            if ($(this).parent().parent().hasClass('no-disability')) {
                $(this).closest('.my-profile-tab').find('.user-info-box').removeClass('active');
            } else {
                $(this).closest('.my-profile-tab').find('.user-info-box[data-id-value = ' + $(this).val() + ']').addClass('active');
            }
        } else {
            $(this).closest('.my-profile-tab').find('.user-info-box[data-id-value = ' + $(this).val() + ']').removeClass('active');
        }
        adjustProfileInfoMargin($(this));
    })

    $('.profile .occupation .select-studying input:radio').on('click', function () {
        if ($(this).is(':checked')) {
            $(this).closest('.my-profile-tab').find('.user-studying').addClass('active');
            $(this).closest('.my-profile-tab').find('.user-studying span').text($(this).parent().find('span').text());
        }
        adjustProfileInfoMargin($(this));
    })
    $('.profile .occupation .select-working input:radio').on('click', function () {
        if ($(this).is(':checked')) {
            $(this).closest('.my-profile-tab').find('.user-working').addClass('active');
            $(this).closest('.my-profile-tab').find('.user-working span').text($(this).parent().find('span').text());
        }
        adjustProfileInfoMargin($(this));
    })
    $('.profile .occupation .select-i-am input:radio').on('click', function () {
        if ($(this).is(':checked')) {
            $(this).closest('.my-profile-tab').find('.user-i-am').addClass('active');
            $(this).closest('.my-profile-tab').find('.user-i-am span').text($(this).parent().find('span').text());
        }
        adjustProfileInfoMargin($(this));
    })


    $('.profile .select-education input:radio').on('click', function () {
        if ($(this).is(':checked')) {
            $(this).closest('.my-profile-tab').find('.user-education').addClass('active');
            $(this).closest('.my-profile-tab').find('.user-education span').text($(this).parent().find('span').text());
        }
        adjustProfileInfoMargin($(this));
    })

    $('.profile .select-region input:radio').on('click', function () {
        if ($(this).is(':checked')) {
            $currentRegion = $(this).closest('.my-profile-tab').find('.user-region span').text();
            if ($(this).parent().find('span').text() != $currentRegion) {
                $(this).closest('.my-profile-tab').find('.user-municipality').removeClass('active');
            }
            $(this).closest('.my-profile-tab').find('.user-region').addClass('active');
            $(this).closest('.my-profile-tab').find('.user-region span').text($(this).parent().find('span').text());
        }
        adjustProfileInfoMargin($(this));
    })

    $('.profile .select-municipality input:radio').on('click', function () {
        if ($(this).is(':checked')) {
            $(this).closest('.my-profile-tab').find('.user-municipality').addClass('active');
            $(this).closest('.my-profile-tab').find('.user-municipality span').text($(this).parent().find('span').text());
        }
        adjustProfileInfoMargin($(this));
    })

    $('.profile .select-other input:text').on('keyup', function () {
        if ($(this).val() != '') {
            if ($(this).parent().hasClass('select-foreign-address')) {
                $(this).closest('.my-profile-tab').find('.user-foreign-address').addClass('active');
                $(this).closest('.my-profile-tab').find('.user-foreign-address span').text($(this).val());
            } else if ($(this).parent().hasClass('select-exact-address')) {
                $(this).closest('.my-profile-tab').find('.user-exact-address').addClass('active');
                $(this).closest('.my-profile-tab').find('.user-exact-address span').text($(this).val());
            } else {
                $(this).closest('.my-profile-tab').find('.user-other').addClass('active');
                $(this).closest('.my-profile-tab').find('.user-other span').text($(this).val());
            }
        } else {
            $(this).closest('.my-profile-tab').find('.user-other').removeClass('active');
        }
        adjustProfileInfoMargin($(this));
    })

    $('.profile .country input:radio').on('click', function () {
        $(this).closest('.my-profile-tab').find('.user-info-box').removeClass('active');
        adjustProfileInfoMargin($(this));
    })
})

function adjustProfileInfoMargin(input) {
    input.closest('.my-profile-tab').find('.user-info-boxes').addClass('mb-0');
    if (input.closest('.my-profile-tab').find('.user-info-box.active').length == 0) {
        input.closest('.my-profile-tab').find('.user-info-boxes').addClass('mb-0');
    } else {
        input.closest('.my-profile-tab').find('.user-info-boxes').removeClass('mb-0');
    }
}


// let allowSubmit = true;
// inputs = $(this).parent().find('input');
// inputs.each(function () {
//     if (!checkAndValidate($(this))) {
//         allowSubmit = false;
//     }
// })
// if (allowSubmit) {
//     $(this).parent().submit();
// }


//popup ends

//search tabs
//$('.search-tab:nth-child(' + (1) + ')').addClass('active');

$('.search-switch .switch__item').click(function () {
    $('.search-tab').removeClass('active');
    $index = $(this).index();
    $('.search-tab:nth-child(' + ($index + 1) + ')').addClass('active');
    adjustFooter();
})
//search tabs ends



//filters
$(function () {
    $('.filter__dropdown input').not('.ignore').click(function () {
        if ($(this).parent().hasClass('mobile')) {
            return;
        }
        $defaultTitle = $(this).closest('.filter').find('.filter__button').attr("default");
        if ($(this).parent().hasClass('uncheck-all')) {
            if ($(this).is(':checked')) {
                $(this).parent().nextAll('.checkbox-container').find('input').prop('checked', true);
                $(this).closest('.filter').find('.filter__button').text($(this).parent().find('.title').text());
                $(this).closest('.filter__dropdown').find('.filter__dropdown .separator:not(.separator-static)').remove();
            } else {
                $(this).parent().nextAll('.checkbox-container').find('input').prop('checked', false);
                $(this).closest('.filter').find('.filter__button').text($defaultTitle);
                $(this).closest('.filter__dropdown').find(".checkbox-container.uncheck-all").removeClass('half-checked');
            }
            if ($(this).parents('.filter-popup, .select-section-wrapper').length > 0) {
                const parent = $(this).parents('.filter__dropdown');
                if (parent.hasClass('regions')) {
                    parent.find('.checkbox-container input').each(function () {
                        checkRegionInFilterPopup(this);
                    })
                } else {
                    parent.find('.checkbox-container input').each(function () {
                        checkMunicipalityInFilterPopup(this);
                    })
                }
            }
        } else {
            if ($(this).is(':checked')) {
                if ($(this).closest('.filter__dropdown').find(".checkbox-container:not(.uncheck-all) input:not(:checked)").length == 0) {
                    $(this).closest('.filter__dropdown').find('.uncheck-all').find('input').prop('checked', true);
                    $(this).closest('.filter__dropdown').find(".checkbox-container.uncheck-all").removeClass('half-checked');
                    $(this).closest('.filter__dropdown').find('.separator:not(.separator-static)').remove();
                } else {
                    $(this).closest('.filter__dropdown').find(".checkbox-container.uncheck-all").addClass('half-checked');
                }
            } else {
                $(this).parent().removeClass('checked');
                $(this).closest('.filter__dropdown').find('.uncheck-all').find('input').prop('checked', false);
                if ($(this).closest('.filter__dropdown').find(".checkbox-container:not(.uncheck-all) input:checked").length == 0) {
                    $(this).closest('.filter__dropdown').find(".checkbox-container.uncheck-all").removeClass('half-checked');
                } else {
                    $(this).closest('.filter__dropdown').find(".checkbox-container.uncheck-all").addClass('half-checked');
                }
            }
            let checkedObj = $(this).closest('.filter__dropdown').find("input:checked").parent().find('.title');
            let checked = checkedObj.toArray();
            let checkedCount = checked.length;
            let title = [];
            checked.forEach(element => {
                title.push(element.innerText);
            });
            if (checkedCount != 0) {
                $(this).closest('.filter').find('.filter__button').text(title.join(', '));
            } else {
                $(this).closest('.filter').find('.filter__button').text($defaultTitle);
                $(this).closest('.filter').find('.filter__dropdown .separator:not(.separator-static)').remove();
            }
        }
    })
})

function checkedOnTop() {
    $('.checkbox-container').removeClass('separator');
    $('.filters-container .filter:not(.filter--subscribed)').each(function () {
        let checkboxes = [];
        checkboxes = $(this).find('.filter__dropdown .checkbox-container:not(.uncheck-all) input:checked');
        checkboxes.each(function () {
            $(this).closest('.checkbox-container').addClass('checked');
        })
        lastIndex = checkboxes.length - 1;
        if (checkboxes.length > 0) {
            let separator = document.createElement("b");
            separator.classList.add('separator');
            checkboxes[lastIndex].parentElement.after(separator);
        }
        checkboxes = [];
        $(this).find('.filter__dropdown').scrollTop(0);
    })
}

$('.filter__button').click(function () {
    if ($(this).parents('.has-popup').length) {
        const popupNumber = $(this).parents('.has-popup').data('popup-number');
        $('.filter-popup[data-popup-number="' + popupNumber + '"]').addClass('popup-active');
        $('body').addClass('frozen');
    } else {
        $('.filter').not($(this).closest('.filter')).removeClass('active');
        $(this).closest('.filter').toggleClass('active');
        $('body').removeClass('frozen');
    }
})

$('#filter-companies-button').click(function () {
    $('.filter__dropdown .separator:not(.separator-static)').remove();
    checkedOnTop();
})

$('.select-section .regions .checkbox-container input').on('input', function () {
    checkRegionInFilterPopup(this);
});

$('.select-section .municipalities-wrapper .checkbox-container input').on('input', function () {
    checkMunicipalityInFilterPopup(this);
});

$('.filter-popup .button.save').on('click', function () {
    $(this).parents('.filter-popup').find('.popup__close').click();
});

$('.filter-popup .button.cancel').on('click', function () {
    const inputs = $(this).parents('.filter-popup').find('.select-section .regions input');
    inputs.each(function () {
        $(this).prop('checked', false);
        checkRegionInFilterPopup(this);
    });

    const municipalityInputs = $(this).parents('.filter-popup').find('.select-section .municipalities-wrapper input');
    municipalityInputs.each(function () {
        $(this).prop('checked', false);
        checkMunicipalityInFilterPopup(this);
    })
});

$('.filter-popup .checkbox-container.mobile input').on('click', function (e) {
    e.preventDefault();
});

$('.filter-popup .search-field').on('input', function () {
    const text = $(this).val();
    const items = $(this).siblings('.dropdown-right').find('.municipality');
    items.each(function () {
        const name = $(this).find('.first-name').text();
        const secondName = $(this).find('.second-name').text();
        if (name.startsWith(text) || secondName.startsWith(text)) {
            $(this).removeClass('hide');
        } else {
            $(this).addClass('hide');
        }
    });
});

$('.filter-popup .header-section .special .municipality').on('click', function () {
    const selected = $(this).find('input').prop('checked');
    const regionId = $(this).data('region-id');
    const municipalityId = $(this).data('municipality-id');
    const regionInput = $(this).parents('.filter-popup, .select-section-wrapper').find('.select-section .regions input[data-id="' + regionId + '"]');
    const municipalityInput = $(this).parents('.filter-popup, .select-section-wrapper').find('.select-section .municipalities-wrapper input[data-id="' + municipalityId + '"]');
    regionInput.prop('checked', selected);
    checkRegionInFilterPopup(regionInput.get(0), !!!municipalityInput.length);

    if (municipalityInput.length) {
        municipalityInput.prop('checked', selected);
        checkMunicipalityInFilterPopup(municipalityInput.get(0));
    }
});

const expandCheckboxContainer = function (ref) {
    $(ref).parents('.municipality-section').addClass('expanded');
    $(ref).unbind('click');
    setTimeout(function () {
        $(ref).on('click', function () {
            closeCheckboxContainer(ref);
        });
    }, 100)
}

const closeCheckboxContainer = function (ref) {
    $(ref).parents('.municipality-section').removeClass('expanded');
    $(ref).unbind('click');
    setTimeout(function () {
        $(ref).on('click', function () {
            expandCheckboxContainer(ref);
        });
    }, 100);
}

$('.filter-popup .checkbox-container.mobile').on('click', function () {
    expandCheckboxContainer(this);
});

//org registration act area
$('.select-section--light .checkbox-container.mobile').on('click', function () {
    expandCheckboxContainer(this);
});

$('.select-section--light .checkbox-container.mobile input').on('click', function (e) {
    e.preventDefault();
});
//org registration act area ends

//admin
$('.select-section--admin .checkbox-container.mobile').on('click', function () {
    expandCheckboxContainer(this);
});

$('.select-section--admin .checkbox-container.mobile input').on('click', function (e) {
    e.preventDefault();
});
//admin ends

function checkRegionInFilterPopup(ref, markAll = true) {
    if ($(ref).parent().hasClass('mobile')) {
        return;
    }
    const regionId = $(ref).data('id');
    if ($(ref).prop('checked')) {
        $(ref).parents('.filter-popup, .select-section-wrapper').find('.select-section .municipalities-wrapper .municipality-section[data-region-id="' + regionId + '"]').addClass('active');
        $(ref).parents('.filter-popup, .select-section-wrapper').find('.selected-value[data-region-id="' + regionId + '"]').addClass('active');
        if (markAll) {
            $(ref).parents('.filter-popup, .select-section-wrapper').find('.select-section .municipalities-wrapper .municipality-section[data-region-id="' + regionId + '"] input').prop('checked', true);
            $(ref).parents('.filter-popup, .select-section-wrapper').find('.selected-value[data-region-id="' + regionId + '"] .selected-municipality').addClass('active');
        }
        if ($(ref).closest('.filter__dropdown').find(".checkbox-container:not(.uncheck-all) input:not(:checked)").length == 0) {
            $(ref).closest('.filter__dropdown').find('.uncheck-all').find('input').prop('checked', true);
            $(ref).closest('.filter__dropdown').find(".checkbox-container.uncheck-all").removeClass('half-checked');
        } else {
            $(ref).closest('.filter__dropdown').find(".checkbox-container.uncheck-all").addClass('half-checked');
        }
    } else {
        $(ref).parents('.filter-popup, .select-section-wrapper').find('.select-section .municipalities-wrapper .municipality-section[data-region-id="' + regionId + '"]').removeClass('active');
        $(ref).parents('.filter-popup, .select-section-wrapper').find('.selected-value[data-region-id="' + regionId + '"]').removeClass('active');

        $(ref).parent().removeClass('checked');
        $(ref).closest('.filter__dropdown').find('.uncheck-all').find('input').prop('checked', false);
        if ($(ref).closest('.filter__dropdown').find(".checkbox-container:not(.uncheck-all) input:checked").length == 0) {
            $(ref).parents('.filter__dropdown').find(".checkbox-container.uncheck-all").removeClass('half-checked');
        } else {
            $(ref).closest('.filter__dropdown').find(".checkbox-container.uncheck-all").addClass('half-checked');
        }

        const municipalities = $(ref).parents('.filter-popup, .select-section-wrapper').find('.select-section .municipalities-wrapper .municipality-section[data-region-id="' + regionId + '"] input');
        municipalities.prop('checked', false);
        municipalities.each(function () {
            checkMunicipalityInFilterPopup(this);
        })
    }
}

function checkMunicipalityInFilterPopup(ref) {
    if ($(ref).parent().hasClass('mobile')) {
        return;
    }
    const municipalityId = $(ref).data('id');
    const regionId = $(ref).parents('.municipality-section').data('region-id');
    if ($(ref).prop('checked')) {
        $(ref).parents('.filter-popup').find('.selected-value[data-region-id="' + regionId + '"]').addClass('active');
        $(ref).parents('.filter-popup').find('.selected-municipality[data-municipality-id="' + municipalityId + '"]').addClass('active');
        if ($(ref).closest('.filter__dropdown').find(".checkbox-container:not(.uncheck-all) input:not(:checked)").length == 0) {
            $(ref).closest('.filter__dropdown').find('.uncheck-all').find('input').prop('checked', true);
            $(ref).closest('.filter__dropdown').find(".checkbox-container.uncheck-all").removeClass('half-checked');
        } else {
            $(ref).closest('.filter__dropdown').find(".checkbox-container.uncheck-all").addClass('half-checked');
        }
    } else {
        $(ref).parents('.filter-popup').find('.selected-municipality[data-municipality-id="' + municipalityId + '"]').removeClass('active');

        const numSelected = $(ref).parents('.filter-popup').find('.selected-value[data-region-id="' + regionId + '"] .selected-municipality.active').length;
        if (numSelected == 0) {
            $(ref).parents('.filter-popup').find('.selected-value[data-region-id="' + regionId + '"]').removeClass('active');
        }

        $(ref).parent().removeClass('checked');
        $(ref).closest('.filter__dropdown').find('.uncheck-all').find('input').prop('checked', false);
        if ($(ref).closest('.filter__dropdown').find(".checkbox-container:not(.uncheck-all) input:checked").length == 0) {
            $(ref).parents('.filter__dropdown').find(".checkbox-container.uncheck-all").removeClass('half-checked');
        } else {
            $(ref).closest('.filter__dropdown').find(".checkbox-container.uncheck-all").addClass('half-checked');
        }
    }
}

//ძველი კოდი
// $(function () {
//     $('.filter__dropdown input').click(function () {
//         $defaultTitle = $(this).closest('.filter').find('.filter__button').attr("default");
//         if ($(this).is(':checked')) {
//             if ($(this).parent().hasClass('uncheck-all')) {
//                 $(this).parent().nextAll('.checkbox-container').find('input').prop('checked', false);
//                 $(this).parent().nextAll('.checkbox-container').removeClass('checked');
//                 $(this).closest('.filter').find('.separator:not(.separator-static)').remove();
//             } else {
//                 $('.uncheck-all').find('input').prop('checked', false);
//             }
//         } else {
//             $(this).parent().removeClass('checked');
//         }
//         let checkedObj = $(this).closest('.filter__dropdown').find("input:checked").parent().find('.title');
//         let checked = checkedObj.toArray();
//         let checkedCount = checked.length;
//         let title = [];
//         checked.forEach(element => {
//             title.push(element.innerText);
//         });
//         if (checkedCount != 0) {
//             $(this).closest('.filter').find('.filter__button').text(title.join(', '));
//         } else {
//             $(this).closest('.filter').find('.filter__button').text($defaultTitle);
//             $('.filter__dropdown .separator:not(.separator-static)').remove();
//         }
//     })
// })

// function checkedOnTop() {
//     $('.checkbox-container').removeClass('separator');
//     $('.filters-container .filter:not(.filter--subscribed)').each(function () {
//         let checkboxes = [];
//         checkboxes = $(this).find('.filter__dropdown .checkbox-container:not(.uncheck-all) input:checked');
//         checkboxes.each(function () {
//             $(this).closest('.checkbox-container').addClass('checked');
//         })
//         lastIndex = checkboxes.length - 1;
//         if (checkboxes.length > 0) {
//             let separator = document.createElement("b");
//             separator.classList.add('separator');
//             checkboxes[lastIndex].parentElement.after(separator);
//         }
//         checkboxes = [];
//         $(this).find('.filter__dropdown').scrollTop(0);
//     })
// }

// $('.filter__button').click(function () {
//     $('.filter').not($(this).closest('.filter')).removeClass('active');
//     $(this).closest('.filter').toggleClass('active');
// })

// $('#filter-companies-button').click(function () {
//     $('.filter__dropdown .separator:not(.separator-static)').remove();
//     checkedOnTop();
// })
//ძველი კოდი
//filters ends

//banner
$('.close-banner').click(function () {
    $(this).closest('.banner').slideUp(0);
    $bannerheight = 0;
    $bannersheight = $('.banners').outerHeight();
    $yellowBannerHeight = $('.banner--yellow').outerHeight(true);
    $('.categorize').css('top', $headerHeight + $bannersheight + $yellowBannerHeight);

    // if($viewportWidth <= 991){
    //     $('.categorize').css('top', $headerHeight);
    // }
})
//banner ends

$(document).ready(function () {
    $('.categorize').addClass('transition-top');
})


//footer positioning
// $footerCords = $('.footer').offset();
// $footerTop = $footerCords.top;
// $viewportHeight = $(window).height();
// if ($footerTop < $viewportHeight) {
//     $('.footer').addClass('sticky-bottom');
// }
$viewportHeight = $(window).height();
$footerHeight = $(".footer").height();

function adjustFooter() {
    $(".footer").addClass("sticky-bottom");
    $viewportHeight = $(window).height();
    $bodyHeight = $("body").outerHeight();
    if ($bodyHeight + $footerHeight < $viewportHeight) {
        $(".footer").addClass("sticky-bottom");
    } else {
        $(".footer").removeClass("sticky-bottom");
    }
}
adjustFooter();
//footer positioning ends


//mobile navigation
$('.burger-nav').click(function () {
    $('.mobile-nav').addClass('active');
    $('body').addClass('frozen');
})

$('.close-mobile-menu').click(function () {
    $('.mobile-menu').removeClass('active');
    $('body').removeClass('frozen');
})
//mobile navigation ends

//mobile filters
$('.burger-categories').click(function () {
    $('.mobile-filters').toggleClass('active');
    $('body').toggleClass('frozen');
})

$('.mobile-filters .button--red').click(function () {
    $('.mobile-filters').removeClass('active');
    $('body').removeClass('frozen');
})
//mobile filters ends


//MAP
if ($('#map-container').length != 0) {
    mapboxgl.accessToken = 'pk.eyJ1Ijoia2thcmUxMyIsImEiOiJjazlmOWk4a2owOWNjM2txbXJkOW5rbGN0In0.AmDmOAjgp5f7X5FrWSMudA';
    var map = new mapboxgl.Map({
        container: document.getElementById('map-container'),
        style: 'mapbox://styles/kkare13/ck9icz6na001o1ippxy87ahwe'
    });
    const setLat = $('#map-container').attr('data-lat');
    const setLng = $('#map-container').attr('data-long');
    let center = [44.783333, 41.716667];
    if (setLat && setLng) {
        center = [setLng, setLat];
    }
    map.setZoom(15);
    map.setCenter(center);
    var el = document.createElement('div');
    el.className = 'marker';
    var marker = new mapboxgl.Marker(el)
        .setLngLat(center)
        .addTo(map);
}

//MAP ENDS



//COMMON POPUP--------------------------------------------------------------


// if ($('body').attr('is-logged-in') != 1) {
//     $requiresLogin = $('.subscribe, .add-fav, .add-going');
//     $requiresLogin.each(function () {
//         $(this).click(function (e) {
//             $('.popup-login').addClass('popup-active');
//             $('.popup-login .title-default').css('display', 'none');
//             $('.popup-login .popup-title').css('display', 'none');
//             $('.popup-login .title-subscription').css('display', 'block');
//         })
//     })
// }

if ($('body').attr('is-logged-in') != 1) {
    $requiresLogin = $('.subscribe, .add-fav, .add-going, .comment__vote svg');
    $requiresLogin.each(function () {
        if (!$(this).hasClass('disabled')) {
            $(this).click(function (e) {
                if (typeof $(this).attr('data-popup-message') != 'undefined') {
                    $popupText = $(this).attr('data-popup-message');
                } else {
                    $popupText = 'გაიარე ავტორიზაცია';
                }
                $('.popup-login .title-default').css('display', 'none');
                $('.popup-login .alternative-title').css('display', 'block');
                $('.popup-login .alternative-title').text($popupText);
                $('.popup-login').addClass('popup-active');
                $('body').addClass('frozen');
            })
        }
    })
}


$('.login-popup-trigger').click(function (e) {
    e.preventDefault();
    $('.popup-login').addClass('popup-active');
    $('body').addClass('frozen');

    $('.popup-login .title-default').css('display', 'block');
    $('.popup-login .alternative-title').css('display', 'none');
})

//COMMON POPUP ENDS-------------------------------------------------


//custom select-----------------------------------------------------
if ($('.custom-select').length != 0) {
    var x, i, j, selElmnt, a, b, c;
    /* Look for any elements with the class "custom-select": */
    x = document.getElementsByClassName("custom-select");
    for (i = 0; i < x.length; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        /* For each element, create a new DIV that will act as the selected item: */
        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);
        /* For each element, create a new DIV that will contain the option list: */
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 1; j < selElmnt.length; j++) {
            /* For each option in the original select element,
            create a new DIV that will act as an option item: */
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function (e) {
                /* When an item is clicked, update the original select box,
                and the selected item: */
                var y, i, k, s, h;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                h = this.parentNode.previousSibling;
                for (i = 0; i < s.length; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        for (k = 0; k < y.length; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function (e) {
            /* When the select box is clicked, close any other select boxes,
            and open/close the current select box: */
            if (!($('.custom-select').parent().hasClass('disabled'))) {
                e.stopPropagation();
                closeAllSelect(this);
                this.nextSibling.classList.toggle("select-hide");
                this.classList.toggle("select-arrow-active");
            }
        });
    }

    function closeAllSelect(elmnt) {
        /* A function that will close all select boxes in the document,
        except the current select box: */
        var x, y, i, arrNo = [];
        x = document.getElementsByClassName("select-items");
        y = document.getElementsByClassName("select-selected");
        for (i = 0; i < y.length; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i)
            } else {
                y[i].classList.remove("select-arrow-active");
            }
        }
        for (i = 0; i < x.length; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add("select-hide");
            }
        }
    }

    /* If the user clicks anywhere outside the select box,
    then close all select boxes: */
    document.addEventListener("click", closeAllSelect);
}
//custom select ends-----------------------------------------------------

//QUERY------------------------------------------------------------------

//rating single
$(function () {
    $('.rating-single input').val(0);
    $currentRating = 0;
    $('.rating-single').hover(function () {
        $('.star').hover(function () {
            $(this).parent().find('.star').removeClass('hover');
            $(this).prevAll('.star').addClass('hover');
            $(this).addClass('hover');
        }, function () {
            $(this).parent().find('.star').removeClass('hover');
        })
    }, function () {
        $(this).find('.star').removeClass('hover');
    })

    $('.star').click(function () {
        $(this).parent().find('.star').removeClass('active');
        $currentRating = $(this).index();
        $(this).prevAll('.star').addClass('active');
        $(this).addClass('active');
        $(this).parent().find('input').val($currentRating);
        // if ($(this).closest('.wizard__tab').next().length == 0) {
        //     $(this).closest('.query-tab').find('.button').removeClass('wizard-next-step');
        //     $(this).closest('.query-tab').find('.button').click(function () {
        //         queryNextStep();
        //     });
        // }
        if ($(this).closest('.wizard__tab').next().length == 0) {
            $(this).closest('.query-tab').find('.wizard-next-step').removeClass('active');
            $(this).closest('.query-tab').find('.query-next-step').addClass('active');
        }
    })
})

//rating single ends

//wizard step couter
$wizardSteps = $('.ratings .wizard__step');
$wizardSteps.each(function () {
    $stepNumber = $(this).index() + 1;
    if ($(this).index() < 8) {
        $stepNumber = '0' + ($(this).index() + 1).toString() + '. ';
    } else {
        $stepNumber = ($(this).index() + 1).toString() + '. ';
    }
    $(this).find('.step-number').text($stepNumber);
})

//wizard step couter ends

//feedback anonymity
$('.feedback .switch__item').click(function () {
    if ($(this).hasClass('anonymous')) {
        $(this).closest('.query-tab').find('input').prop('checked', false);
    } else {
        $(this).closest('.query-tab').find('input').prop('checked', true);
    }
})

//feedback anonymity ends


//absent case more response
$('.no .query-checkboxes input:radio').click(function () {
    $(this).closest('.query-tab').find('.button').unbind('click');
    $(this).closest('.query-tab').find('.button').removeClass('query-next-step');

    if ($(this).hasClass('other')) {
        $(this).closest('.query-tab').find('.button').unbind('click');
        $(this).closest('.checkboxes-container').next('.feedback-input').addClass('active');
        $(this).closest('.query-tab').find('.button').click(function () {
            $(this).closest('.query-tab').find('.feedback-input').addClass('rating-missed');
            setTimeout(() => {
                $(this).closest('.query-tab').find('.feedback-input').removeClass('rating-missed');
            }, 1000);
        })
        $(this).closest('.checkboxes-container').next('.feedback-input').on('change', function () {
            $(this).closest('.query-tab').find('.button').unbind('click');
            if ($(this).val() != '') {
                $(this).closest('.query-tab').find('.button').addClass('query-next-step');
                $(this).closest('.query-tab').find('.button').click(function () {
                    queryNextStep();
                })
            } else {
                $(this).closest('.query-tab').find('.button').removeClass('query-next-step');
                $(this).closest('.query-tab').find('.button').click(function () {
                    $(this).closest('.query-tab').find('.feedback-input').addClass('rating-missed');
                    setTimeout(() => {
                        $(this).closest('.query-tab').find('.feedback-input').removeClass('rating-missed');
                    }, 1000);
                })
            }
        })
    } else {
        $(this).closest('.checkboxes-container').next('.feedback-input').removeClass('active');
        $(this).closest('.query-tab').find('.button').addClass('query-next-step');
        $(this).closest('.query-tab').find('.button').click(function () {
            queryNextStep();
        })
    }
    adjustFooter();
})

$('.query-checkboxes .button').click(function () {
    if (!($(this).hasClass('query-next-step'))) {
        $(this).closest('.query-tab').find('.checkboxes-container').addClass('rating-missed');
        setTimeout(() => {
            $(this).closest('.query-tab').find('.checkboxes-container').removeClass('rating-missed');
        }, 1000);
    }
})

//absent case more response ends


//query navigation
let selectedQuery = [];
let queryTabIndex = 0;
let queryPreviousTabIndex = 0;
$('.check-attendance').click(function () {
    selectedQuery = [];
    queryTabIndex = 0;
    $('.query-tab').removeClass('active');
    if ($('.attended').is(":checked")) {
        selectedQuery = $('.yes').find('.query-tab');
    } else {
        selectedQuery = $('.no').find('.query-tab');
    }
    selectedQuery[queryTabIndex].classList.add('active');
    selectedQuery[queryTabIndex].classList.add('fadeInRight');
    $('.query-nav').addClass('active');

    if ($viewportWidth <= 991) {
        $('.query-tab .wizard__indicator .bar').width($('.wizard__indicator').width() / $('.query-tab .wizard__step').length);
    } else {
        $('.query-tab .wizard__indicator .bar').width($('.query-tab .wizard__step--blue.active').width());
    }
    adjustFooter();
})

function changeQueryTab() {
    $('.query-tab').removeClass('active');
    if (queryTabIndex < selectedQuery.length) {
        selectedQuery[queryTabIndex].classList.add('active');
        if (queryPreviousTabIndex < queryTabIndex) {
            selectedQuery[queryTabIndex].classList.remove('fadeInLeft');
            selectedQuery[queryTabIndex].classList.add('fadeInRight');
        } else {
            selectedQuery[queryTabIndex].classList.remove('fadeInRight');
            selectedQuery[queryTabIndex].classList.add('fadeInLeft');
        }
    }
    adjustFooter();
}

$('.query-next-step').click(function () {
    queryNextStep();
})

function queryNextStep() {
    queryPreviousTabIndex = queryTabIndex;
    queryTabIndex++;
    changeQueryTab();
}

function queryPreviousStep() {
    queryPreviousTabIndex = queryTabIndex;
    queryTabIndex--;
    changeQueryTab();
}

$('.query-nav .back').click(function () {
    if (queryTabIndex > 0) {
        queryPreviousStep();
    } else {
        $('.query-tab').removeClass('active');
        $('.yes-no').addClass('active');
        $('.yes-no').addClass('fadeInLeft');
        $('.query-nav').removeClass('active');
    }
    adjustFooter();
})

//query navigation ends

//query wizard

$('.wizard__step--blue').click(function () {

    $activeTabIndex = $('.wizard__tab.active').index();
    $clickedIndex = $(this).index();

    if ($clickedIndex == $activeTabIndex) {
        return
    }

    $inputs = [];

    let selector = '';

    $isValid = true;

    for (var i = 1; i <= $clickedIndex; i++) {
        if ($(this).index() >= $activeTabIndex) {
            selector += ".wizard__tab:nth-child(" + i + "),";
        }
    }

    $inputs = $(selector.substring(0, selector.length - 1)).find('.form__input');

    $inputs.each(function () {
        $value = $(this).val();
        if (($(this).parent().hasClass('rating-single') && $value < 1 || $(this).parent().hasClass('rating-single') && $value > 5)) {
            $isValid = false;
            if ($(this).parent().hasClass('rating-single')) {
                $(this).parent().addClass('rating-missed');
                setTimeout(() => {
                    $(this).parent().removeClass('rating-missed');
                }, 1000);
            }
        }
    })

    if (!$isValid) {
        return
    }

    $index = $(this).index();
    $('.wizard__step').removeClass('active');
    $(this).addClass('active');
    $parentOffset = $('.wizard__steps').offset();
    $offset = $(this).offset();
    $stepWidth = $(this).width();
    $indicator = $('.wizard__indicator .bar');

    //indicator bar width
    if ($viewportWidth <= 991) {
        $wholeWidth = $('.wizard__indicator').width();
        $tabsCount = $('.wizard__tab').length;
        $indicator.width($wholeWidth / $tabsCount + 'px');
        $indicator.css('left', $indicator.width() * $('.wizard__step.active').index() + 'px');
    } else {
        $indicator.width($stepWidth + 'px');
        $indicator.css('left', $offset.left - $parentOffset.left + 'px');
    }
    //indicator bar width ends

    $('.wizard__tab').removeClass('active');
    if ($previousActive < $index) {
        $('.wizard__tab').removeClass('fadeInLeft fadeInRight');
        $(".wizard__tab:nth-child(" + ($index + 1) + ")").addClass('active fadeInRight');
    } else {
        $('.wizard__tab').removeClass('fadeInLeft fadeInRight');
        $(".wizard__tab:nth-child(" + ($index + 1) + ")").addClass('active fadeInLeft');
    }


    if ($(this).next('.wizard__step--blue').length == 0) {
        $value = $('.wizard__tab.active').find('input[type=number]').val();
        if (!($value < 1 || $value > 5)) {
            $(this).closest('.query-tab').find('.wizard-next-step').removeClass('active');
            $(this).closest('.query-tab').find('.query-next-step').addClass('active');
        }
    } else {
        $(this).closest('.query-tab').find('.wizard-next-step').addClass('active');
        $(this).closest('.query-tab').find('.query-next-step').removeClass('active');
    }

    if ($(this).index() == 0) {
        $(this).closest('.query-tab').find('.wizard-stars-previous').addClass('disabled');
    } else {
        $(this).closest('.query-tab').find('.wizard-stars-previous').removeClass('disabled');
    }

    $previousActive = $index;
})

$('.wizard-next-step').click(function () {
    $tabIndex = $('.wizard__tab.active').index();
    $(".wizard__step:nth-child(" + ($tabIndex + 2) + ")").click();
    $tabIndex = $('.wizard__tab.active').index();

    if ($tabIndex > 0) {
        $('.wizard-stars-previous').removeClass('disabled');
    }
})

$('.wizard-stars-previous').click(function () {
    $tabIndex = $('.wizard__tab.active').index();
    if ($tabIndex > 0) {
        $(".wizard__step:nth-child(" + ($tabIndex) + ")").click();
    }
    $tabIndex--;
    if ($tabIndex == 0) {
        $(this).addClass('disabled');
    }
})

//query wizard ends


//QUERY ENDS-------------------------------------------------------------


//makes image downloading harder but not impossible----------------------

$(document).ready(function () {
    $("img").on("contextmenu", function () {
        return false;
    });
    $("img").prop('draggable', false);
});

//makes image downloading harder but not impossible emds-----------------


//event inner tabs-------------------------------------------------------------
$(function () {
    if ($('.opportunity-feedback .comments').length == 0) {
        $('.event-tab--rating').index() + 1;
        $('.switch--event .switch__item:nth-child(' + ($('.event-tab--rating').index() + 1) + ')').addClass('disabled');
    }

    $('.switch--event .switch__item').click(function () {
        let index = $(this).index() + 1;
        if ($(this).hasClass('disabled')) {
            return;
        } else {
            $('.event-tab').removeClass('active')
            $(".event-tab:nth-child(" + index + ")").addClass('active');
        }
    })
})
//event inner tabs ends--------------------------------------------------------

//popup stars

$(document).ready(function () {
    $criterias = $('.criteria__detailed');
    $counter = 1;
    $($criterias).each(function () {
        for (var i = 0; i < 5; i++) {
            $(this).find('.criteria__stars').append(
                `<svg class="star" viewBox="0 0 386 369" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="grad` + $counter + '-' + (i + 1) + `" x1="0%">
                            <stop style="stop-color:#ffc850;" />
                            <stop style="stop-color:transparent;" />
                        </linearGradient>
                    </defs>
                    <path fill='url(#grad` + $counter + '-' + (i + 1) + `)' d="M207.765 9.18454L254.65 104.256C255.831 106.651 257.577 108.724 259.736 110.294C261.896 111.864 264.405 112.885 267.047 113.269L371.885 128.515C385.39 130.478 390.782 147.087 381.01 156.62L305.148 230.622C303.236 232.487 301.806 234.789 300.982 237.33C300.157 239.871 299.962 242.574 300.413 245.207L318.322 349.701C320.629 363.161 306.511 373.426 294.432 367.071L200.662 317.736C198.299 316.492 195.67 315.843 193 315.843C190.331 315.843 187.702 316.492 185.339 317.736L91.5688 367.071C79.4895 373.426 65.3724 363.161 67.6789 349.701L85.5877 245.207C86.0388 242.574 85.8435 239.871 85.0187 237.33C84.1938 234.789 82.7642 232.487 80.8528 230.622L4.99097 156.62C-4.78252 147.088 0.610585 130.479 14.1148 128.515L118.953 113.27C121.595 112.886 124.103 111.865 126.263 110.294C128.422 108.724 130.168 106.652 131.35 104.257L178.235 9.18532C184.275 -3.06165 201.725 -3.06164 207.765 9.18454Z" />
                </svg>`
            );
        }
        $counter++;

        $criteriaScore = $(this).find('.criteria__score').text();
        $scoreNum = parseFloat($criteriaScore);
        $intigerPart = Math.floor($scoreNum);
        $decimalPart = ($scoreNum % 1 * 100).toPrecision(3);


        let stars = $(this).find('.star linearGradient').toArray();
        for (var i = 0; i < $intigerPart; i++) {
            stars[i].setAttribute('x1', 99.9 + '%');
        }
        if ($intigerPart < 5) {
            stars[$intigerPart].setAttribute('x1', $decimalPart + '%');
        }
        stars = [];

        $allVotes = parseInt($(this).find('.criteria__votes').text());
        $(this).find('.chart-bar-single').each(function () {
            $voteAmount = parseInt($(this).find('.votes').text());
            if ($allVotes == 0) {
                $voteFraction = 0;
            } else {
                $voteFraction = $voteAmount / $allVotes * 100;
            }
            $(this).find('.chart-bar-progress').width($voteFraction + '%');
        })
    })
})



$(function () {
    if (parseFloat($('.event-rating .score').text()) == 0) {
        $('.event-rating .score').addClass('disabled');
    }

    $('.event-rating .score').click(function () {
        if ($(this).hasClass('disabled')) {
            return;
        }
        $('.popup-rating').addClass('popup-active');
        $('.popup-rating').find('.chart-bar-progress').each(function () {
            $width = $(this).width();
            $(this).width(0);
            $(this).animate({
                width: $width + "px"
            }, 1000);
        })
        $('body').addClass('frozen');
    })
})

//popup stars ends

//comments
$(function () {
    $(document).on('click', '.opportunity-comments .comment__button--delete', function () {
        $('.popup-delete-comment').addClass('popup-active');
        $('.popup-delete-comment').find('.delete-comment').attr('data-comment-id', $(this).attr('data-comment-id'));
        $('body').addClass('frozen');
    })

    $('.comment-form-container textarea').on('input', function () {
        $value = $(this).val();
        if ($value != '') {
            $('.comment-form-container .button--red').removeClass('disabled');
            $('.comment-form-container .button--red').attr('disabled', false);
        } else {
            $('.comment-form-container .button--red').addClass('disabled');
            $('.comment-form-container .button--red').attr('disabled', true);
        }
    })

    $previousComment = '';

    $(document).on('click', '.comment__button--edit', function () {

        $('.comment__button--cancel').not('.hidden').click();

        $textarea = $(this).closest('.comment').find('.comment__content');

        $previousComment = $textarea.text();


        $(this).closest('.comment').find('.comment__text').toggleClass('active');
        $textarea.prop('readonly', function (index, attr) {
            return attr == false ? true : false;
        });
        if (!$textarea.prop('readonly')) {
            $textarea.focus();
        }
        $(this).closest('.comment').find('.comment__button--submit-edit').removeClass('hidden');
        $(this).closest('.comment').find('.comment__button--delete').addClass('hidden');
        $(this).closest('.comment').find('.comment__button--cancel').removeClass('hidden');
        $(this).addClass('hidden');
        // $(this).closest('.comment').find('.comment__button--submit-edit').toggleClass('active');
        // $(this).toggleClass('active');
    })

    $(document).on('click', '.comment__button--cancel', function () {

        $textarea = $(this).closest('.comment').find('.comment__content');

        $textarea.val($previousComment);
        $previousComment = '';

        adjustCommentHeight($textarea.get(0));

        $(this).closest('.comment').find('.comment__text').removeClass('active');
        $textarea.prop('readonly', function (index, attr) {
            return attr == false ? true : false;
        });
        if (!$textarea.prop('readonly')) {
            $textarea.focus();
        }
        $(this).closest('.comment').find('.comment__button--submit-edit').addClass('hidden');
        $(this).closest('.comment').find('.comment__button--delete').removeClass('hidden');
        $(this).closest('.comment').find('.comment__button--edit').removeClass('hidden');
        $(this).closest('.comment').find('.comment__button--cancel').addClass('hidden');
    })

})

$(document).keydown(function (e) {
    if (e.keyCode == 27) {
        $('.comment__button--cancel').not('.hidden').click();
    }

    if ($(document).width() > 991) {
        if (e.keyCode == 13) {
            if ($('.comment__text').hasClass('active') || !$('.comment-form-container .button--red').hasClass('disabled')) {
                e.preventDefault();
                if ($('.comment__button--submit-edit').not('.hidden').length != 0) {
                    $('.comment__button--submit-edit').not('.hidden').click();
                    $('.comment__button--submit-edit').addClass('hidden');
                    // console.log('edit');
                    return;
                }
                $('#new_comment_button').not('.disabled').click();
                $('#new_comment_button').not('.disabled').addClass('disabled');
                // console.log('new');
            }
        }
    }
});


$(document).on('click', '.comment__button--submit-edit', function () {
    comment = $(this)
    comment_id = comment.closest('.comment').data('comment-id');
    text = comment.closest('.comment').find('.comment__content').val();

    $.ajax({
        type: 'POST',
        url: $('body').data('url') + '/opportunity/comment/update/' + comment_id,
        data: {
            text: text
        },
        success: function () {
            // $('.comment__button--edit').removeClass('active');

            // $('.comment__button--edit').removeClass('hidden');
            // $('.comment__button--submit-edit').addClass('hidden');
            comment.removeClass('active');

            comment.closest('.comment').find('.comment__text').toggleClass('active');
            comment.closest('.comment').find('.comment__content').prop('readonly', true);

            comment.closest('.comment').find('.comment__button--submit-edit').addClass('hidden');
            comment.closest('.comment').find('.comment__button--delete').removeClass('hidden');
            comment.closest('.comment').find('.comment__button--edit').removeClass('hidden');
            comment.closest('.comment').find('.comment__button--cancel').addClass('hidden');
        },
        error: function () {
            console.log('error');
        }
    });
});

//comment editing textarea height Adjustment
$(function () {
    var measurer = $('<span>', {
        style: "display:inline-block; word-break:break-word; visibility:visible; white-space:pre-wrap; position:fixed;"
    })
        .appendTo('body');

    function initMeasurerFor(textarea) {
        measurer.text(textarea.text())
            .css('font', textarea.css('font'))
            .css('line-height', textarea.css('line-hight'))
            .css("min-height", textarea.css("min-height"))
            .css("letter-spacing", textarea.css("letter-spacing"))
            .css("width", textarea.css("width"))
            .css("box-sizing", textarea.css("box-sizing"))
    }

    function updateTextAreaSize(textarea) {
        textarea.height(measurer.height());
    }
    $('.comment__content').on({
        input: function () {
            var text = $(this).val();
            if ($(this).attr("preventEnter") == undefined) {
                text = text.replace(/[\n]/g, "<br>&#8203;");
            }
            measurer.html(text);
            updateTextAreaSize($(this));
        },
        focus: function () {
            initMeasurerFor($(this));
        },
        keypress: function (e) {
            if (e.which == 13 && $(this).attr("preventEnter") != undefined) {
                e.preventDefault();
            }
        }
    });
    adjustAllCommentsHeights();
})

function adjustAllCommentsHeights() {
    $comments = $('.comment__content').toArray();
    for (let comment of $comments) {
        // console.log(comment)
        adjustCommentHeight(comment);
    }
}

function adjustCommentHeight(comment) {
    comment.style.height = 'auto';
    comment.style.height = comment.scrollHeight + 'px';
}

//comment editing textarea height Adjustment ends


//comments ends

// feedback likes

$(document).on('click', '.opportunity-feedback .comment__vote', function () {
    if ($('body').attr('is-logged-in') != 1) {
        return;
    }
    let isLike = 1;
    if ($(this).hasClass('active')) {
        isLike = -1;
    } else if ($(this).hasClass('comment__vote--down')) {
        isLike = 0;
    }

    let ref = this;

    $.ajax({
        type: 'POST',
        url: $('body').data('url') + '/ajax-like-query-message',
        data: {
            query_message_id: $(ref).parents('.comment').data('message-id'),
            is_like: isLike
        },
        success: function (data) {
            let oldActive = $(ref).parent().find('.active').first().find('.number');
            console.log(oldActive);
            if (oldActive.length) {
                let activeCountNumber = +(oldActive.html());
                console.log(activeCountNumber);
                oldActive.html(activeCountNumber - 1);
            }

            $(ref).toggleClass('active');
            $(ref).siblings().removeClass('active');

            if ($(ref).hasClass('active')) {
                let newActive = $(ref).find('.number');
                let activeCountNumber = +(newActive.html());
                newActive.html(activeCountNumber + 1);
            }
        },
        error: function () {
            console.log('error');
        }
    });
});

$('.opportunity-feedback .load-feedback').on('click', function (e) {
    e.preventDefault();
    let page = parseInt($('.comments[data-feedback-page]').data('feedback-page'));
    let opportunityId = $(this).data('opportunity-id');
    let numMessagesPerPage = parseInt($(this).data('num-messages-per-page'));

    const ref = this;

    $.ajax({
        type: 'GET',
        url: $('body').data('url') + '/ajax-load-more-messages',
        data: {
            numberPerPage: numMessagesPerPage,
            page: page + 1,
            opportunityID: opportunityId
        },
        success: function (data) {
            $('.comments[data-feedback-page]').append(data.feedback);
            $('.comments[data-feedback-page]').attr('data-feedback-page', page + 1);

            let count = parseInt($('.comments[data-feedback-page]').data('messages-count'));
            if (parseInt(data.feedbackCount) + page * numMessagesPerPage == count) {
                $(ref).hide();
            }
        },
        error: function () {
            console.log('error');
        }
    });
});

jQuery.expr[':'].regex = function (elem, index, match) {
    var matchParams = match[3].split(','),
        validLabels = /^(data|css):/,
        attr = {
            method: matchParams[0].match(validLabels) ?
                matchParams[0].split(':')[0] : 'attr',
            property: matchParams.shift().replace(validLabels, '')
        },
        regexFlags = 'ig',
        regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g, ''), regexFlags);
    return regex.test(jQuery(elem)[attr.method](attr.property));
}

$(document).on('click', 'div:regex(id, comment-[10]-)', function (e) {

    if ($('body').attr('is-logged-in') != 1) {
        return;
    }

    var cur_elem_vote = $(this);

    let [comment, vote, id] = cur_elem_vote.attr('id').split('-');

    var opposite_elem_vote = $(document.getElementById('comment-' + (1 - vote) + '-' + id));

    var cur_elem_vote_count = $(document.getElementById('vote-count-' + vote + '-' + id));
    var opposite_elem_vote_count = $(document.getElementById('vote-count-' + (1 - vote) + '-' + id));

    var cur_vote_count_int = parseInt(cur_elem_vote_count.text())
    var opposite_vote_count_int = parseInt(opposite_elem_vote_count.text())

    var action = '/opportunity/comment/like';

    $.ajax({
        type: 'POST',
        url: $('body').data('url') + action,
        data: {
            opportunity_comment_id: cur_elem_vote.data('opportunity-comment-id'),
            like: vote
        },
        success: function success(data) {
            if (cur_elem_vote.hasClass('active')) {
                cur_elem_vote.removeClass('active');
                cur_elem_vote_count.text(cur_vote_count_int - 1)
            } else if (opposite_elem_vote.hasClass('active')) {
                opposite_elem_vote.removeClass('active')
                cur_elem_vote.addClass('active');
                cur_elem_vote_count.text(cur_vote_count_int + 1)
                opposite_elem_vote_count.text(opposite_vote_count_int - 1)
            } else {
                cur_elem_vote.addClass('active');
                cur_elem_vote_count.text(cur_vote_count_int + 1)
            }

        },
        error: function error(xhr, status, error) {
            console.log(xhr)
            console.log(status)
            console.log(error)
        }
    });
});

function appendNewComment(comment, appendLast) {
    var commentsDivStart = $(document.getElementById("discusion-comments-section-start"))
    var commentsDivEnd = $(document.getElementById("discusion-comments-section-end"))
    if (appendLast) {
        commentsDivEnd.before(comment);
    } else {
        commentsDivStart.after(comment);
    }
}

$("#new_comment_button").on('click', function (e) {
    var cur_elem_vote = $(this);
    var opportunity_id = cur_elem_vote.data("opportunity-id")
    var text = $(document.getElementById("new_comment-text-id")).val()

    comments_counter_elem = $(document.getElementById('opportunity-comments-count'))
    comments_count = comments_counter_elem.text().replace(/[^\d+]/g, '')

    var action = '/opportunity/comment/store'

    $.ajax({
        type: 'POST',
        url: $('body').data('url') + action,
        data: {
            opportunity_id: opportunity_id,
            text: text
        },
        success: function success(data) {
            appendNewComment(data.comment, false);
            comments_counter_elem.text('კომენტარები (' + (parseInt(comments_count) + 1) + ')')

            $('#new_comment-text-id').val('');
            $('.comment-form-container .button--red').addClass('disabled');
            $('.comment-form-container .button--red').attr('disabled', true);

            adjustAllCommentsHeights()
        }
    });
});

$(document).on('click', '#see-more-comments', function (e) {
    var button = $(this);
    var opportunity_id = button.data("opportunity-id")

    var all_comments = $(document.getElementsByClassName("comment"))
    var all_comments_ids = all_comments.map((x, k) => k.id.split('-')[2])
    all_comments_ids = jQuery.makeArray(all_comments_ids)

    var action = '/ajax-opportunity-comment-paginate'
    $.ajax({
        type: 'POST',
        url: $('body').data('url') + action,
        data: {
            opportunity_id: opportunity_id,
            current_comment_ids: all_comments_ids
        },
        success: function (data) {
            var comments = data.comments
            console.log(data)
            comments.forEach(element => {
                appendNewComment(element, true)
            });

            if (!data.hasMore) {
                see_more_elem = $(document.getElementById('discusion-comments-section-end'))
                see_more_elem.remove()
            }
            adjustAllCommentsHeights()
        }
    });
});

$(document).on('click', '#delete-opportunity-comment-button', function (e) {
    comment_id = $(this).attr('data-comment-id')

    comment_elem = $(document.getElementById('opportunity-comment-' + comment_id))
    comments_counter_elem = $(document.getElementById('opportunity-comments-count'))
    comments_count = comments_counter_elem.text().replace(/[^\d+]/g, '')

    action = '/opportunity/comment/delete'

    $.ajax({
        type: 'POST',
        url: $('body').data('url') + action,
        data: {
            id: comment_id
        },
        success: function success(data) {
            comment_elem.remove();
            $('.popup-delete-comment').removeClass('popup-active');
            $('body').removeClass('frozen');
            comments_counter_elem.text('კომენტარები (' + (parseInt(comments_count) - 1) + ')')
        }
    });
});


//organization page
$('.switch__item').click(function () {
    let index = $(this).index() + 1;
    if ($(this).hasClass('disabled')) {
        return;
    } else {
        $(this).closest('.tabs-wrapper').find('.tab').removeClass('active')
        $(this).closest('.tabs-wrapper').find(".tab:nth-child(" + index + ")").addClass('active');
    }
})
//organization page ends

$('#see-more-feedbacks-organization-inner-page').click(function () {
    url = '/ajax-organization-feedback-paginate'
    count = $('.comment').length
    $.ajax({
        type: 'POST',
        url: $('body').data('url') + url,
        data: {
            company_id: $(this).data('company-id'),
            count: count,
        },
        success: function (data) {
            var feedbacks = data.feedbacks
            feedbacks.forEach(element => {
                $("#organization-feedbacks").append(element);
            });
            if (!data.hasMore) {
                see_more_elem = $(document.getElementById('see-more-feedbacks-organization-inner-page'))
                see_more_elem.remove()
            }

        },
        error: function () {
        }
    });
})

$('.see-more-opportunities-organization-page').click(function () {

    $(this).css('display', 'none');
    $(this).closest('.org-event-buttons').find('.see-less-opportunities-organization-page').css('display', 'inline-flex');

    // add items
    $(this).closest('.events-block').find('.event').each(function () {
        $(this).css('display', 'block');
    });
})

$('.see-less-opportunities-organization-page').click(function () {

    $(this).css('display', 'none');
    $(this).closest('.org-event-buttons').find('.see-more-opportunities-organization-page').css('display', 'inline-flex');

    // remove items
    $(this).closest('.events-block').find('.event').each(function (index) {
        if (index <= 2) {
            $(this).css('display', 'block');
        } else {
            $(this).css('display', 'none');
        }
    });
})

//shorten content
$('.shorten-content').each(function () {
    if ($(this)[0].scrollHeight <= $(this).height()) {
        console.log($(this)[0]);
        $(this).parent().find('.more-content-button').css('display', 'none');
    }
})

$('.more-content-button').click(function () {
    $(this).toggleClass('active');
    $(this).parent().find('.shorten-content').toggleClass('full-content');
})
// $('.more-content-button').click(function(){
//     if($target[0].scrollHeight > $target.height()){
//         $(this).addClass('active');
//         $(this).parent().find('.shorten-content').addClass('full-content');
//     }else {
//         $(this).removeClass('active');
//         $(this).parent().find('.shorten-content').removeClass('full-content');
//     }
// })

//shorten content ends

//old----------------------------------------------------------------------------------------------------
// $('.see-less-opportunities-organization-page-asdasdfasdfasdf').click(function () {

//     $(this).css('display', 'none');
//     $(this).closest('.org-event-buttons').find('.see-more-opportunities-organization-page').css('display', 'inline-flex');

// add items
// var events = $(this).parent().prev().children()
// events.each(function (index, value) {
//     $(value).css("display", "")
//     if (expanded && index > 8)
//         $(value).css("display", "none")
// })

// Change text/button
// children = $(this).children()
// var titleDiv = $(children[0])
// var imgDiv = $(children[1])
// if (expanded) {
//     titleDiv.html('ნახე მეტი');
//     $(this).closest('.org-event-buttons').find('.see-less-opportunities-organization-page').addClass(active);
//     imgDiv.css("transform", "rotate(0deg)")
// } else {
//     titleDiv.html('ნახე ნაკლები');
//     imgDiv.css("transform", "rotate(180deg)")
// }

// // Change Boolean value
// $(this).data('expanded', !expanded);
// })
//old------------------------------------------------------------------------------

//Range Slider
$(function () {
    if ($('.filter-age').length != 0) {
        if ($viewportWidth <= 991) {
            $('.filter-age-mobile').addClass('filter-age-active');
            $('.range-slider-mobile').attr('id', 'range-slider');
        } else {
            $('.filter-age-desktop').addClass('filter-age-active');
            $('.range-slider-desktop').attr('id', 'range-slider');
        }

        var slider = document.getElementById('range-slider');

        noUiSlider.create(slider, {
            start: [0, 100],
            connect: true,
            range: {
                'min': 0,
                'max': 100
            }
        });

        slider.noUiSlider.on('update', function () {
            var valuesDecimal = slider.noUiSlider.get();
            var valuesInt = valuesDecimal.map(x => Math.floor(x));
            $('.input-age.min').val(valuesInt[0]);
            $('.input-age.max').val(valuesInt[1]);
            // $('.filter-age .filter__button').text(valuesInt.join(' - '));
        })
        $('.filter-age-active .input-age.min').on('input', function () {
            slider.noUiSlider.set([$(this).val(), null]);
        })
        $('.filter-age-active .input-age.max').on('input', function () {
            slider.noUiSlider.set([null, $(this).val()]);
        })

        var origins = slider.getElementsByClassName('noUi-origin');

        origins[0].setAttribute('disabled', true);
        origins[1].setAttribute('disabled', true);

        $('.filter-age-active #no-min').on('change', function () {
            if ($(this).is(':checked')) {
                $('.filter-age-active #min-age').prop('readonly', true);
                $('.filter-age-active #min-age').prop('disabled', true);
                slider.noUiSlider.set([0, null]);
                origins[0].setAttribute('disabled', true);
            } else {
                $('.filter-age-active #min-age').prop('readonly', false);
                $('.filter-age-active #min-age').prop('disabled', false);
                origins[0].removeAttribute('disabled');
            }
        })

        $('.filter-age-active #no-max').on('change', function () {
            if ($(this).is(':checked')) {
                slider.noUiSlider.set([null, 100]);
                origins[1].setAttribute('disabled', true);
                $('.filter-age-active #max-age').prop('readonly', true);
                $('.filter-age-active #max-age').prop('disabled', true);
            } else {
                origins[1].removeAttribute('disabled');
                $('.filter-age-active #max-age').prop('readonly', false);
                $('.filter-age-active #max-age').prop('disabled', false);
            }
        })
    }

    // $('.filter-age input').on('change input', function () {
    //     $defaultTitle = $(this).closest('.filter').find('.filter__button').attr("default");
    //     var valuesDecimal = slider.noUiSlider.get();
    //     var valuesInt = valuesDecimal.map(x => Math.floor(x));
    //     $min = valuesInt[0];
    //     $max = valuesInt[1];

    //     if ($('#no-min').is(':checked')) {
    //         $min = ' ';
    //     }
    //     if ($('#no-max').is(':checked')) {
    //         $max = ' ';
    //     }

    //     if ($('#no-min').is(':checked') && $('#no-min').is(':checked')) {
    //         $('.filter-age .filter__button').text($defaultTitle);
    //     }else {
    //         $('.filter-age .filter__button').text($min + ' - ' + $max);
    //     }
    // })

    //Range Slider ends
});


$(document).ready(function () {
    // Opportunity cards
    $('.favorites-btn').not('.disabled').on('click', function () {
        console.log('click');
        $(this).toggleClass('selected');
    });

    // Opportunity inner page
    if ($('#possibility_main_container').length) {

        // URL copy button
        $('.url-copy-btn').on('click', function () {
            let urlContainer = $('#event-url');

            urlContainer.select();
            document.execCommand('copy');
        });

        // Subscription
        $('.subscribe-btn').on('click', function () {
            let subscribe = false;
            const btn = $(this);
            const companyId = btn.data('company-id');

            if (btn.hasClass('active') && companyId) {
                if ($(this).hasClass('subscribed')) {
                    $('.subscribe-btn').removeClass('subscribed');
                    $('.subscribe-btn').text('გამოწერა');
                } else {
                    $('.subscribe-btn').addClass('subscribed');
                    $('.subscribe-btn').text('გამოწერილი');
                    subscribe = true;
                }

                changeState('subscribtion', subscribe, companyId, false, btn);
            }
        });

        function updateSubscriberCounter(subscribers) {
            if (subscribers != null) {
                $('.organizer-name-container .subscribers span').text(subscribers);
            }
        }

        // Favorites
        $('.add-to-favorites-btn').on('click', function () {
            let addToFavorites = false;
            const btn = $(this);
            const opportunityId = btn.data('opportunity-id');

            if (btn.hasClass('active') && opportunityId) {
                if (btn.hasClass('added')) {
                    $('.add-to-favorites-btn').removeClass('added');
                } else {
                    $('.add-to-favorites-btn').addClass('added');
                    addToFavorites = true;
                }

                changeState('favorites', addToFavorites, false, opportunityId, btn);
            }
        });

        //Going
        $('.fill-application-btn.no-url').on('click', function () {
            let going = false;
            const btn = $(this);
            const opportunityId = btn.data('opportunity-id');

            if (btn.hasClass('active') && opportunityId) {
                if (btn.hasClass('going')) {
                    $('.fill-application-btn.no-url').removeClass('going');
                    $('.fill-application-btn.no-url .btn-text').text('წასვლა');
                } else {
                    $('.fill-application-btn.no-url').addClass('going');
                    $('.fill-application-btn.no-url .btn-text').text('მიდიხართ');
                    going = true;
                }

                changeState('going', going, false, opportunityId, btn);
            }
        });

        // Change users subscriptions, favorites and attendance
        function changeState(actionCategory, action, companyId = false, opportunityId = false, clickedButton) {
            const btn = clickedButton;
            let id;

            if (actionCategory === 'subscribtion' && companyId) {
                id = companyId;
                if (action) {
                    url = '/subscribe-company';
                } else {
                    url = '/unsubscribe-company';
                }
            } else if (actionCategory === 'favorites' && opportunityId) {
                id = opportunityId;
                if (action) {
                    url = '/ajax-add-opportunity-to-favorites';
                } else {
                    url = '/ajax-remove-opportunity-from-favorites'
                }
            } else if (actionCategory === 'going' && opportunityId) {
                id = opportunityId;
                if (action) {
                    url = '/ajax-add-opportunity-to-going';
                } else {
                    url = '/ajax-remove-opportunity-from-going';
                }
            }

            if (id) {
                btn.css('pointer-events', 'none');

                $.ajax({
                    url: url,
                    method: 'post',
                    data: {
                        'id': id
                    },
                    success: function (response) {
                        if (actionCategory === 'subscribtion') {
                            updateSubscriberCounter(response['subscriberCount']);
                        }
                        btn.css('pointer-events', '');
                    }, error: function () {
                        console.log("something went wrong");
                        btn.css('pointer-events', '');
                    }
                });
            }
        }

        // Change tabs
        $('.tab-btn').on('click', function () {
            let selectedTabBtn = $(this);
            let selectedTab;

            if (!selectedTabBtn.hasClass('active')) {
                $('.tab-btn').removeClass('active');
                $('.tabs-container .tab').removeClass('active');

                selectedTabBtn.addClass('active');

                if (selectedTabBtn.hasClass('description')) {
                    selectedTab = $('.tabs-container .tab-event-description');
                } else if (selectedTabBtn.hasClass('faq')) {
                    selectedTab = $('.tabs-container .tab-faq');
                } else if (selectedTabBtn.hasClass('media')) {
                    selectedTab = $('.tabs-container .tab-media');
                } else {
                    selectedTab = $('.tabs-container .tab-files');
                }
                selectedTab.addClass('active');
            }
        });

        // Fix tab-switcher position on scroll
        const tabSwitcher = $('.tab-switcher');
        const tabsContainer = $('.tabs-container');
        const categoriesDropdown = $('.categorize.transition-top');
        const tabletBreakPoint = 991;
        const mobileBreakPoint = 660;
        let headerHeight;
        let basicInfoContainerHeight;
        let bodyPaddingTop;
        let tabSwitcherHeight;
        setHeightAttributes();

        $(window).on('resize', function () {
            const windowWidth = $(window).width();

            if (windowWidth > tabletBreakPoint) {
                setHeightAttributes();
            } else {
                unfixTabSwitcher();
            }
        });

        $(window).on('scroll', function () {
            if ($(window).width() > tabletBreakPoint) {
                if ($(window).scrollTop() > basicInfoContainerHeight + bodyPaddingTop - headerHeight) {
                    fixTabSwitcher();
                } else {
                    unfixTabSwitcher();
                }
            } else {
                unfixTabSwitcher();
            }
        });

        function setHeightAttributes() {
            headerHeight = $('.header-container').height();
            basicInfoContainerHeight = $('.basic-info-container').outerHeight(true);
            bodyPaddingTop = parseInt($(document.body).css('padding-top').slice(0, -2));
            tabSwitcherHeight = tabSwitcher.outerHeight();
        }

        function fixTabSwitcher() {
            tabSwitcher.addClass('fixed');
            tabSwitcher.css('top', headerHeight + 'px');
            tabsContainer.css('margin-top', tabSwitcherHeight + 'px');
            categoriesDropdown.addClass('disabled');
        }

        function unfixTabSwitcher() {
            if (tabSwitcher.hasClass('fixed')) {
                tabSwitcher.removeClass('fixed');
                tabSwitcher.css('top', 'auto');
                tabsContainer.css('margin-top', '0');
                categoriesDropdown.removeClass('disabled');
            }
        }

        // FAQ
        $('.single-faq').on('click', function () {
            if ($(this).hasClass('active')) {
                closeAllQuestions();
            } else {
                closeAllQuestions();
                $(this).addClass('active');
            };
        });

        function closeAllQuestions() {
            $('.single-faq').removeClass('active');
        }

        // Slider
        $('.single-image').on('click', function () {
            let activeImage = $(this);
            let imageUrl = activeImage.css('background-image');

            $('.single-image').removeClass('active');
            activeImage.addClass('active');


            $('.slider').addClass('active');
            $('.slider .active-image').css('background-image', imageUrl);
        });

        $(document).keyup(function (e) {
            if ($('.slider').hasClass('active')) {
                if (e.key === "Escape") {
                    closeSlider();
                } else if (e.keyCode == 37) { // Left arrow
                    changeSlide('left');
                }
                else if (e.keyCode == 39) { // Right arrow
                    changeSlide('right');
                }
            }
        });

        $('.navigation.slider-control').on('click', function () {
            if ($(this).hasClass('left')) {
                changeSlide('left');
            } else {
                changeSlide('right');
            }
        });

        $('.slider-close').on('click', closeSlider);

        window.addEventListener('click', function (e) {
            if (!document.getElementById('active-image').contains(e.target) && document.getElementById('slider').contains(e.target) && $('.slider').hasClass('active')) {
                closeSlider();
            }
        });

        function changeSlide(direction) {
            let activeImage = $('.images .single-image.active');
            let newActiveImage;

            $('.single-image').removeClass('active');

            if (direction === 'left') {
                newActiveImage = activeImage.prev();
                if (!newActiveImage.length) {
                    newActiveImage = $('.single-image').last();
                }
            } else {
                newActiveImage = activeImage.next();
                if (!newActiveImage.length) {
                    newActiveImage = $('.single-image').first();
                }
            }

            newActiveImage.addClass('active');
            imageUrl = newActiveImage.css('background-image');
            $('.slider .active-image').css('background-image', imageUrl);
        }

        function closeSlider() {
            $('.slider').removeClass('active');
        }
    }
});