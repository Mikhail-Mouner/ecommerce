<div x-data="{formShow: @entangle('show_form') }">
    <div class="d-flex">
        <h2 class="h5 text-uppercase mb-4">Addresses</h2>
        <div class="ml-auto">
            <button type="button" class="btn btn-primary rounded shadow" @click="formShow= true">
                <i class="fa fa-plus fa-fw"></i> New
                Address
            </button>
        </div>
    </div>
    <form x-show="formShow" action="#" method="post" @click.away="formShow= false"
        wire:submit.prevent="{{ $edit_mode ? 'updateAddress' : 'storeAddress' }}">
        @if ($edit_mode)
            @method('PUT')
            <input type="hidden" name="address_id" value="{{ $address_id }}">
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        @endif
        <div class="row">
            <div class="col-lg-8 form-group">
                <label class="text-small text-uppercase" for="address_title">Address title</label>
                <input class="form-control" wire:model="address_title" type="text"
                    placeholder="Enter your address title">
                @error('address_title')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="col-lg-4 form-group">
                <label class="text-small text-uppercase">&nbsp;</label>
                <div class="form-check">
                    <input class="form-check-input" id="default_address" wire:model="default_address" type="checkbox"
                        value="1" {{ $default_address?'checked':null}}>
                    <label class="form-check-label" for="default_address">Default address?</label>
                </div>
            </div>
            <div class="col-lg-6 form-group">
                <label class="text-small text-uppercase" for="first_name">First name</label>
                <input class="form-control form-control-lg" wire:model="first_name" type="text"
                    placeholder="Enter your first name">
                @error('first_name')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label class="text-small text-uppercase" for="last_name">Last name</label>
                <input class="form-control form-control-lg" wire:model="last_name" type="text"
                    placeholder="Enter your last name">
                @error('last_name')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label class="text-small text-uppercase" for="email">Email address</label>
                <input class="form-control form-control-lg" wire:model="email" type="email"
                    placeholder="e.g. Jason@example.com">
                @error('email')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label class="text-small text-uppercase" for="mobile">Mobile number</label>
                <input class="form-control form-control-lg" wire:model="mobile" type="tel"
                    placeholder="e.g. 966512345678">
                @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
            </div>

            <div class="col-lg-6 form-group">
                <label class="text-small text-uppercase" for="address">address</label>
                <input class="form-control form-control-lg" wire:model="address" type="text"
                    placeholder="Enter your first name">
                @error('address')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label class="text-small text-uppercase" for="address2">address2</label>
                <input class="form-control form-control-lg" wire:model="address2" type="text"
                    placeholder="Enter your last name">
                @error('address2')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="col-lg-4 form-group">
                <label class="text-small text-uppercase" for="country_id">Country</label>
                <select class="form-control form-control-lg" wire:model="country_id">
                    <option value="">Select Country</option>
                    @forelse($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @empty
                    @endforelse
                </select>
                @error('country_id')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="col-lg-4 form-group">
                <label class="text-small text-uppercase" for="state_id">State</label>
                <select class="form-control form-control-lg" wire:model="state_id">
                    <option value="">Select State</option>
                    @forelse($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @empty
                    @endforelse
                </select>
                @error('state_id')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="col-lg-4 form-group">
                <label class="text-small text-uppercase" for="city_id">City</label>
                <select class="form-control form-control-lg" wire:model="city_id">
                    <option value="">Select City</option>
                    @forelse($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @empty
                    @endforelse
                </select>
                @error('city_id')<span class="text-danger">{{ $message }}</span>@enderror
            </div>

            <div class="col-lg-6 form-group">
                <label class="text-small text-uppercase" for="zip_code">ZIP Code</label>
                <input class="form-control form-control-lg" wire:model="zip_code" type="text"
                    placeholder="Enter your first name">
                @error('zip_code')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="col-lg-6 form-group">
                <label class="text-small text-uppercase" for="po_box">P.O.Box</label>
                <input class="form-control form-control-lg" wire:model="po_box" type="text"
                    placeholder="Enter your last name">
                @error('po_box')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="col-lg-12 form-group">
                <button class="btn btn-dark" type="submit">
                    {{ $edit_mode ? 'Update Address' : 'Add Address' }}
                </button>
            </div>
        </div>

    </form>
    <div class="my-4">
        <table class="table table-striped table-inverse table-responsive w-100">
            <thead class="thead-inverse">
                <tr>
                    <th>Address Title</th>
                    <th>Default</th>
                    <th class="col-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($addresses as $address)

                    <tr>
                        <td scope="row">{{ $address->address_title }}</td>
                        <td>{{ $address->default_address ? 'Default Address' : '-' }}</td>
                        <td class="text-right">
                            <button type="button" wire:click.prevent="editAddress('{{ $address->id }}')"
                                class="btn btn-success btn-sm rounded-lg">
                                <i class="fa fa-edit fa-fw"></i>
                            </button>
                            <button type="button" wire:click.prevent="deleteAddress('{{ $address->id }}')"
                                class="btn btn-danger btn-sm rounded-lg">
                                <i class="fa fa-trash fa-fw"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No Address Found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
