var KTCreateApp = function () {
    // Elements
    var modal;
    var modalEl;
    var curso = 0;
    var stepper;
    var form;
    var formSubmitButton;
    var formContinueButton;

    // Variables
    var stepperObj;
    var validations = [];
    // Private Functions

    $(document).ready(function () {
        KTCreateApp.init();
        StartMasks.init();

        $('.kt_docs_maxlength_basic').maxlength({
            threshold: 500,
            warningClass: "badge badge-warning",
            limitReachedClass: "badge badge-danger",
            placement: 'bottom-right-inside'
        });

        $("#floatingSelectAE").on('change', function () {
            $('#floatingSelectAETP').tooltip('dispose')
            $('#floatingSelectAETP').tooltip({
                delay: 500,
                placement: "top",
                title: $(this).find('option:selected').attr('hidden-desc') ? $(this).find('option:selected').attr('hidden-desc') : '',
                fallbackPlacement: 'flip',
                html: true,
            });
        })
        $("#floatingSelectAE2").on('change', function () {
            $('#floatingSelectAETP2').tooltip('dispose')
            $('#floatingSelectAETP2').tooltip({
                delay: {show: 500, hide: 700},
                placement: "top",
                title: $(this).find('option:selected').attr('hidden-desc') ? $(this).find('option:selected').attr('hidden-desc') : '',
                fallbackPlacement: 'flip',
                html: true,
            });
        })

        function hideOthers() {
            // Get all selected values
            let selectedValues = $(".exclusive-sel option:selected").map(function () {

                if (this.value.length === 0)
                    return null;
                return this.value;
            });
            // Unhide all so we can hide the correct ones
            $(".exclusive-sel option").removeAttr('hidden');

            // Filter out the selected values from dropdowns
            $("select.exclusive-sel").each(function () {
                var selectElem = $(this);
                $.each(selectedValues, function (index, value) {
                    // If the selected value from the array is from the applicable <select>, skip hiding
                    if (selectElem.find("option:selected").val() !== value) {
                        selectElem.find(`option[value="${value}"]`).attr('hidden', true);
                    }
                });
            });
        }

        $(".exclusive-sel").change(function () {
            console.log("Ecs");
            hideOthers();

            if ($(this).val() <= 0) {
                let ele = $(this).parent().next().find('.exclusive-sel').parent();
                ele.attr('hidden', true);
                ele = ele.find("select");
                if (ele.attr('id') == 'colab2')
                    ele.val("-2").change();
                else if (ele.attr('id') == 'colab3')
                    ele.val("-3").change();
            } else $(this).parent().next().find('.exclusive-sel').parent().attr('hidden', false);
        });

        $("#colab1").trigger('change');
    });

    var initStepper = function () {
        // Initialize Stepper
        stepperObj = new KTStepper(stepper);
        
        // Stepper change event(handle hiding submit button for the last step)
        stepperObj.on('kt.stepper.changed', function (stepper) {
            if (stepperObj.getCurrentStepIndex() === 2) {
                formSubmitButton.classList.remove('d-none');
                formSubmitButton.classList.add('d-inline-block');
                formContinueButton.classList.add('d-none');
            } else {
                formSubmitButton.classList.remove('d-inline-block');
                formSubmitButton.classList.remove('d-none');
                formContinueButton.classList.remove('d-none');
            }
        });
        // Validation before going to next page
        stepperObj.on('kt.stepper.next', function (stepper) {

            // Validate form before change stepper step
            var validator = validations[stepper.getCurrentStepIndex() - 1]; // get validator for currnt step

            if (validator && !form.hasAttribute('novalidate')) {
                validator.validate().then(function (status) {

                    if (status == 'Valid') {
                        stepper.goNext();
                    } else {
                        // Show error message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        /*Swal.fire({
                            text: "Por favor preencha os campos obrigatórios.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok!",
                            customClass: {
                                confirmButton: "btn btn-light"
                            }
                        }).then(function () {*/
                        let first = $('.is-invalid').first();
                        $([document.documentElement, document.body]).animate({
                            scrollTop:  first.offset().top - 150
                        },1000,function (){
                            setTimeout(function (){first.focus();},1000);
                        });

                            /*KTUtil.scrollTop($('.is-invalid').first());*/
                        //});
                    }
                });
            } else {
                stepper.goNext();

                KTUtil.scrollTop();
            }
        });
        stepperObj.on("kt.stepper.click", function (stepper) {
            if(validations[stepper.getCurrentStepIndex()-1] && stepper.getClickedStepIndex() > stepper.getCurrentStepIndex() && !form.hasAttribute('novalidate')) {
                validations[stepper.getCurrentStepIndex() - 1].validate().then(function (status) {
                    if (status === 'Valid') {
                        stepper.goTo(stepper.getClickedStepIndex());
                    } else {
                        /*Swal.fire({
                            text: "Foram detados erros no formulario, por favor verifique novamente.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok!",
                            customClass: {
                                confirmButton: "btn btn-light"
                            }
                        }).then(function () {*/
                            let first = $('.is-invalid').first();
                            $([document.documentElement, document.body]).animate({
                                scrollTop:  first.offset().top - 150
                            },1000,function (){
                                setTimeout(function (){first.focus();},1);
                            });
                        //});
                        // stepper.goTo(stepper.getClickedStepIndex());
                    }
                })
            } else {
                stepper.goTo(stepper.getClickedStepIndex());
            }
             // go to clicked step
        });
        // Prev event
        stepperObj.on('kt.stepper.previous', function (stepper) {

            stepper.goPrevious();
            KTUtil.scrollTop();
        });

        formSubmitButton.addEventListener('click', function (e) {
            // Validate form before change stepper step
            var validator = validations[0]; // get validator for last form

            validator.validate().then(function (status) {

                if (status !== 'Valid') {
                    e.preventDefault();
                    /*Swal.fire({
                        text: "Foram detados erros no formulario, por favor verifique novamente.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok!",
                        customClass: {
                            confirmButton: "btn btn-light"
                        }
                    }).then(function () {*/
                        stepperObj.goPrevious();
                        let first = $('.is-invalid').first();
                        $([document.documentElement, document.body]).animate({
                            scrollTop:  first.offset().top - 150
                        },1000,function (){
                            setTimeout(function (){first.focus();},1000);
                        });
                    //});

                } else {
                    validator = validations[1];

                    validator.validate().then(function (status) {
        
                        if (status === 'Valid') {
                            // Prevent default button action
                            e.preventDefault();
        
                            // Disable button to avoid multiple click
                            formSubmitButton.disabled = true;
        
                            // Show loading indication
                            formSubmitButton.setAttribute('data-kt-indicator', 'on');
        
                            // Simulate form submission
                            setTimeout(function() {
                                form.submit();
                                // Hide loading indication
                                formSubmitButton.removeAttribute('data-kt-indicator');
        
                                // Enable button
                                formSubmitButton.disabled = false;
                            }, 2000);
                        } else {
                            /*Swal.fire({
                                text: "Foram detados erros no formulario, por favor verifique novamente.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok!",
                                customClass: {
                                    confirmButton: "btn btn-light"
                                }
                            }).then(function () {*/
                                let first = $('.is-invalid').first();
                                $([document.documentElement, document.body]).animate({
                                    scrollTop:  first.offset().top - 150
                                },1000,function (){
                                    setTimeout(function (){first.focus();},1000);
                                });
                            //});
        
                        }
                    });
                }
            });




        });
    }
    var select2Validate = function (selector, status){
        let element = $('#'+selector);
        let oposite = status === 'is-valid' ? 'is-invalid' : 'is-valid';
        let color = status === 'is-valid' ? '#50cd89' : '#f1416c'
        element.removeClass(oposite)
        element.addClass(status);
        let childEle = element.next().find(".select2-selection");
        childEle.border
        childEle.removeClass(oposite);
        childEle.addClass(status);
    }

    // Init form inputs
    var initForm = function() {

        // Expiry month. For more info, plase visit the official plugin site: https://select2.org/
        /*$(form.querySelector('[name="titEstagio"]')).on('change', function() {
            // Revalidate the field when an option is chosen
            validations[0].revalidateField('titEstagio');
        });*/

        $(form.querySelector('[name="colab1"]')).on('change',function (e) {
            // console.log("test validation");
            validations[1].revalidateField('colab1').then(function (status){
                if(status === 'Valid' && !form.hasAttribute('novalidate')){
                    select2Validate('colab1','is-valid');
                } else if(!form.hasAttribute('novalidate')) select2Validate('colab1','is-invalid')
            });
        });
        $(form.querySelector('[name="colab2"]')).on('change',function (e) {
            // console.log("test validation");
            validations[1].revalidateField('colab2').then(function (status){
                if(status === 'Valid' && !form.hasAttribute('novalidate')){
                    select2Validate('colab2','is-valid');
                } else if(!form.hasAttribute('novalidate')) select2Validate('colab2','is-invalid')
            });
        });
    }


    var initValidation = function () {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        // Step 1
        validations.push(FormValidation.formValidation(
            form,
            {
                autoFocus: true,
                excluded: [':disabled', ':hidden', ':not(:visible)'],
                fields: {

                    periodo_estagios: {
                        validators: {
                            notEmpty: {
                                message: 'É obrigatório escolher o periodo de éstagio',
                            },
                        },
                    },
                    floatingSelectAE:{
                        validators:{
                            // notEmpty: {
                            //     message: 'É Obrigatório escolher pelo menos uma Area de Especialidade'
                            // },
                            callback: {
                                callback: function (input){
                                    let floatingSelectAE = $("#floatingSelectAE");

                                    let option = floatingSelectAE.find("option:selected").attr('is-text');

                                    if(option === "true"){
                                        $("#floatingSelectAETP2").hide();
                                        $("#TextareaOpcaoTematicaTP").show();
                                        $("#TextareaOpcaoTematicaTP").attr('is-hidden',false);
                                    } else {
                                        $("#floatingSelectAETP2").show();
                                        $("#TextareaOpcaoTematicaTP").hide();
                                        $("#TextareaOpcaoTematicaTP").attr('is-hidden',true);

                                    }
                                    if(floatingSelectAE.children('option').length > 1)
                                        return floatingSelectAE.val() != '' && floatingSelectAE.val() > 0 ? { valid: true } : {valid: false, message: 'É obrigatório escolher uma area'};
                                    else if (floatingSelectAE.children().length == 1)
                                        return true;

                                    return false;
                                },
                            },
                        },
                    },
                    floatingSelectAE2:{
                        validators:{
                            callback: {
                                callback: function (input){
                                    let floatingSelectAE = $("#floatingSelectAE");
                                    let floatingSelectAE2 = $("#floatingSelectAE2");
                                    if((floatingSelectAE.val() == '' || floatingSelectAE.val() <= 0) &&
                                        (floatingSelectAE2.val() != '' && floatingSelectAE2.val() > 0)) {

                                        return {
                                            valid: false,
                                            message: 'É obrigatório escolher a area principal primeiro'
                                        };
                                    }
                                    if(floatingSelectAE.val() == floatingSelectAE2.val() && floatingSelectAE2.val() != '') {
                                        return {
                                            valid: false,
                                            message: 'As areas de especialidade devem ser diferentes'
                                        };
                                    }
                                    return {valid: true};
                                },
                            },
                        },
                    },
                    TextareaOpcaoTematica:{
                        validators:{
                            callback: {
                                callback: function (input){
                                    let itself = $("#TextareaOpcaoTematicaTP");
                                    if(itself.attr('is-hidden') === 'true')
                                        return true;
                                    else if(itself.attr('is-hidden') === 'false'){
                                        itself = $("#TextareaOpcaoTematica");
                                        if(itself.val().length < 16){
                                            return {
                                                valid: false,
                                                message: "A area de especialidade deve entre 16 e 1024 caracteres"
                                            };
                                        } else {
                                            return true;
                                        }
                                    }
                                    return false;
                                },
                            },
                        },
                    },
                    legal_rep:{
                        validators: {
                            notEmpty: {
                                message: 'É obrigatório selecionar um Representante Legal',
                            }
                        },
                    },
                    floatingInputLocal:{
                        validators: {
                            notEmpty: {
                                message: 'É obrigatório introduzir um local'
                            },
                            stringLength: {
                                max: 255,
                                message: "O local apenas pode conter 255 caracteres"
                            }
                        },
                    },
                    TextareaEnquandramento: {
                      validators: {
                          notEmpty: {
                              message: 'É obrigatório introduzir um enquandramento'
                          },
                          stringLength: {
                              min: 50,
                              max:5000,
                              message: "O Enquandramento deve conter entre 50 a 5000 caracteres",
                          },
                      }
                    },
                    TextareaObjetivos: {
                        validators: {
                            notEmpty: {
                                message: 'É obrigatório introduzir Objetivos'
                            },
                            stringLength: {
                                min: 50,
                                max:5000,
                                message: 'O campo "Objetivos" deve conter entre 50 a 5000 caracteres',
                            }
                        }
                    },
                    TextareaPlano1Semestre: {
                        validators: {
                            notEmpty: {
                                message: 'É obrigatório introduzir um Plano de Trabalho para o primeiro semestre'
                            },
                            stringLength: {
                                min: 50,
                                max:5000,
                                message: 'O Plano de Trabalho para o primeiro semestre deve conter entre 50 a 5000 caracteres',
                            }
                        }
                    },
                    TextareaPlano2Semestre: {
                        validators: {
                            notEmpty: {
                                message: 'É obrigatório introduzir um Plano de Trabalho para o segundo semestre'
                            },
                            stringLength: {
                                min: 50,
                                max:5000,
                                message: 'O Plano de Trabalho para o primeiro segundo deve conter entre 50 a 5000 caracteres',
                            }
                        }
                    },
                    TextareaCondicoes: {
                        validators: {
                            stringLength: {
                                max:5000,
                                message: 'O campo "Condições" deve conter no máximo 5000 caracteres',
                            }
                        }
                    },
                    TextareaElementosAdicionais: {
                        validators: {
                            stringLength: {
                                max:5000,
                                message: 'O campo "Condições" deve conter no máximo 5000 caracteres',
                            }
                        }
                    },

                    titEstagio: {
                        validators: {
                            notEmpty: {
                                message: 'É obrigatorio introduzir o titulo',
                            },
                            stringLength: {
                                min:16,
                                max:255,
                                message: 'O titulo tem de conter entre 16 a 255 caracteres',
                            },
                        },
                    },
                    radioCheckEntrevistas :{
                        validators: {
                            notEmpty: {
                                message: 'Deve selecionar uma das opções',
                            },
                        },
                    },

                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: 'is-invalid',
                        eleValidClass: 'is-valid'
                    })
                }
            }
        ));
        //step 2
        validations.push(FormValidation.formValidation(
            form,
            {
                autoFocus: true,
                excluded: [':disabled', ':hidden', ':not(:visible)'],
                fields: {
                    colab1: {
                        validators: {
                            callback: {
                                callback: function (input){
                                    let colab1_val = input['value'];
                                    if(!input['elements'][0]['required']) {
                                        return {valid: true};
                                    }
                                    if(colab1_val != '-1') {
                                        return {valid: true}
                                    }
                                    else {
                                        //.log("validating3");
                                        return {
                                            valid: false,
                                            message: "Deve selecionar pelo menos um Orientador"
                                        }
                                    }
                                },
                            },
                        },
                    },
                    colab2: {
                        validators: {
                            callback: {
                              callback: function (input){
                                  let colab1 = $("#colab1").val();
                                  let colab2 = $("#colab2").val(); // self
                                  let colab3 = $("#colab3").val();
                                  if(colab2 == colab3 || colab2 == colab1) {
                                      return {
                                          valid: false,
                                          message: "O segundo orientador deve ser diferente do primeiro"
                                      }
                                  }
                                  else {
                                      return {valid: true}
                                  }
                              },
                            },
                        },

                    },
                    colab3: {
                        validators: {
                            callback: {
                                callback: function (input){
                                    let colab1 = $("#colab1").val();
                                    let colab2 = $("#colab2").val(); // self
                                    let colab3 = $("#colab3").val();
                                    if(colab3 == colab2 || colab3 == colab1)
                                        return {
                                            valid: false,
                                            message: "O terceiro orientador deve ser diferente do primeiro e do segundo"
                                        }
                                    else return {valid: true}
                                },
                            },
                        },
                    },
                    inputEmailAluno: {
                        validators: {
                            stringLength: {
                                max: 255,
                                message: 'O email do aluno nao pode conter mais do 255 caracteres',
                            },
                            emailAddress: {
                                message: 'O email introduzido não é válido',
                            },
                            remote: {
                                message: 'O email que introduziu não é válido',
                                method: 'GET',
                                url: '/students/validate/',
                            },
                        },
                    },
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: 'is-invalid',
                        eleValidClass: 'is-valid'
                    })
                }
            }
        ));


    }

    return {
        // Public Functions
        init: function () {
            // Elements
            modalEl = document.querySelector('#kt_app_main');

            if (!modalEl) {
                return;
            }

            modal = new bootstrap.Modal(modalEl);

            stepper = document.querySelector('#kt_stepper_example_clickable');
            form = document.querySelector('#kt_stepper_example_form');
            formSubmitButton = stepper.querySelector('[data-kt-stepper-action="submit"]');
            formContinueButton = stepper.querySelector('[data-kt-stepper-action="next"]');

            initStepper();
            initForm();
            initValidation();
        }
    };
}();

