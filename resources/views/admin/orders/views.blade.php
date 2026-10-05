<button type="button" class="btn btn-sm btn-primary float-lg-left" title="Pogledaj" data-tooltip="Pogledaj" data-toggle="modal" data-target="#order-{{ $orders->id }}"><i class="fa fa-eye"></i></button>
<!-- Modal -->
<div class="modal fade" id="order-{{ $orders->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 9999999999999">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Broj porudžbenice: {{ $orders->id }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" >
                    <h3>Detalji porudžbenice:</h3>
                    <tbody>
                    @foreach($orders->products as $item)
                        <tr>
                            <td colspan="2" width="100%;" style="background: #fff;">
                                <p><img src="{{ asset($item->product_image) }}" width="200"  class="img-fluid thumbnail center-block" alt=""></p>
                            </td>
                        </tr>
                        <tr>
                            <th>Naziv:</th>
                            <td align="right">{{ $item->product_name }}</td>
                        </tr>
                        <tr>
                            <th>Cena:</th>
                            <td align="right">{{ number_format($item->product_price, 2) }} RSD</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th>Količina:</th>
                        <td align="right">{{ $orders->order_qty }}</td>
                    </tr>
                    <tr>
                        <th>Ukupno:</th>
                        <td align="right"> <strong>{{ number_format($orders->order_amount,2) }}</strong> RSD</td>
                    </tr>
                    <tr>
                        <th> Status:</th>
                        <td align="right">
                            @if($orders->status == 0)
                                Neplaćena
                            @elseif($orders->status == 1)
                                Plaćena
                            @elseif($orders->status == 2)
                                Poništena
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th> Vreme poručivanja:</th>
                        <td align="right">
                            {{ $orders->created_at}}
                        </td>
                    </tr>
                    <tr>
                        <th>Vežbač:</th>
                        <td align="right"><a href="{{route('admin.users.edit',$orders->user->id)}}" target="_blank">( {{ $orders->user->id }} ) - {{ $orders->user->name }} {{ $orders->user->lastname }} </a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
            </div>
        </div>
    </div>
</div>
