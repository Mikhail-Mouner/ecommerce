<div x-data="{showOrder: @entangle('show_order')}">
    <div class="d-flex">
        <h2 class="h5 text-uppercase mb-4">Orders</h2>
    </div>

    <div class="my-4">
        <table class="table table-striped table-inverse table-responsive w-100">
            <thead class="thead-inverse">
                <tr>
                    <th>Order Ref.</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="col-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td scope="row">{{ $order->ref_id }}</td>
                        <td>{{ "{$order->total} {$order->currency}" }}</td>
                        <td>{!! $order->statusWithLabel() !!}</td>
                        <td>{{ $order->created_at->diffForHumans() }}</td>
                        <td class="text-right">
                            <button type="button" wire:click.prevent="dispalyOrder({{ $order->id }})"
                                @click="showOrder = true" class="btn btn-primary btn-sm rounded-lg">
                                <i class="fa fa-eye fa-fw"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No Order Found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="my-4 border rounded shadow px-4" x-show="showOrder">
        <div class="row">
            @if (!is_null($order_details))

                <div class="col-md-12">
                    <div class="table-responsive mb-4">
                        <table class="table">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0" scope="col"><strong
                                            class="text-small text-uppercase">Product</strong></th>
                                    <th class="border-0" scope="col"><strong
                                            class="text-small text-uppercase">Price</strong></th>
                                    <th class="border-0" scope="col"><strong
                                            class="text-small text-uppercase">Quantity</strong></th>
                                    <th class="border-0" scope="col"><strong
                                            class="text-small text-uppercase">Total</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order_details->products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $order_details->currency . ' ' . number_format($product->price, 2) }}
                                        </td>
                                        <td>{{ $product->pivot->quantity }}</td>
                                        <td>{{ $order_details->currency . ' ' . number_format($product->price * $product->pivot->qty, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Subtotal</strong></td>
                                    <td>{{ $order_details->currency . ' ' . number_format($order_details->subtotal, 2) }}
                                    </td>
                                </tr>
                                @if (!is_null($order_details->discount_code))
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Discount
                                                (<small>{{ $order_details->discount_code }}</small>)</strong></td>
                                        <td>{{ $order_details->currency . ' ' . number_format($order_details->discount, 2) }}
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Tax</strong></td>
                                    <td>{{ $order_details->currency . ' ' . number_format($order_details->tax, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Shipping</strong></td>
                                    <td>{{ $order_details->currency . ' ' . number_format($order_details->shipping, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Amount</strong></td>
                                    <td>{{ $order_details->currency . ' ' . number_format($order_details->total, 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">

                    <h2 class="h5 text-uppercase">Transactions</h2>
                    <div class="table-responsive mb-4">
                        <table class="table">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0" scope="col"><strong
                                            class="text-small text-uppercase">Transaction</strong></th>
                                    <th class="border-0" scope="col"><strong
                                            class="text-small text-uppercase">Date</strong></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order_details->transactions as $transaction)
                                    <tr>
                                        <td><span class="badge badge-info">{{ $transaction->status() }}</span></td>
                                        <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            @if ($loop->last && $transaction->isTransactionFinished() && $transaction->canReturnOrder())
                                                <button type="button"
                                                    wire:click="requestReturnOrder('{{ $order_details->id }}')"
                                                    class="btn btn-link text-right">
                                                    you can return order in
                                                    {{ config('general.return_days') - $transaction->created_at->diffInDays() }} days
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

            @endisset
            <div class="col-md-12">
                <button type="button" @click="showOrder = false"
                    class="btn btn-outline-danger btn-lg btn-block">Close</button>
            </div>
    </div>
</div>
</div>
