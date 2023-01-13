/*================================================================================
    Item Name: Materialize - Material Design Admin Template
    Version: 5.0
    Author: PIXINVENT
    Author URL: https://themeforest.net/user/pixinvent/portfolio
================================================================================

NOTE:
------
PLACE HERE YOUR OWN JS CODES AND IF NEEDED.
WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR CUSTOM SCRIPT IT'S BETTER LIKE THIS. */
//media upload

if ($('.dropzone').length) {

    Dropzone.options.myAwesomeDropzone = { // The camelized version of the ID of the form element

        // The configuration we've talked about above
        // autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        previewsContainer: ".dropzone-previews",
        clickable: '.dropzone-new-image',
        previewTemplate: `
        <div class="dz-preview dz-complete dz-image-preview">
            <label class="checkbox-container">
                <input type="checkbox" class="image-to-delete" disabled>
                <span class="checkmark"></span>
                <div class="dz-image">
                <img data-dz-thumbnail>
                </div>
                <div class="dz-error-message">
                <span data-dz-errormessage></span>
                </div>
                <div class="remove" href="javascript:undefined;" data-dz-remove></div>
            </label>
        </div>
      `,
        success: function (file, response) {
            console.log(response);
        },
        renameFile: function (file) {
            var dt = new Date();
            var time = dt.getTime();
            return time + file.name;
        },
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        addRemoveLinks: true,
        timeout: 5000,

        // The setting up of the dropzone
        init: function () {
            var myDropzone = this;

            // First change the button to actually tell Dropzone to process the queue.
            // this.element.querySelector(".submit-button").addEventListener("click", function (e) {
            //     // Make sure that the form isn't actually being sent.
            //     e.preventDefault();
            //     e.stopPropagation();
            //     myDropzone.processQueue();
            // });

            // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
            // of the sending event because uploadMultiple is set to true.
            this.on("sendingmultiple", function () {
                console.log(`Dropzone Sending Multiple...`)
                // Gets triggered when the form is actually being sent.
                // Hide the success button or the complete form.
            });
            this.on("successmultiple", function (files, response) {
                console.log(`Dropzone Success: ${response}`)
                // Gets triggered when the files have successfully been sent.
                // Redirect user or notify of success.
            });
            this.on("errormultiple", function (files, response) {
                console.log(`Dropzone Error: ${response}`)
                // Gets triggered when there was an error sending the files.
                // Maybe show form again, and notify user of error
            });

            this.on('addedfile', function () {
                console.log(`Dropzone New File Added!`)
                $('.media-edit-actions').addClass('active');
            });
            this.on('removedfile', function (file) {
                console.log(`Dropzone File Removed! ${file.id}`)
                if (file.id) {
                    $.post('/admin/opportunity/media/delete', {
                        'id': file.id
                    })
                }
                if ($('.dz-preview').length == 0) {
                    $('.media-edit-actions').removeClass('active');
                }
            });
            $.get('/admin/opportunity/media/' + oppId + "'", function (data) {
                $.each(data, function (key, value) {
                    var mockFile = { name: value.name, size: value.size, id: value.id };
                    myDropzone.options.addedfile.call(myDropzone, mockFile);
                    myDropzone.options.thumbnail.call(myDropzone, mockFile, value.name);

                    $('.media-edit-actions').addClass('active');
                });
            });
        }
    }

    $('.media-edit-actions .edit').on('click', function () {
        $('.dropzone-previews').addClass('in-edit-mode');
        $('.dropzone-previews .dz-preview input:checkbox').prop('disabled', false);
        $('.dropzone-new-image-wrapper').addClass('hidden');
        $(this).parent().find('.cancel').addClass('active');
        $(this).removeClass('active');
    });

    $('.media-edit-actions .delete').on('click', function () {
        $selectedImages = $('.image-to-delete:checked');
        $selectedImages.each(function () {
            $(this).closest('.dz-preview').addClass('hidden');
        })
        $(this).parent().find('.confirm').addClass('active');
        $(this).removeClass('active');
    });

    $('.media-edit-actions .confirm').on('click', function () {
        $selectedImages = $('.image-to-delete:checked');
        $selectedImages.each(function () {
            $(this).closest('.dz-preview').find('.remove').trigger('click');
        })
        $(this).parent().find('.cancel').removeClass('active');
        $(this).parent().find('.delete').removeClass('active');
        $(this).removeClass('active');
        $(this).parent().find('.edit').addClass('active');
        $('.dz-preview input:checkbox').prop('checked', false);
        $('.dz-preview input:checkbox').prop('disabled', true);
        $('.dropzone-previews').removeClass('in-edit-mode');
        $('.dropzone-new-image-wrapper').removeClass('hidden');
    });

    $('.media-edit-actions .cancel').on('click', function () {
        $('.dz-preview.hidden').removeClass('hidden');
        $('.dz-preview input:checkbox').prop('checked', false);
        $('.dz-preview input:checkbox').prop('disabled', true);
        $('.dropzone-previews').removeClass('in-edit-mode');
        $(this).parent().find('.delete').removeClass('active');
        $(this).removeClass('active');
        $(this).parent().find('.edit').addClass('active');
        $(this).parent().find('.confirm').removeClass('active');
        $('.dropzone-new-image-wrapper').removeClass('hidden');
    });

    $('.dropzone-previews').on('change', '.dz-preview input:checkbox', function () {
        if ($('.dropzone-previews .dz-preview input:checkbox:checked').length != 0) {
            $('.media-edit-actions .delete').addClass('active');
        } else {
            $('.media-edit-actions .delete').removeClass('active');
        }
    })

}

//media upload ends

const { functionsIn, isBoolean } = require("lodash");

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

let globalImageSrc = null

