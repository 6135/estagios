@extends('base.default')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@stop

@section('content')

    <div class="main-page row ">
        <div class="col-md-5 px-0" style="margin-bottom: 5rem">
            {{-- <span class="home_page"> --}}
            <div class="card border-0">
                <h5 class="card-title header-text-1">{{ __('proposal.proposal_add') }} &nbsp; <a href="#"
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasNovaPropostaDocente" aria-controls="offcanvas"><i
                            class="bi bi-pencil-square"></i></a></h5>
                <div class="card-body">
                </div>
            </div>
            {{-- </span> --}}
        </div>
        {{-- <div class="col-sm-3"></div> --}}
        <div class="col-sm px-0 " style="margin-bottom: 5rem">
            {{-- @include('layouts.home.contacts') --}}
        </div>
    </div>

@stop

@section('offcanvas')
    @include('layouts.docente.offcanvas-proposta')
@stop

@section('scripts')
<script src="{{ asset('js/bs-maxlength/bootstrap-maxlength.min.js') }}" crossorigin="anonymous"></script>
    <script>
        const locale = '{{ config('app.locale') }}';
        const localizedMessages = {
            //edicao_estagio_id required
            edicao_estagio_id: {
                required: "{{ __('validation.required', ['attribute' => trans_choice('proposal.fields.period',1)]) }}",
            },
            titulo: {
                //required and between 16 and 255 chars
                required: "{{ __('validation.required', ['attribute' => __('proposal.fields.title')]) }}",
                between: "{{ __('validation.between.string', ['attribute' => __('proposal.fields.title'), 'min' => 16, 'max' => 255]) }}",
            },
            enquadramento: {
                //required, max 5000 chars
                required: "{{ __('validation.required', ['attribute' => __('proposal.fields.context')]) }}",
                between: "{{ __('validation.between.string', ['attribute' => __('proposal.fields.context'), 'min' => 256, 'max' => 5000]) }}",
            },
            objetivos: {
                //required, max 5000 chars
                required: "{{ __('validation.required', ['attribute' => __('proposal.fields.objectives')]) }}",
                between: "{{ __('validation.between.string', ['attribute' => __('proposal.fields.objectives'), 'min' => 256, 'max' => 5000]) }}",
            },
            plano1: {
                //required, max 5000 chars
                required: "{{ __('validation.required', ['attribute' => __('proposal.fields.workplan1')]) }}",
                between: "{{ __('validation.between.string', ['attribute' => __('proposal.fields.workplan1'), 'min' => 256, 'max' => 5000]) }}",
            },
            plano2: {
                //required, max 5000 chars
                required: "{{ __('validation.required', ['attribute' => __('proposal.fields.workplan2')]) }}",
                between: "{{ __('validation.between.string', ['attribute' => __('proposal.fields.workplan2'), 'min' => 256, 'max' => 5000]) }}",
            },
            condicoes: {
                //required, max 5000 chars
                between: "{{ __('validation.max.string', ['attribute' => __('proposal.fields.conditions'), 'max' => 5000]) }}",
            },
            observacoes: {
                //required, max 5000 chars
                between: "{{ __('validation.max.string', ['attribute' => __('proposal.fields.observations'),'max' => 5000]) }}",
            },
            utilizador_email: {
                email: "{{ __('validation.email', ['attribute' => __('proposal.fields.identified_student')]) }}",
                endswith: "{{ __('validation.ends_with', ['attribute' => __('proposal.fields.identified_student'), 'values' => '\"@student.dei.uc.pt\"']) }}",
                exist: "{{ __('validation.exists_in', ['attribute' => __('proposal.fields.identified_student')]) }}",
            }
            
        };
    </script>
    <script src="{{ asset('js/pages/docente/propostasDocente.js') }}" crossorigin="anonymous"></script>

    <script>
        toastr.options.closeButton = true;
        toastr.options.closeMethod = 'fadeOut';
        toastr.options.closeDuration = 1000;
        toastr.options.closeEasing = 'swing';
        toastr.options.newestOnTop = false;
        toastr.options.preventDuplicates = true;
        toastr.options.progressBar = true;
        toastr.options.showDuration = 10;
        toastr.options.hideDuration = 10;
    </script>
    <script src="{{ asset('js/pages/validateStudentEmail.js') }}" crossorigin="anonymous"></script>
    <script>
        //check if document ready
        $(document).ready(function() {
            /*
            *@see https://github.com/mimo84/bootstrap-maxlength
            */
            $('[maxlength]').maxlength({
                alwaysShow: true,
                showOnReady: true,
                appendToParent: true,
            });



            var especializacao_nome1 = $('#especializacao_nome1');
            var especializacao_nome2 = $('#especializacao_nome2');
            var edicao_estagio_id = $('#edicao_estagio_id');
            let updateFromEdicao = function(edicao_estagio_id_value) {
                if (edicao_estagio_id_value != null && edicao_estagio_id_value != "") {
                    $.ajax({
                        url: $('#edicao_estagio_id').attr('data-target-location') + '/' +
                            edicao_estagio_id_value,
                        dataType: 'json',
                        delay: 250,
                        success: function(data) {
                            var results = [];
                            //remove all options except hidden ones
                            especializacao_nome1.find('option').not('[disabled]').remove();
                            especializacao_nome2.find('option').not('[disabled]').remove();

                            data['message'].forEach(element => {
                                especializacao_nome1.append($('<option>', {
                                    value: element.nome,
                                    text: element.nome
                                }));
                                especializacao_nome2.append($('<option>', {
                                    value: element.nome,
                                    text: element.nome
                                }));

                            });
                            //add data to select especializacao_nome1 and especializacao_nome2 no select2


                        },
                    });
                }
            }
            //check if edicao_estagio_id is selected
            if (edicao_estagio_id.val() != null && edicao_estagio_id.val() != "") {
                //get selected value
                console.log(edicao_estagio_id.val());
                var edicao_estagio_id_value = edicao_estagio_id.val();
                especializacao_nome1.find('option').eq(0).prop('selected', false);
                especializacao_nome2.find('option').eq(0).prop('selected', false);
                especializacao_nome1.find('option').eq(1).prop('selected', true);
                especializacao_nome2.find('option').eq(1).prop('selected', true);
                //get data from ajax
                updateFromEdicao(edicao_estagio_id_value);
                //unselect first option and select second option via jquery

            }
            edicao_estagio_id.on('change', function(event) {
                //get selected value
                var edicao_estagio_id_value = $(this).val();
                //unselect first option and select second option via jquery
                especializacao_nome1.find('option').eq(0).prop('selected', false);
                especializacao_nome2.find('option').eq(0).prop('selected', false);
                especializacao_nome1.find('option').eq(1).prop('selected', true);
                especializacao_nome2.find('option').eq(1).prop('selected', true);
                //get data from ajax
                updateFromEdicao(edicao_estagio_id_value);


            });


        });
    </script>
@stop
