<div class="card-body">
    <form action="{{ route('backend.order.index') }}" method="get" autocomplete="off">
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <input type="text" name="keyword" value="{{ old('keyword', request()->input('keyword')) }}" class="form-control" placeholder="Search here">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <select name="status" class="form-control">
                        <option value="">---</option>
                        <option value="0" {{ old('status', request()->input('status')) == '0' ? 'selected' : NULL }}>NEW ORDER</option>
                        <option value="1" {{ old('status', request()->input('status')) == '1' ? 'selected' : NULL }}>PAYMENT COMPLETED</option>
                        <option value="2" {{ old('status', request()->input('status')) == '2' ? 'selected' : NULL }}>UNDER PROCESS</option>
                        <option value="3" {{ old('status', request()->input('status')) == '3' ? 'selected' : NULL }}>FINISHED</option>
                        <option value="4" {{ old('status', request()->input('status')) == '4' ? 'selected' : NULL }}>REJECTED</option>
                        <option value="5" {{ old('status', request()->input('status')) == '5' ? 'selected' : NULL }}>CANCELED</option>
                        <option value="6" {{ old('status', request()->input('status')) == '6' ? 'selected' : NULL }}>REFUNDED REQUEST</option>
                        <option value="8" {{ old('status', request()->input('status')) == '7' ? 'selected' : NULL }}>RETURNED</option>
                        <option value="7" {{ old('status', request()->input('status')) == '8' ? 'selected' : NULL }}>REFUNDED</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <select name="sort_by" class="form-control">
                        <option value="">---</option>
                        <option value="id" {{ old('sort_by', request()->input('sort_by')) == 'id' ? 'selected' : '' }}>ID</option>
                        <option value="ref_id" {{ old('sort_by', request()->input('sort_by')) == 'ref_id' ? 'selected' : '' }}>Ref. ID</option>
                        <option value="total" {{ old('sort_by', request()->input('sort_by')) == 'total' ? 'selected' : '' }}>Amount</option>
                        <option value="created_at" {{ old('sort_by', request()->input('sort_by')) == 'created_at' ? 'selected' : '' }}>Created At</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <select name="order_by" class="form-control">
                        <option value="">---</option>
                        <option value="asc" {{ old('order_by', request()->input('order_by')) == 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ old('order_by', request()->input('order_by')) == 'desc' ? 'selected' : '' }}>Descending</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <select name="limit_by" class="form-control">
                        <option value="">---</option>
                        <option value="10" {{ old('limit_by', request()->input('limit_by')) == '10' ? 'selected' : '' }}>10</option>
                        <option value="20" {{ old('limit_by', request()->input('limit_by')) == '20' ? 'selected' : '' }}>20</option>
                        <option value="50" {{ old('limit_by', request()->input('limit_by')) == '50' ? 'selected' : '' }}>50</option>
                        <option value="100" {{ old('limit_by', request()->input('limit_by')) == '100' ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <button type="submit" name="submit" value="search" class="btn btn-link">Search</button>
                </div>
            </div>
        </div>
    </form>
</div>