$(document).ready(function () {

    // COVER UPLOAD WITH DRAG: START

    // $('#cover-form .button').unbind('click');

    // $('#cover-form .button').on('click', function (e) {
    //     e.preventDefault();
    //     $('#cover-form input[name="cover_image"]').unbind('click');
    //     $('#cover-form input[name="cover_image"]').click();
    // })

    // $('.add-cover').on('click', function(){
    //     $('#cover-raw').trigger('click');
    // })



    // $('.confirm-upload .cancel').on('click', function () {
    //     $('#cover-image').attr('src', $('#cover-image').attr('original-src'));
    //     $('#cover-image').attr('style', $('#cover-image').attr('original-style'));
    //     $('.cover-wrapper').removeAttr('state-save');
    // });

    $('.confirm-upload .save').on('click', function () {
        $.ajax({
            type: 'POST',
            url: $('body').data('url') + '/set-cover-ajax',
            data: {
                code: globalImageSrc,
                locale: $('body').data('locale')
            },
            success: function (data) {
                location.reload();
            }
        });
    });

    $('.popup-profile-pic .save').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: $('body').data('url') + '/set-profile-ajax',
            data: {
                code: globalImageSrc,
                locale: $('body').data('locale')
            },
            success: function (data) {
                location.reload();
            }
        });
    });

    // // Width of image
    // var _IMAGE_WIDTH;

    // // Height of image
    // var _IMAGE_HEIGHT;

    // // Image loaded or not
    // var _IMAGE_LOADED = 0;

    // var _LAST_MOUSE_POSITION = { x: null, y: null };
    // var _DIV_OFFSET = $('.cover-wrapper').offset();
    // var _CONTAINER_WIDTH = $(".cover-wrapper").outerWidth();
    // var _CONTAINER_HEIGHT = $(".cover-wrapper").outerHeight();

    // if ($('#cover-image').get(0).complete) {
    //     ImageLoaded();
    // }
    // else {
    //     $('#cover-image').on('load', function () {
    //         ImageLoaded();
    //     });
    // }

    // // Image is loaded
    // function ImageLoaded() {
    //     _IMAGE_WIDTH = $("#cover-image").width();
    //     _IMAGE_HEIGHT = $("#cover-image").height();
    //     if (_IMAGE_WIDTH < _CONTAINER_WIDTH) {
    //         _IMAGE_WIDTH = _CONTAINER_WIDTH;
    //         $("#cover-image").width(_IMAGE_WIDTH);
    //     }
    //     if (_IMAGE_HEIGHT < _CONTAINER_HEIGHT) {
    //         _IMAGE_HEIGHT = _CONTAINER_HEIGHT;
    //         $("#cover-image").height(_IMAGE_HEIGHT);
    //     }
    //     _IMAGE_LOADED = 1;
    // }

    // var _DRAGGGING_STARTED = 0;

    // $('.cover-wrapper').on('mousedown', function (event) {
    //     if (!this.hasAttribute('state-save')) {
    //         return;
    //     }
    //     // Image should be loaded before it can be dragged
    //     if (_IMAGE_LOADED == 1) {
    //         _DRAGGGING_STARTED = 1;

    //         /* Save mouse position */
    //         _LAST_MOUSE_POSITION = { x: event.pageX - _DIV_OFFSET.left, y: event.pageY - _DIV_OFFSET.top };
    //     }
    // });

    // $('.cover-wrapper').on('mouseup', function () {
    //     if (!this.hasAttribute('state-save')) {
    //         return;
    //     }
    //     _DRAGGGING_STARTED = 0;
    // });

    // $('.cover-wrapper').on('mousemove', function (event) {
    //     if (!this.hasAttribute('state-save')) {
    //         return;
    //     }
    //     if (_DRAGGGING_STARTED == 1) {
    //         var current_mouse_position = { x: event.pageX - _DIV_OFFSET.left, y: event.pageY - _DIV_OFFSET.top };
    //         var change_x = current_mouse_position.x - _LAST_MOUSE_POSITION.x;
    //         var change_y = current_mouse_position.y - _LAST_MOUSE_POSITION.y;

    //         /* Save mouse position */
    //         _LAST_MOUSE_POSITION = current_mouse_position;

    //         var img_top = parseInt($("#cover-image").css('top'), 10);
    //         var img_left = parseInt($("#cover-image").css('left'), 10);

    //         var img_top_new = img_top + change_y;
    //         var img_left_new = img_left + change_x;

    //         /* Validate top and left do not fall outside the image, otherwise white space will be seen */
    //         if (img_top_new > 0)
    //             img_top_new = 0;
    //         if (img_top_new < (_CONTAINER_HEIGHT - _IMAGE_HEIGHT))
    //             img_top_new = _CONTAINER_HEIGHT - _IMAGE_HEIGHT;

    //         if (img_left_new > 0)
    //             img_left_new = 0;
    //         if (img_left_new < (_CONTAINER_WIDTH - _IMAGE_WIDTH))
    //             img_left_new = _CONTAINER_WIDTH - _IMAGE_WIDTH;

    //         $('input[name="cover_top_position"]').val(img_top_new / _CONTAINER_HEIGHT * 100 + '%');
    //         $('input[name="cover_left_position"]').val(img_left_new / _CONTAINER_WIDTH * 100 + '%');
    //         $("#cover-image").css({ top: img_top_new + 'px', left: img_left_new + 'px' });
    //     }
    // });

    // $('#cover').on('change', function () {
    //     $('.cover-wrapper').attr('state-save', '');
    //     readURL(this, '.cover-wrapper .cover');
    // })

    // // COVER UPLOAD WITH DRAG: END

    $('#select-files').on('click', function () {
        $('#upfile').click();
    });

    function readURL(input, selector) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(selector).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#upfile").change(function () {
        readURL(this, '#opportunity-image');
    });


    // profile page -- start
    $orgProfileTabNames = ['', 'tab=about', 'tab=registration-place', 'tab=organization-types', 'tab=activity-areas', 'tab=activity-fields', 'tab=contact', 'tab=password', 'tab=subscripted-orgs', 'tab=subscripted-categories'];

    $('.profile-wrapper .sidebar .sidebar-item').on('click', function () {
        $('.profile-wrapper .sidebar .sidebar-item').removeClass('active');
        $(this).addClass('active');
        $('.profile-wrapper .tab').removeClass('active');
        const index = $(this).data('tab-index');
        $('.profile-wrapper .tab[data-tab-index="' + index + '"]').addClass('active');

        var pageUrl = '?' + $orgProfileTabNames[index];
        window.history.pushState('', '', pageUrl);
    })

    if ($('#description_ka').length && !$('#description_ka').hasClass('limited-editor')) {


        ClassicEditor
            .create(document.querySelector('#description_ka'), {
                mediaEmbed: {
                    previewsInData: true,
                },
                ckfinder: {
                    // Upload the images to the server using the CKFinder QuickUpload command.
                    uploadUrl: '/ck-upload-image'
                }
            })
            .catch(error => {
                console.error(error);
            });
        //CKEDITOR.replace('description1_ka', {
        //    placeholder: $('#description1_ka').attr('placeholder')
        //});
    }

    if ($('.limited-editor').length) {
        ClassicEditor
            .create(document.querySelector('#description1_ka'), {
                toolbar: ['heading', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote']
            })
            .catch(error => {
                console.error(error);
            });
    }


    $('.registration-place-toggle input').on('change', function () {
        if ($('.registration-place-toggle .left input').is(':checked')) {
            $('.registration-place-toggle').parent().find('.toggle-left').removeClass('disabled');
            $('.registration-place-toggle').parent().find('.toggle-left input').removeAttr('disabled');
            $('.registration-place-toggle').parent().find('.toggle-right').addClass('disabled');
            $('.registration-place-toggle').parent().find('.toggle-right input').attr('disabled', 'disabled');
            if ($('.registration-place-toggle').parent().find('.toggle-left input').val() != '') {
                $('.registration-place-toggle').parent().find('.toggle-left + div').removeClass('disabled');
                $('.registration-place-toggle').parent().find('.toggle-left + div input').removeAttr('disabled');
            }

            $(this).closest('form').find('.is-local').addClass('active');
            $(this).closest('form').find('.is-local').find('input:text').not('.ignore-input-text').attr('pattern', '.{1}');

            $(this).closest('form').find('.is-international input:text').removeAttr('pattern');
        }
        else {
            $('.registration-place-toggle').parent().find('.toggle-right').removeClass('disabled');
            $('.registration-place-toggle').parent().find('.toggle-right input').removeAttr('disabled');
            $('.registration-place-toggle').parent().find('.toggle-left').addClass('disabled');
            $('.registration-place-toggle').parent().find('.toggle-left input').attr('disabled', 'disabled');
            $('.registration-place-toggle').parent().find('.toggle-left + div').addClass('disabled');
            $('.registration-place-toggle').parent().find('.toggle-left + div input').attr('disabled', 'disabled');

            $(this).closest('form').find('.is-local').removeClass('active');
            $(this).closest('form').find('.is-local').find('input:text').removeAttr('pattern');

            $(this).closest('form').find('.is-international input:text').attr('pattern', '.{1}');
        }
    })

    $('.same-address-wrapper .toggle-container input').on('change', function () {
        if ($('.same-address-wrapper .toggle-container  .left input').is(':checked')) {
            $('.factual-address-wrapper').addClass('disabled');
            $('.factual-address-wrapper input').attr('disabled', 'disabled');
            $('.factual-address-wrapper input').removeAttr('pattern');
            $('.factual-address-wrapper input').removeClass('fucked-up');
        }
        else {
            $('.factual-address-wrapper').removeClass('disabled');
            $('.factual-address-wrapper input').removeAttr('disabled');
            $('.factual-address-wrapper input').attr('pattern', '.{1}');
        }
    })

    $('.tab--working-types .sub-item input').on('change', function (e) {
        const id = $(this).val();
        if ($(this).is(':checked')) {
            $('.tab--working-types .subtype[type-id="' + id + '"]').addClass('active');
        }
        else {
            $('.tab--working-types .subtype[type-id="' + id + '"]').removeClass('active');
        }
    })

    $('#select-all-types input').on('change', function () {
        if ($(this).is(':checked')) {
            $('.tab--working-types .sub-item input').trigger('change');
        }
        else {
            $('.tab--working-types .sub-item input').trigger('change');
        }
    })
    // profile page -- end


    // opportunity page -- start

    $('.opportunity-page .photo-wrapper .button').click(function (e) {
        e.preventDefault();
        $('.popup-opportunity-pic').addClass('popup-active');
        $('body').addClass('frozen');
    });

    $('.add-file-input').on('click', function (e) {
        e.preventDefault();
        let inputHtml = `<div class="file-field input-field">
            <div class="btn">
                <input type="file" name="file[]">
            </div>
            <div class="file-path-wrapper">
                <p class="uploaded-value firago firago--style-normal firago--500 firago--smm firago--dark"></p>
                <img class="remove-input" src="/img/icons/remove-input.svg" alt="minus">
            </div>
        </div>`;
        $('.file-inputs').append(inputHtml);
        setTimeout(function () {

            $('.file-inputs .file-field:last-child input').on('blur', function () {
                if ($(this).val() == '') {
                    $(this).parents('.file-field').remove();
                }
            });

            $('.file-inputs .file-field:last-child input').on('change', function (e) {
                if ($(this).val() == '') {
                    $(this).parents('.file-field').remove();
                }
                else {
                    $(this).parents('.file-field').find('.file-path-wrapper').addClass('active');
                    $(this).parents('.file-field').find('.file-path-wrapper p').text(e.target.files[0].name);
                }
            });

            $('.file-inputs .file-field:last-child input').click();
        }, 500);
    });

    $('.uploader-container input#opportunity-pic').on('change', function () {
        if ($(this).val() != '') {
            $(this).parents('.uploader-container').find('.upload-tools').hide();
            $(this).parents('.uploader-container').find('img').show();
            readURL(this, '#opportunity-pic-image');
        }
        else {
            $(this).parents('.uploader-container').find('.upload-tools').show();
            $(this).parents('.uploader-container').find('img').hide();
        }
    })

    document.body.onfocus = function () {
        setTimeout(function () {
            $('.file-inputs .file-field').not('.existing').find('input').each(function () {
                if ($(this).val() == '') {
                    $(this).parents('.file-field').remove();
                }
            });
        }, 500)
    };

    var currentYear = new Date().getFullYear();
    $('.opportunity-page .dates-section input.hasDatepicker').datepicker({
        dateFormat: 'dd.mm.yy',
        changeMonth: true,
        changeYear: true,
        yearRange: "1900:" + currentYear
    });


    $(document).on('click', '.file-inputs .file-field .remove-input', function () {
        $this = $(this)
        $('.popup-delete-confirm .title-text').text('გსურთ ფაილის წაშლა?');
        $('.popup-delete-confirm').addClass('popup-active');
        $('body').addClass('frozen');
        $('.popup-delete-confirm .delete').on('click', function () {
            if ($this.parents('.file-field').hasClass('existing')) {
                let input = '<input type="hidden" name="deleted_files[]"></input>';
                $this.parents('.file-inputs').prepend(input);
                $this.parents('.file-field').remove();
            } else {
                $this.parents('.file-field').remove();
            }
            $('.popup-delete-confirm').removeClass('popup-active');
            $('body').removeClass('frozen');
        })
    });

    $('.file-inputs-wrapper .remove-all-file-inputs').on('click', function () {
        $files = $('.file-inputs .file-field');
        if ($files.length) {
            $('.popup-delete-confirm .title-text').text('გსურთ ყველა ფაილის წაშლა?');
            $('.popup-delete-confirm').addClass('popup-active');
            $('body').addClass('frozen');
            $('.popup-delete-confirm .delete').on('click', function () {
                $files = $('.file-inputs .file-field');
                $files.each(function () {
                    if ($(this).hasClass('existing')) {
                        let input = '<input type="hidden" name="deleted_files[]"></input>';
                        $(this).parents('.file-inputs').prepend(input);
                        $(this).remove();
                    } else {
                        $(this).remove();
                    }
                })
                $('.popup-delete-confirm').removeClass('popup-active');
                $('body').removeClass('frozen');
            })
        }
    });

    function checkSize(max_img_size) {
        var inputs = $(".file-inputs input");
        inputs.each(function (indx, input) {
            if (input.files && input.files.length == 1) {
                if (input.files[0].size > max_img_size) {
                    alert("The file must be less than " + (max_img_size / 1024 / 1024) + "MB");
                    return false;
                }
            }
        });
        return true;
    }

    $('.opportunity-page form').on('submit', function (e) {
        if (!checkSize(1024 * 1024 * 30)) {
            e.preventDefault();
        }
    });

    function switchTab(index, validate = true) {

        if (validate) {
            $dataIsValid = opportunityValidation();

            if (!$dataIsValid) {
                return false;
            }
        }

        if ($("html, body").scrollTop() > $("html, body")[0].scrollHeight / 2) {
            $("html, body").animate({
                scrollTop: $('.company-info').offset().top
            }, 600);
        }

        $('.opportunity-page .sidebar .circle, .opportunity-page .sidebar .line').removeClass('active');
        $('.opportunity-page .sidebar .circle, .opportunity-page .sidebar .line').removeClass('past');

        for (let i = 1; i < index; i++) {
            $('.opportunity-page .sidebar .circle[data-tab-index="' + i + '"], .opportunity-page .sidebar .line[data-tab-index="' + i + '"]').addClass('past');
        }

        $('.opportunity-page .sidebar .circle[data-tab-index="' + index + '"], .opportunity-page .sidebar .line[data-tab-index="' + index + '"]').addClass('active');

        $('.opportunity-page .tab').removeClass('active');
        $('.opportunity-page .sidebar .sidebar-item').removeClass('active');
        $('.opportunity-page .tab[data-tab-index="' + index + '"]').addClass('active');
        $('.opportunity-page .sidebar .sidebar-item[data-tab-index="' + index + '"]').addClass('active');
    }

    function oppTitleVisibility(tabIndex) {
        if ($('#main').hasClass('opportunity-edit')) {
            if (tabIndex > 5) {
                $('.opportunity-edit .opp-title').addClass('hidden');
            } else {
                $('.opportunity-edit .opp-title').removeClass('hidden');
            }
        }
    }

    $('.opportunity-page .sidebar .sidebar-item').on('click', function () {
        const index = parseInt($(this).data('tab-index'));
        switchTab(index);
        oppTitleVisibility(index);
    })

    $('.opportunity-page .next-step-button').on('click', function () {
        const index = parseInt($('.opportunity-page .tab.active').data('tab-index'));
        switchTab(index + 1);
    })

    $('.opportunity-page .prev-step-button').on('click', function () {
        const index = parseInt($('.opportunity-page .tab.active').data('tab-index'));
        switchTab(index - 1, false);
    })


    //validations
    function opportunityValidation() {

        $requiredChechboxes = $('.opportunity-page .tab.active').prevAll('.tab').addBack().find('.required-checkboxes');
        $isChecked = true;
        $requiredChechboxes.each(function () {
            if ($(this).find('input:checked').length == 0) {
                $isChecked = false;
                $(this).addClass('not-checked');
                $(this).find('input').on('change', function () {
                    if ($(this).is(':checked')) {
                        $(this).closest('.required-checkboxes').removeClass('not-checked');
                    }
                })
            }
        })

        $requiredTitle = $('.opportunity-page .pick-for-validation');
        $requiredTabInputs = $('.opportunity-page .tab.active').prevAll('.tab').addBack().find('.form__input');
        $requiredInputs = $requiredTabInputs.add($requiredTitle);
        $filledCorrectly = true;
        $requiredInputs.each(function () {
            $value = $(this).val();
            $pattern = $(this).attr('pattern');
            if (!new RegExp($pattern).test($value) || $(this).hasClass('fucked-up')) {
                $filledCorrectly = false;
                $(this).addClass('fucked-up');
                $(this).parent().find('.form__tooltip--error').addClass('active');
                $(this).parent().find('.form__tooltip--light').addClass('form__tooltip--error active');
            }
        })


        $editorFilled = $('.form__group--admin .ck-content').text() != '';

        if (!$editorFilled) {
            $('.opportunity-page .tab.active .contains-editor .form__tooltip--error').addClass('active');
            $('.contains-editor .ck-editor').on('click', function () {
                $(this).closest('.form__group').find('.form__tooltip--error').removeClass('active');
            })
        }

        return ($isChecked && $filledCorrectly && $editorFilled);
    }

    //validations ends

    $('.registration-types .registration-type input[type="radio"]').on('change', function () {
        if ($(this).prop('checked')) {
            $(this).parents('.registration-type').addClass('active');
            if ($(this).hasClass('right')) {
                $(this).parents('.registration-type').find('input[type="text"]').removeAttr('disabled');
                $(this).parents('.registration-type').find('.form__tooltip').removeClass('hidden');
                $('.registration-types .registration-type.left-type').removeClass('active');
            }
            else {
                $('.registration-types .registration-type.right-type').removeClass('active');
                $('.registration-types .registration-type.right-type input[type="text"]').attr('disabled', 'true');
                $('.registration-types .registration-type.right-type .form__tooltip').addClass('hidden');
            }
        }
    });

    $('.event-types .event-type input[type="radio"]').on('click', function () {
        $(this).closest('.event-types').find('.event-type').removeClass('active');
        $(this).closest('.event-type').addClass('active');

        if ($(this).hasClass('right')) {
            $(this).parents('.event-type').find('input[type="text"]').removeAttr('disabled');
            $(this).parents('.event-type').find('input[type="text"]').attr('pattern', '.{1}');
            $(this).parents('.event-type').find('.form__tooltip').removeClass('hidden');

            $(this).closest('.tab').find('.opportunity-location-wrapper').addClass('disabled');
            $(this).closest('.tab').find('.opportunity-location-wrapper input:text').prop('disabled', true);
            $(this).closest('.tab').find('.opportunity-location-wrapper input:text').not('.ignore').removeAttr('pattern');
            $(this).closest('.tab').find('.opportunity-location-wrapper input:text').removeClass('fucked-up');
            configMap('map', false);
        }
        else {
            $(this).parents('.event-types').find('input[type="text"]').prop('disabled', true);
            $(this).parents('.event-types').find('input[type="text"]').val('');
            $(this).parents('.event-types').find('input[type="text"]').removeAttr('pattern');
            $(this).parents('.event-types').find('input[type="text"]').removeClass('fucked-up');
            $(this).parents('.event-types').find('.form__tooltip').addClass('hidden');

            $(this).closest('.tab').find('.opportunity-location-wrapper').removeClass('disabled');
            $(this).closest('.tab').find('.opportunity-location-wrapper input:text').prop('disabled', false);
            $(this).closest('.tab').find('.opportunity-location-wrapper input:text').not('.ignore').attr('pattern', '.{1}');
            configMap('map', true);
        }
    });

    $('.age-row .checkbox-container input').on('change', function () {
        if ($(this).prop('checked')) {
            const inputForm = $(this).parents('.age-row').find('.form__group');
            inputForm.addClass('disabled');
            inputForm.find('input').attr('readonly', 'readonly');
            inputForm.find('input').val('-');
            inputForm.find('input').removeAttr('pattern');
            inputForm.find('input').removeClass('fucked-up');
            inputForm.find('input').prop('disabled', true);
            inputForm.find('.form__tooltip').removeClass('active');
        }
        else {
            const inputForm = $(this).parents('.age-row').find('.form__group');
            inputForm.removeClass('disabled');
            inputForm.find('input').removeAttr('readonly');
            inputForm.find('input').val('');
            inputForm.find('input').attr('pattern', '.{1}');
            inputForm.find('input').prop('disabled', false);
        }
    })

    $('.sidebar-item[data-tab-index="5"], .next-step-button').on('click', function (e) {
        e.preventDefault();
        if ($('.tab.active').attr('data-tab-index') == '5') {
            setTimeout(function () {
                configMap('map', true);
            })
        }
    });
    if ($viewportWidth <= 991) {
        $('.menu-mobile-item[data-tab-index="5"]').on('click', function (e) {
            setTimeout(function () {
                configMap('map', true);
            })
        });
    }

    // opportunity page -- end

    //FAQ
    $('.faq-single .faq-input').on('input', function () {
        if ($(this).val() != '') {
            $(this).removeClass('blank');
        }
    })

    function validateFaq(faqSingle) {
        $isBlank = true;
        $inputs = faqSingle.find('.faq-input');
        $inputs.each(function () {
            if ($(this).val() == '') {
                $(this).addClass('blank');
                $isBlank = false;
            }
        })
        return $isBlank;
    }

    $('.faq-new .add-faq').on('click', function () {
        $questionInput = $('.faq-new .faq-question .faq-input');
        $question = $questionInput.val();
        $answerInput = $('.faq-new .faq-answer .faq-input');
        $answer = $answerInput.val();

        if (!validateFaq($('.faq-new'))) {
            return
        }

        $id = $('.faq-added .faq-added-single').length;

        $('.faq-added').append(
            `
            <div class="faq-added-single faq-single mb-2">
                <div class="faq-question">
                    <input type="text" name='faq_question[]' class='faq-input' value="`+ $question + `" readonly>
                </div>
                <div class="faq-answer">
                    <textarea class='faq-input faq-textarea' name='faq_answer[]' value="`+ $answer + `" readonly>` + $answer + `</textarea>
                </div>
                <div class="faq-action-button show-answer"></div>
                <div class="faq-action-button active edit-faq"></div>
                <div class="faq-action-button save-edit-faq"></div>
                <div class="faq-action-button cancel-edit-faq"></div>
                <div class="faq-action-button delete-faq"></div>
            </div>
            `
        )

        $question = $questionInput.val('');
        $answer = $answerInput.val('');
        $questionInput.removeClass('blank');
        $answerInput.removeClass('blank');
        $('.faq-added .faq-title').addClass('active');
    })

    $('.faq-added').on('click', '.show-answer', function () {
        $(this).closest('.faq-added-single').toggleClass('active');
    })

    $('.faq-added').on('input', '.faq-input', function () {
        if ($(this).val() != '') {
            $(this).removeClass('blank');
        }
    })

    $('.faq-added').on('click', '.edit-faq', function () {
        $(this).removeClass('active');
        $(this).parent().find('.save-edit-faq, .cancel-edit-faq').addClass('active');
        $(this).parent().addClass('edit-mode');
        $(this).parent().addClass('active');
        $(this).parent().find('.faq-input').removeAttr('readonly');
        $inputs = $(this).closest('.faq-added-single').find('.faq-input');
        $inputs.each(function () {
            $value = $(this).val();
            $(this).data('previous-data', $value);
        })
    })

    $('.faq-added').on('click', '.save-edit-faq', function () {
        if (validateFaq($(this).closest('.faq-added-single'))) {
            $(this).parent().find('.faq-input').attr('readonly', true);
            $(this).parent().find('.faq-input').data('previous-data', '');
            $(this).parent().find('.faq-input').removeClass('blank');
            $(this).parent().find('.save-edit-faq').removeClass('active');
            $(this).parent().find('.cancel-edit-faq').removeClass('active');
            $(this).parent().find('.edit-faq').addClass('active');
            $(this).parent().removeClass('edit-mode');
            $(this).parent().removeClass('active');
        }
    })

    $('.faq-added').on('click', '.cancel-edit-faq', function () {
        $inputs = $(this).closest('.faq-added-single').find('.faq-input');
        $inputs.each(function () {
            $(this).val($(this).data('previous-data'));
        })
        $(this).parent().find('.faq-input').attr('readonly', true);
        $(this).parent().find('.faq-input').data('previous-data', '');
        $(this).parent().find('.faq-input').removeClass('blank');
        $(this).parent().find('.save-edit-faq').removeClass('active');
        $(this).parent().find('.cancel-edit-faq').removeClass('active');
        $(this).parent().find('.edit-faq').addClass('active');
        $(this).parent().removeClass('edit-mode');
        $(this).parent().removeClass('active');
    })

    $('.faq-added').on('click', '.delete-faq', function () {
        $faqsAdded = $('.faq-added-single').length;
        $this = $(this);
        $('.popup-delete-faq').addClass('popup-active');
        $('body').addClass('frozen');
        $('.popup-delete-faq .delete').on('click', function () {
            if ($faqsAdded <= 1) {
                $('.faq-added .faq-title').removeClass('active');
            }
            $this.parent().remove();
            $('.popup-delete-faq').removeClass('popup-active');
            $('body').removeClass('frozen');
        })
    })

    $('.section-faq textarea').on('keypress', function (event) {
        if (event.key == 13) {
            event.stopPropagation();
        }
    })

    //FAQ ENDS

    //admin opps

    $('.opportunity-button.delete-button').on('click', function () {
        $('.popup-delete-opp form input[name = "id"]').val('');
        $('.popup-delete-opp form input[name = "id"]').val($(this).data('opp-id'));
        $('.popup-delete-opp').addClass('popup-active');
        $('body').addClass('frozen');
    })

    //admin opps ends

    //user-list checkbox handling

    $('.users-table .uncheck-all input').on('click', function () {
        if ($(this).is(':checked')) {
            $(this).closest('.users-table').find('.checkbox-container').not($(this).parent()).find('input').prop('checked', true);
        } else {
            $(this).closest('.users-table').find('.checkbox-container').not($(this).parent()).find('input').prop('checked', false);
        }
    })

    //user-list checkbox handling ends


    $('.datepicker[name="start_date"]').datepicker({
        format: 'yyyy-mm-dd',
        editable: true,
    });

    $('.datepicker[name="start_date"]').on('change', function () {
        $('.datepicker[name="end_date"]').datepicker({
            format: 'yyyy-mm-dd',
            editable: true,
            minDate: new Date($('.datepicker[name="start_date"]').val())
        });
    });

    $('.datepicker[name="end_date"]').datepicker({
        format: 'yyyy-mm-dd',
        editable: true,
        minDate: new Date($('.datepicker[name="start_date"]').val())
    });

    $('.datepicker[name="schedule_date"]').datepicker({
        format: 'yyyy-mm-dd',
        editable: true,
        minDate: new Date()
    });

    $('.unsubscribe-company').on('click', function (e) {
        let $this = $(this);
        let companyId = $this.data('id');
        $.ajax({
            type: 'POST',
            url: $('body').data('url') + '/unsubscribe-company',
            data: {
                id: companyId,
                locale: $('body').data('locale')
            },
            success: function (data) {
                $this.parents('.subbed-wrapper').hide();
            }
        });
    });

    $('.unsubscribe-category').on('click', function (e) {
        let $this = $(this);
        let categoryId = $this.data('category-id');
        $.ajax({
            type: 'POST',
            url: $('body').data('url') + '/unsubscribe-category',
            data: {
                id: categoryId,
                locale: $('body').data('locale')
            },
            success: function (data) {
                $this.parents('.subbed-wrapper').hide();
            }
        });
    });

    $('.custom-close').on('click', function (e) {
        e.preventDefault();
        $('#error-modal, #error-modal-overlay').hide();
    });

    $(".select2-categories").select2({
        placeholder: 'Categories',
        dropdownAutoWidth: true,
        width: '100%',
        minimumResultsForSearch: Infinity,
        escapeMarkup: function (es) {
            return es;
        }
    });

    $(".select2-working-types").select2({
        placeholder: 'Operation Types',
        dropdownAutoWidth: true,
        width: '100%',
        minimumResultsForSearch: Infinity,
        escapeMarkup: function (es) {
            return es;
        }
    });

    $(".select2-disabilities").select2({
        placeholder: 'Disabilities',
        dropdownAutoWidth: true,
        width: '100%',
        minimumResultsForSearch: Infinity,
        escapeMarkup: function (es) {
            return es;
        }
    });

    $(".select2-regions").select2({
        placeholder: 'Regions',
        dropdownAutoWidth: true,
        width: '100%',
        minimumResultsForSearch: Infinity,
        escapeMarkup: function (es) {
            return es;
        }
    });

    $('.select2-regions').on('change', function () {
        $('.select2-regions option').each(function () {
            if (!$(this).prop('selected')) {
                $('.select2-municipalities option[data-region-id="' + $(this).attr('value') + '"]').addClass('invisible');
                $('.select2-municipalities option[data-region-id="' + $(this).attr('value') + '"]').prop('selected', false);
                $('.select2-municipalities').trigger('change.select2');
            }
            else {
                $('.select2-municipalities option[data-region-id="' + $(this).attr('value') + '"]').each(function () {
                    if ($(this).hasClass('invisible')) {
                        $(this).removeClass('invisible');
                        $(this).prop('selected', true);
                        $('.select2-municipalities').trigger('change.select2');
                    }
                });
            }
        })
        const values = $(this).val();
        for (let i = 0; i < values.length; i++) {
            const value = values[i];
            $('.select2-municipalities option[data-region-id="' + value + '"]').removeClass('invisible');
        }
    })

    $(".select2-municipalities").select2({
        placeholder: 'Municipalities',
        dropdownAutoWidth: true,
        width: '100%',
        minimumResultsForSearch: Infinity,
        escapeMarkup: function (es) {
            return es;
        }
    });

    $(".select2-types").select2({
        placeholder: 'Types',
        dropdownAutoWidth: true,
        width: '100%',
        minimumResultsForSearch: Infinity,
        escapeMarkup: function (es) {
            return es;
        }
    });

    $('.select2-types').on('change', function () {
        $('.select2-types option').each(function () {
            if (!$(this).prop('selected')) {
                $('.select2-subtypes option[data-type-id="' + $(this).attr('value') + '"]').addClass('invisible');
                $('.select2-subtypes option[data-type-id="' + $(this).attr('value') + '"]').prop('selected', false);
                $('.select2-subtypes').trigger('change.select2');
            }
            else {
                $('.select2-subtypes option[data-type-id="' + $(this).attr('value') + '"]').each(function () {
                    if ($(this).hasClass('invisible')) {
                        $(this).removeClass('invisible');
                        $(this).prop('selected', true);
                    }
                });
                $('.select2-subtypes').trigger('change.select2');
            }
        })
        const values = $(this).val();
        for (let i = 0; i < values.length; i++) {
            const value = values[i];
            $('.select2-subtypes option[data-type-id="' + value + '"]').removeClass('invisible');
        }
    })

    $(".select2-subtypes").select2({
        placeholder: 'Subtypes',
        dropdownAutoWidth: true,
        width: '100%',
        minimumResultsForSearch: Infinity,
        templateResult: (data, container) => {
            if (data.element) {
                $(container).addClass($(data.element).attr("class"));
            }
            return data.text;
        },
        escapeMarkup: function (es) {
            return es;
        }
    });

    $(".select2-agerange").select2({
        placeholder: 'Age Range',
        dropdownAutoWidth: true,
        width: '100%',
        minimumResultsForSearch: Infinity,
        escapeMarkup: function (es) {
            return es;
        }
    });

    $(".select2-municipalities").select2({
        placeholder: 'Municipalities',
        dropdownAutoWidth: true,
        width: '100%',
        minimumResultsForSearch: Infinity,
        escapeMarkup: function (es) {
            return es;
        }
    });

    $(".select2-is-georgia").select2({
        dropdownAutoWidth: true,
        width: '100%',
        minimumResultsForSearch: Infinity,
        escapeMarkup: function (es) {
            return es;
        }
    });

    $(".select2-type").select2({
        placeholder: "Type",
        dropdownAutoWidth: true,
        width: '100%',
        minimumResultsForSearch: Infinity,
        escapeMarkup: function (es) {
            return es;
        }
    });

    $(".select2-status").select2({
        placeholder: "Status",
        dropdownAutoWidth: true,
        width: '100%',
        minimumResultsForSearch: Infinity,
        escapeMarkup: function (es) {
            return es;
        }
    });

    $('.delete-media').on('click', function (e) {
        let path = $(this).data('path');
        let input = '<input type="hidden" name="removed_media[]" value="' + path + '"></input>';
        $('.old-media').prepend(input);
        $(this).parent().hide();
    });

    function checkSize(max_img_size) {
        var inputs = $(".file-inputs input");
        inputs.each(function (indx, input) {
            if (input.files && input.files.length == 1) {
                if (input.files[0].size > max_img_size) {
                    alert("The file must be less than " + (max_img_size / 1024 / 1024) + "MB");
                    return false;
                }
            }
        });
        // check for browser support (may need to be modified)

        return true;
    }

    $('.opportunity-form').on('submit', function (e) {
        if (!checkSize(1024 * 1024 * 30)) {
            e.preventDefault();
        }
    });

    $('#mark-all').on('change', function () {
        const value = $(this).is(':checked');
        $('.attended-user-checkbox').prop('checked', value).change();
        $('.attended-user-checkbox').toggleClass('marked');
    });

    /*if ($('#date_ka').length) {
        CKEDITOR.replace('date_ka');

        CKEDITOR.replace('date_en');

        CKEDITOR.replace('address_ka');

        CKEDITOR.replace('address_en');

        CKEDITOR.replace('description_ka');

        CKEDITOR.replace('description_en');
    } else if ($('#description1_ka').length) {
        CKEDITOR.replace('description1_ka');

        CKEDITOR.replace('description1_en');

        CKEDITOR.replace('description2_ka');

        CKEDITOR.replace('description2_en');

        CKEDITOR.replace('address_ka');

        CKEDITOR.replace('address_en');
    }*/

    $('.has-option-other input:radio').on('click', function () {
        $(this).closest('form').find('.option-other input:checkbox').prop('checked', false).change();
    })

    $('.has-option-other input:checkbox').on('click', function () {
        $(this).closest('form').find('input:radio').prop('checked', false).change();
    })

    $viewportWidth = $(window).width();

    if ($viewportWidth <= 991) {
        $('.menu-mobile-admin .menu-mobile-item').on('click', function () {
            if (!$(this).hasClass('current')) {
                $('.menu-mobile-admin').toggleClass('active');

                if ($('.profile-wrapper').length) {
                    $('.profile-wrapper .tab').removeClass('active');
                    const index = $(this).data('tab-index');
                    $('.profile-wrapper .tab[data-tab-index="' + index + '"]').addClass('active');

                    var pageUrl = '?' + $orgProfileTabNames[index];
                    window.history.pushState('', '', pageUrl);
                } else if ($('.opportunity-page').length) {
                    index = $(this).data('tab-index');
                    if (!switchTab(index)) {
                        return;
                    }
                    $('.opportunity-page .tab').removeClass('active');
                    const index = $(this).data('tab-index');
                    $('.opportunity-page .tab[data-tab-index="' + index + '"]').addClass('active');
                    oppTitleVisibility(index);
                }
                // $('.profile-wrapper .tab').removeClass('active');
                // const index = $(this).data('tab-index');
                // $('.profile-wrapper .tab[data-tab-index="' + index + '"]').addClass('active');
                $(this).addClass('active');
                $('.menu-mobile-item.current').text($(this).text());
                $('.menu-mobile-item').removeClass('active');
                $(this).addClass('active');
            } else {
                $('.menu-mobile-admin').toggleClass('active');
            }
        })

        $('.menu-mobile-admin .icon').on('click', function () {
            $('.menu-mobile-admin').toggleClass('active');
        })

        if ($('.profile-wrapper').length) {
            $('.menu-mobile-admin .menu-mobile-item.active').trigger('click');
            $('.menu-mobile-admin').removeClass('active');
        }
    }

    //opp image upload
    // $('.photo-wrapper .opp-image-upload').on('click', function () {
    //     $('#opp-image-file').trigger('click');
    // })

    // $('.photo-wrapper .opp-image-remove').on('click', function () {
    //     $('#opp-image-file').val('').trigger('change');
    // })

    // $('#opp-image-file').on('change', function () {
    //     if ($(this).val() != '') {
    //         readURL(this, '#opp-image-displayed');
    //     } else {
    //         $('#opp-image-displayed').attr('src', $(this).data('default-image'));
    //     }
    // })

    // function readURL(input, selector) {
    //     if (input.files && input.files[0]) {
    //         var reader = new FileReader();
    //         reader.onload = function (e) {
    //             $(selector).attr('src', e.target.result);
    //         }
    //         reader.readAsDataURL(input.files[0]);
    //         setTimeout(initCropper, 1000);
    //     }
    // }

    $('.uploader-container input.raw-file-input').on('change', function () {
        if ($(this).val() != '') {
            $(this).parents('.uploader-container').find('.upload-tools').removeClass('active');
            $(this).closest('.popup').find('.popup-buttons').addClass('active');
        }
        else {
            $(this).parents('.uploader-container').find('.upload-tools').addClass('active');
            $(this).closest('.popup').find('.popup-buttons').removeClass('active');
        }
    })

    noUploadListener = true;
    noCroppListener = true;

    $('.cropper-popup-trigger').on('click', function () {
        if ($('.popup-resizable-pic').hasClass('popup-active')) {
            let renderedRawWrapper = document.querySelector('.popup-active .rendered-raw-wrapper'),
                renderedRawContainer = document.querySelector('.popup-active .rendered-raw-container'),
                croppedContainer = document.querySelector('.popup-active .cropped-container'),
                cropButton = document.querySelector('.popup-active .crop-button'),
                croppedImage = document.querySelector('.popup-active .cropped-image'),
                upload = document.querySelector('.popup-active .raw-file-input');
            cancelImage = document.querySelector('.popup-active .img-cancel');
            // on change show image with crop options
            if (noUploadListener) {
                cropper = null;
                noUploadListener = false;
                upload.addEventListener('change', (e) => {
                    if (e.target.files.length) {
                        // start file reader
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            if (e.target.result) {
                                // create new image
                                let img = document.createElement('img');
                                img.id = 'image';
                                img.src = e.target.result;
                                // clean result before
                                renderedRawWrapper.innerHTML = '';
                                // append new image
                                renderedRawContainer.classList.add('active');
                                renderedRawWrapper.appendChild(img);
                                cropper = new Cropper(img, {
                                    aspectRatio: 1 / 1,
                                    dragMode: 'move',
                                    viewMode: 1
                                });
                            }
                        };
                        reader.readAsDataURL(e.target.files[0]);
                    }
                    else {
                        renderedRawWrapper.innerHTML = '';
                    }
                });
            }

            // save on click
            if (noCroppListener) {
                noCroppListener = false;
                cropButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    // get result to data uri
                    let imgSrc = cropper.getCroppedCanvas().toDataURL();
                    globalImageSrc = imgSrc;
                    // remove hide class of img
                    renderedRawContainer.classList.remove('active');
                    croppedContainer.classList.add('active');
                    // show image cropped
                    croppedImage.src = imgSrc;
                    $('#org-profile-image').val(imgSrc);
                    // dwn.classList.remove('hide');
                    // dwn.download = 'imagename.png';
                    // dwn.setAttribute('href', imgSrc);

                    $('.popup-active .save').addClass('active');
                });
            }
            $('#enable-crop').on('click', function () {
                $(this).parent().removeClass('active');
                $('.popup-active .rendered-raw-container').addClass('active');
            })

            $('.img-cancel').on('click', function () {
                $('.popup-active').find('.rendered-raw-container').removeClass('active');
                $('.popup-active').find('.cropped-container').removeClass('active');
                $('.popup.popup-active .raw-file-input').val('').trigger('change');
                $('.popup-active .rendered-raw-wrapper').html('');
                $('.popup-active .cropped-image').attr('src', '');
                $('.popup-active .save').removeClass('active');
                $(this).closest('.popup').removeClass('popup-active');
                $('body').removeClass('frozen');
                cropper = null;
                $('#org-profile-image').val('');
            })

        }
    })

    let listenToUpload = true;
    $('.opp-image-upload').on('click', function () {
        let renderedRawWrapper = document.querySelector('.opp-image-section .rendered-raw-wrapper'),
            renderedRawContainer = document.querySelector('.opp-image-section .rendered-raw-container'),
            croppedContainer = document.querySelector('.opp-image-section .cropped-container'),
            cropButton = document.querySelector('.opp-image-section .crop-button'),
            croppedImage = document.querySelector('.opp-image-section .cropped-image'),
            upload = document.querySelector('#opp-image-file'),
            deleteImage = document.querySelector('.opp-image-section .opp-image-remove'),
            enableCrop = document.querySelector('.opp-image-section .enable-crop'),
            cropper = null;

        upload.click();
        $this = this;
        if (listenToUpload) {
            listenToUpload = false;
            upload.addEventListener('change', (e) => {
                noCroppListener = false;
                if (e.target.files.length) {
                    // start file reader
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        if (e.target.result) {
                            // create new image
                            let img = document.createElement('img');
                            img.id = 'image';
                            img.src = e.target.result;
                            // clean result before
                            renderedRawWrapper.innerHTML = '';
                            // append new image
                            renderedRawContainer.classList.add('active');
                            renderedRawWrapper.appendChild(img);
                            cropper = new Cropper(img, {
                                aspectRatio: 3 / 1,
                                dragMode: 'move',
                                viewMode: 1
                            });
                            $this.classList.remove('active');
                            deleteImage.classList.add('active');
                            cropButton.classList.add('active');
                        }
                    };
                    reader.readAsDataURL(e.target.files[0]);
                }
                else {
                    renderedRawWrapper.innerHTML = '';
                }
            });

            cropButton.addEventListener('click', (e) => {
                e.preventDefault();
                let imgSrc = cropper.getCroppedCanvas().toDataURL();
                globalImageSrc = imgSrc;
                renderedRawContainer.classList.remove('active');
                croppedContainer.classList.add('active');
                croppedImage.src = imgSrc;
                enableCrop.classList.add('active');
                cropButton.classList.remove('active');
                $('#opportunity-image').val(imgSrc);
            });
            $('.enable-crop').on('click', function () {
                renderedRawContainer.classList.add('active');
                croppedContainer.classList.remove('active');
                enableCrop.classList.remove('active');
                cropButton.classList.add('active');
            })
            $('.opp-image-remove').on('click', function () {
                cropper = null;
                renderedRawWrapper.innerHTML = '';
                renderedRawContainer.classList.remove('active');
                croppedContainer.classList.remove('active');
                $('.opp-image-section .cropped-image').attr('src', '');
                $('.opp-image-section #opp-image-file').val('');
                enableCrop.classList.remove('active');
                cropButton.classList.remove('active');
                $('.opp-image-upload').addClass('active');
                $(this).removeClass('active');
                $('#opportunity-image').val('');
            })
        }
    })


    let coverHasBeenActivated = true;

    $('.add-cover').on('click', function () {
        let renderedRawWrapper = document.querySelector('.cover-wrapper .rendered-raw-wrapper'),
            renderedRawContainer = document.querySelector('.cover-wrapper .rendered-raw-container'),
            croppedContainer = document.querySelector('.cover-wrapper .cropped-container'),
            cropButton = document.querySelector('.cover-wrapper .crop-button'),
            croppedImage = document.querySelector('.cover-wrapper .cropped-image'),
            upload = document.querySelector('#cover-raw'),
            cancelUpload = document.querySelector('.cover-wrapper .cancel'),
            cropper = null;

        upload.click();
        $this = this;
        if (coverHasBeenActivated) {
            coverHasBeenActivated = false;
            upload.addEventListener('change', (e) => {
                noCroppListener = false;
                if (e.target.files.length) {
                    // start file reader
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        if (e.target.result) {
                            // create new image
                            let img = document.createElement('img');
                            img.id = 'image';
                            img.src = e.target.result;
                            // clean result before
                            renderedRawWrapper.innerHTML = '';
                            // append new image
                            renderedRawContainer.classList.add('active');
                            renderedRawWrapper.appendChild(img);
                            cropper = new Cropper(img, {
                                aspectRatio: 6.2 / 1,
                                dragMode: 'move',
                                viewMode: 1
                            });
                            $this.classList.remove('active');
                            cancelUpload.classList.add('active');
                            cropButton.classList.add('active');
                            $('.add-cover').removeClass('active');
                            $('.cover-wrapper .confirm-upload').addClass('active');
                        }
                    };
                    reader.readAsDataURL(e.target.files[0]);
                }
                else {
                    renderedRawWrapper.innerHTML = '';
                }
            });

            cropButton.addEventListener('click', (e) => {
                e.preventDefault();
                let imgSrc = cropper.getCroppedCanvas().toDataURL();
                globalImageSrc = imgSrc;
                renderedRawContainer.classList.remove('active');
                croppedContainer.classList.add('active');
                croppedImage.src = imgSrc;
                cropButton.classList.remove('active');
                $('.cover-wrapper .save').addClass('active');
                $('#cover-image-base64').val(imgSrc);
            });

            $('.cover-wrapper .cancel').on('click', function () {
                cropper = null;
                renderedRawWrapper.innerHTML = '';
                renderedRawContainer.classList.remove('active');
                croppedContainer.classList.remove('active');
                $('.cover-wrapper .cropped-image').attr('src', '');
                $('.cover-wrapper #cover-raw').val('');
                cropButton.classList.remove('active');
                $('.add-cover').addClass('active');
                $('.confirm-upload').removeClass('active');
                $(this).removeClass('active');
                $('.cover-wrapper .save').removeClass('active');
                $('#cover-image-base64').val('');
            })
        }
    })

    if ($viewportWidth > 991) {
        $('.select-section .municipalities-dropdown .checkbox-container').on('click', function () {
            if (!$(this).closest('.filter__dropdown').find('input:checkbox:checked').length) {
                $dataId = $(this).closest('.municipality-section').data('region-id');
                $(this).closest('.municipality-section').removeClass('active');
                $(this).closest('.select-section').find('.regions input:checkbox[data-id =' + $dataId + ']').prop('checked', false);
                if (!$(this).closest('.select-section').find('.regions input:checkbox:checked').length) {
                    $(this).closest('.select-section').find('.uncheck-all').removeClass('half-checked');
                }
            }
        })
    }

    if ($(".opportunity-edit").length || $('.profile-page').length) {
        $('.tab .filter__dropdown').each(function () {
            $checkboxesCount = $(this).find('.checkbox-container:not(.all-checkmark) input:checkbox').length;
            $checkboxesCheckedCount = $(this).find('.checkbox-container:not(.all-checkmark) input:checkbox:checked').length;
            if ($checkboxesCount == $checkboxesCheckedCount) {
                $(this).find('.all-checkmark input:checkbox').prop('checked', true);
            } else if ($checkboxesCheckedCount != 0 && $checkboxesCheckedCount < $checkboxesCount) {
                $(this).find('.all-checkmark').addClass('half-checked');
            }
        })
    }

    $('.save-opp-editing').on('click', function () {

        //$(this).closest('form').trigger('submit');
    })


    $('.see-user-message').on('click', function(){
        $message = $(this).attr('message');
        console.log($message);
        if(!$(this).closest('tr').find('.anonymous').length){
            $firstName = $(this).closest('tr').find('.user-first-name').text();
            $lastName = $(this).closest('tr').find('.user-last-name').text();
            $userImage = $(this).closest('tr').find('.user-image img').attr('src');
            $('.popup-user-feedback .user-image img').attr('src', $userImage);
            $('.popup-user-feedback .user-name .name').text($firstName + ' ' + $lastName);
            $('.popup-user-feedback .user-name .blue').removeClass('active');
            $('.popup-user-feedback .user-name .public').addClass('active');
            $('.popup-user-feedback .user-message').text($message);
            $('.popup-user-feedback').addClass('popup-active');
        }else {
            $('.popup-user-feedback .user-name .name').text('ანონიმური');
            $('.popup-user-feedback .user-name .blue').removeClass('active');
            $('.popup-user-feedback .user-name .not-public').addClass('active');
            $('.popup-user-feedback .user-message').text($message);
            $('.popup-user-feedback').addClass('popup-active');
        }
    })

    $('#main-form .save-opp-editing, #main-form .submit-button').on('click', function() {
         image= $('#opp-image-file').val();
         const ref = this;
         $.ajax({
             type: 'POST',
             url: $('body').data('url') + '/admin/opportunity/uploadImage',
             data: {
                 image: image,
                 img_base64 : globalImageSrc,
                 opp_id : oppId
             },
             success: function success(data) {
                $(ref).parents('#main-form').submit();
             }
         })
    })

});

