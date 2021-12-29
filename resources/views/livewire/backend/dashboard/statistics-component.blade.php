<div class="row">

    @foreach ($earning as $key => $statistic)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-{{ $statistic['color'] }} shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-{{ $statistic['color'] }} text-uppercase mb-1">
                                {{ $statistic['label'] }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ ($statistic['is_price'])? "{$statistic['total']} EGP":$statistic['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="{{ $statistic['icon'] }} fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
