@extends('layout')

@section('head-tags')
    <title>Детайли на заявка</title>
@endsection

@section('content')
    <div class="detail-request">
        <div class="container">
            <div class="page-nav">
                <div class="row align-items-center">
                    <div class="col-md-10">
                        <h1>
                            Детайли за {{$repairRequest->brand. ' '.$repairRequest->model. ' '. $repairRequest->year.'г.'}}
                        </h1>
                    </div>
                    @if(Auth::user()->role == 1)
                        <div class="col-md-2 text-right buttons">
                            <a href="{{route('edit.repair.request',$repairRequest->id)}}" class="edit" data-toggle="tooltip" data-placement="top" title="Редактирай">
                                <i class='bx bx-pencil'></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="info-box">
                @if(Auth::user()->role == 1)
                    <div class="user-info">
                        <div class="title">
                            Клиент:
                        </div>
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="subtitle">
                                    Име:
                                </div>
                                <div class="info">
                                    {{$repairRequest->user->name}}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="subtitle">
                                    Имейл:
                                </div>
                                <div class="info">
                                    {{$repairRequest->user->email}}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="subtitle">
                                    Име:
                                </div>
                                <div class="info">
                                    {{$repairRequest->user->phone}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="additional-info">
                    <div class="title">
                        Информация:
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="subtitle">
                                Коментар:
                            </div>
                            <div class="info">
                                {{$repairRequest->comment?$repairRequest->comment:'Няма информация'}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="subtitle">
                                Вероятен проблем:
                            </div>
                            <div class="info">
                                {{$repairRequest->probable_problem}}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="subtitle">
                                Вероятен проблем(според клинета):
                            </div>
                            <div class="info">
                                {{$repairRequest->client_problem_info?$repairRequest->client_problem_info:'Няма информация'}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="subtitle">
                                Служители които ще работят:
                            </div>
                            <div class="info">
                                {{$repairRequest->employees_required_info}}
                            </div>
                        </div>
                        @if(Auth::user()->role == 1)
                            <div class="col-md-6">
                                <div class="subtitle">
                                    Коментар до служители:
                                </div>
                                <div class="info">
                                    {{$repairRequest->employees_comment?$repairRequest->employees_comment:'Няма информация'}}
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <div class="subtitle">
                                Коментар до клиент:
                            </div>
                            <div class="info">
                                {{$repairRequest->user_comment?$repairRequest->user_comment:'Няма информация'}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="subtitle">
                                Сменени части:
                            </div>
                            <div class="info">
                                {{$repairRequest->changed_parts?$repairRequest->changed_parts:'Няма информация'}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="subtitle">
                                Време за завършване на работа:
                            </div>
                            <div class="info">
                                {{getRangeTimeInDays($repairRequest->time_to_complete)}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="price-info">
                    <div class="title">
                        Ценообразуване:
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="subtitle">
                                Части:
                            </div>
                            <div class="info parts-price">
                                {{number_format($repairRequest->parts_price, 2, ".", '') > 0 ? number_format($repairRequest->parts_price, 2, ".", '').'лв.' :'Няма начислена сума'}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="subtitle">
                                Труд:
                            </div>
                            <div class="info labor-price">
                                {{number_format($repairRequest->labor_price, 2, ".", '') > 0 ? number_format($repairRequest->labor_price, 2, ".", '').'лв.' :'Няма начислена сума'}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="subtitle">
                                Общo:
                            </div>
                            <div class="info total-price">
                                {{number_format($repairRequest->labor_price + $repairRequest->parts_price, 2, ".", '') > 0 ? number_format($repairRequest->labor_price + $repairRequest->parts_price, 2, ".", '').'лв.' :'Няма начислена сума'}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