function configMap(id, isInteractive) {
    mapboxgl.accessToken = 'pk.eyJ1Ijoia2thcmUxMyIsImEiOiJjazlmOWk4a2owOWNjM2txbXJkOW5rbGN0In0.AmDmOAjgp5f7X5FrWSMudA';
    var map = new mapboxgl.Map({
        container: id,
        style: 'mapbox://styles/kkare13/ck9icz6na001o1ippxy87ahwe',
        interactive: isInteractive
    });

    const setLat = $('input#latitude').val();
    const setLng = $('input#longitude').val();

    let center = [44.783333, 41.716667];

    if (setLat && setLng) {
        center = [setLng, setLat];
    }

    map.setZoom(12);
    map.setCenter(center);

    var marker = new mapboxgl.Marker()
        .setLngLat(center)
        .setDraggable(true)
        .addTo(map);

    marker.on('dragend', function (event) {
        const lnglat = event.target.getLngLat();
        const lng = lnglat.lng;
        const lat = lnglat.lat;
        $('input#latitude').val(lat);
        $('input#longitude').val(lng);
    });
}


var pageURL = window.location.href;
var oppId = pageURL.substr(pageURL.lastIndexOf('/') + 1);

// $('.has-option-other input:radio').on('click', function () {
//     $(this).closest('form').find('.option-other input:checkbox').prop('checked', false).change();
// })

