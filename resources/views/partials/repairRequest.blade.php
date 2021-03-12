<div class="table-responsive loaderWrapper">
    <div class="loader">
        <div class="lds-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    @if(count($tableInfo)>0)
        <table class="custom-table">
            <thead>
            <tr>
                <th>#</th>
                <th>{{Auth::user()->role == 1 ?'Потребител':'Кола'}}</th>
                <th>Статус</th>
                <th>Време за завършване</th>
                <th>Обща цена</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($tableInfo as $item)
                <tr class="hover-effect">
                    <td>{{$item->id}}</td>
                    <td>
                        {{Auth::user()->role == 1 ?$item->user->name:$item->brand. ' ' .$item->model . ' '. $item->year.'г.'}}
                    </td>
                    @if(Auth::user()->role == 1)
                        <td class="jsEditStatus" data-id="{{$item->id}}" data-statusId="{{$item->status_id}}">
                    @else
                        <td>
                            @endif
                            <div class="statusLabel {{$item->status->label == 'Изчакване' ? 'await':($item->status->label == 'Ремонтиране'?'inProcess':'completed')}}"
                            @if(Auth::user()->role == 1)
                            data-toggle="tooltip" data-placement="top" title="Бърза редакция"
                                @endif>
                                <div class="iconHolder">
                                    <i class="bx {{$item->status->label == 'Изчакване' ? 'bx-hourglass'
:($item->status->label == 'Ремонтиране'?'bx-wrench':'bx-check')}}"></i>
                                </div>
                                <div class="status">
                                    {{$item->status->label}}
                                </div>
                            </div>
                        </td>
                        <td>
                            {{getRangeTimeInDays($item->time_to_complete)}}
                        </td>
                        <td class="{{number_format($item->parts_price + $item->labor_price, 2, ".", '') > 0 ? 'price':''}}">
                            {{number_format($item->parts_price + $item->labor_price, 2, ".", '') > 0 ? number_format($item->parts_price + $item->labor_price, 2, ".", '').'лв.' :'Няма начислена сума'}}
                        </td>
                        <td class="buttons">
                            @if(Auth::user()->role == 1)
                                <a href="{{route('edit.repair.request',$item->id)}}" class="edit" data-toggle="tooltip" data-placement="top" title="Редактирай">
                                    <i class='bx bx-pencil'></i>
                                </a>
                            @endif
                            <a href="{{route('detail.repair.request',$item->id)}}" class="detail" data-toggle="tooltip" data-placement="top" title="Виж детайли">
                                <i class='bx bx-search'></i>
                            </a>
                            @if(Auth::user()->role == 1)
                                <a class="delete" data-id="{{$item->id}}" data-toggle="tooltip" data-placement="top" title="Изтрий">
                                    <i class='bx bx-x'></i>
                                </a>
                            @endif
                        </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$tableInfo->links('pagination.default')}}
    @else
        <div class="alert alert-info">
            Няма намерена ифнормация.
        </div>
    @endif
</div>