var StartMasks = function () {
    //private functions, if any

    return {
        // Public Functions
        init: function () {

            $(".email_mask_dei").inputmask({
                mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@student.dei.uc.pt",
                greedy: false,
                onBeforePaste: function (pastedValue, opts) {
                    pastedValue = pastedValue.toLowerCase();
                    return pastedValue.replace("mailto:", "");
                },
                definitions: {
                    '*': {
                        validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
                        cardinality: 1,
                        casing: "lower"
                    }
                }
            });
            $(".email_mask").inputmask({
                mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
                greedy: false,
                onBeforePaste: function (pastedValue, opts) {
                    pastedValue = pastedValue.toLowerCase();
                    return pastedValue.replace("mailto:", "");
                },
                definitions: {
                    '*': {
                        validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
                        cardinality: 1,
                        casing: "lower"
                    }
                }
            });
            $(".phone_mask").inputmask("mask", {
                "mask": "999 999 999"
            });
            var floatingSelectAE2 = $('#floatingSelectAE2');
            var floatingSelectAE1 = $('#floatingSelectAE');
            function dynPE(){



                curso = $('#floatingSelectPE option:selected').attr('hidden-curso');
                var date_inicio_entrevistas = $('#floatingSelectPE option:selected').attr('data-date-inicio-entrevistas');
                var date_fim_entrevistas = $('#floatingSelectPE option:selected').attr('data-date-fim-entrevistas');
                $('#floatingInputDataFimEntrevistas').val(date_fim_entrevistas);
                $('#floatingInputDataInicioEntrevistas').val(date_inicio_entrevistas);
                $("#TextareaOpcaoTematicaTP").attr('is-hidden',true).hide();
                $('#floatingSelectAETP2').show();

                floatingSelectAE2.find('option').not(':nth-child(1)').remove();
                floatingSelectAE1.find('option').not(':nth-child(1)').remove();
                $.get('/queries/areas/'+curso, {}, function (data){
                    if(data.length == 0)
                        floatingSelectAE1.closest(".container-fluid").hide();
                    else
                        floatingSelectAE1.closest(".container-fluid").show();

                    for (const dataKey in data) {
                        var tema = data[dataKey];
                        let isText = !!tema['fillField'];
                        var opt;
                        if(parseInt(oldAE1) == tema['idopcaotematica']) {
                            oldAE1 = "";
                            opt = $('<option>')
                            .val(tema['idopcaotematica'])
                            .text(tema['nomeopcao'])
                            .attr({
                                'title': tema['shortdescricao'],
                                'hidden-desc': tema['descricao'],
                                'is-text': isText}
                                )
                            .prop("selected",true);

                            floatingSelectAE1.append(opt);
                            // opt.tooltip({
                            //     container: '#tooltip_container',
                            //     delay: { "show": 500, "hide": 100 },
                            //     title: tema['descricao'],
                            //     html: true,
                            //     placement: 'left',
                            //     fallbackPlacement: 'flip'
                            // });
                                
        
                            if(isText)  {
                                // $('#TextareaOpcaoTematica').val();
                                $('#TextareaOpcaoTematicaTP').show();
                            }
                        }
                        else {
                            opt = $('<option>')
                                .val(tema['idopcaotematica'])
                                .text(tema['nomeopcao'])
                                .attr({
                                    'title': tema['shortdescricao'],
                                    'hidden-desc': tema['descricao'],
                                    'is-text': isText}
                                    );

                            floatingSelectAE1.append(opt);
                            // opt.tooltip({
                            //     container: '#tooltip_container',
                            //     delay: { "show": 500, "hide": 100 },
                            //     title: tema['descricao'],
                            //     html: true,
                            //     placement: 'left',
                            //     fallbackPlacement: 'flip'
                            // });
                        }
                        if(parseInt(oldAE2) == tema['idopcaotematica']) {
                            oldAE2 = "";
                            opt =  $('<option>')
                                .val(tema['idopcaotematica'])
                                .text(tema['nomeopcao'])
                                .attr({
                                    'title': tema['shortdescricao'],
                                    'hidden-desc': tema['descricao'],
                                    'is-text': isText}
                                    )
                                .prop("selected", true);

                            floatingSelectAE2.append(opt);
                            // opt.tooltip({
                            //     delay: { "show": 500, "hide": 100 },
                            //     title: tema['descricao'],
                            //     html: true,
                            //     placement: 'left',
                            //     fallbackPlacement: 'flip'
                            // });
                        } else {
                            opt = $('<option>')
                            .val(tema['idopcaotematica'])
                            .text(tema['nomeopcao'])
                            .attr({
                                'title': tema['shortdescricao'],
                                'hidden-desc': tema['descricao'],
                                'is-text': isText}
                                );

                            floatingSelectAE2.append(opt);
                            // opt.tooltip({
                            //     delay: { "show": 500, "hide": 100 },
                            //     title: tema['descricao'],
                            //     html: true,
                            //     placement: 'left',
                            //     fallbackPlacement: 'flip'
                            // });
                    }
                    }
                });
                cursoInput = $("#floatingInputCurso");
                cursoInput.val(curso);
            }
            dynPE();
            $("#floatingSelectPE").change(function (){dynPE();});


        }
    };
}();