// $('.has-option-other input:checkbox').on('click', function () {
//     $(this).closest('form').find('input:radio').prop('checked', false).change();
// })

// $viewportWidth = $(window).width();

// $(function () {
//     if ($viewportWidth <= 991) {
//         $('.menu-mobile-admin .menu-mobile-item').on('click', function () {
//             if (!$(this).hasClass('current')) {
//                 $('.menu-mobile-admin').toggleClass('active');

//                 if ($('.profile-wrapper').length) {
//                     $('.profile-wrapper .tab').removeClass('active');
//                     const index = $(this).data('tab-index');
//                     $('.profile-wrapper .tab[data-tab-index="' + index + '"]').addClass('active');
//                 } else if ($('.opportunity-page').length) {
//                     const index = $(this).data('tab-index');
//                     switchTab(index);
//                     // $('.opportunity-page .tab').removeClass('active');
//                     // const index = $(this).data('tab-index');
//                     // $('.opportunity-page .tab[data-tab-index="' + index + '"]').addClass('active');
//                 }

//                 // $('.profile-wrapper .tab').removeClass('active');
//                 // const index = $(this).data('tab-index');
//                 // $('.profile-wrapper .tab[data-tab-index="' + index + '"]').addClass('active');
//                 $(this).addClass('active');
//                 $('.menu-mobile-item.current').text($(this).text());
//                 $('.menu-mobile-item').removeClass('active');
//                 $(this).addClass('active');
//             } else {
//                 $('.menu-mobile-admin').toggleClass('active');
//             }
//         })

//         $('.menu-mobile-admin .icon').on('click', function () {
//             $('.menu-mobile-admin').toggleClass('active');
//         })
//     }
// })
