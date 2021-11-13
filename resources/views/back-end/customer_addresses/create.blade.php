@extends('back-end.layouts.app')
@section('title','| New Customer Address')

@section('style')
    <style>
        .typeahead { z-index: 1051; }
    </style>
@endsection

@section('content')


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Customer Address</h1>

    <!-- DataTales  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-plus-circle"></i> Customer Address</h6>
            <div class="ml-auto">
                <a href="{{ route('backend.customer_address.index') }}" class="btn btn-primary btn-sm">
                    <span class="icon text-white-50"><i class="fa fa-arrow-alt-circle-left fa-fw"></i></span>
                    <span class="text">Back</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            @include('back-end.includes._alert')

            <form action="{{ route('backend.customer_address.store') }}" method="post" enctype="multipart/form-data"
                  autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="customer">Customer</label>
                            <input type="text" class="form-control typeahead"
                                   name="customer"
                                   id="customer"
                                   value="{{ old('customer') }}"
                                   data-provide="typeahead">
                            <input name="user_id" id="user_id" type="hidden" value="{{ old('user_id') }}">
                            @error('user_id')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="address_title">Address title</label>
                            <input type="text" name="address_title" value="{{ old('address_title') }}"
                                   class="form-control">
                            @error('address_title')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="default_address">Default address</label>
                            <select name="default_address" class="form-control">
                                <option value="0" {{ old('default_address') == '0' ? 'selected' : NULL }}>No</option>
                                <option value="1" {{ old('default_address') == '1' ? 'selected' : NULL }}>Yes</option>
                            </select>
                            @error('default_address')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="first_name">First name</label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="form-control">
                            @error('first_name')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="last_name">Last name</label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="form-control">
                            @error('last_name')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control">
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}" class="form-control">
                            @error('mobile')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="country_id">Country</label>
                            <select name="country_id" id="country_id" class="form-control">
                                <option value=""> ---</option>
                                @forelse($countries as $country)
                                    <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : NULL }}>{{ $country->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('country_id')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="state_id">State</label>
                            <select name="state_id" id="state_id" class="form-control">
                            </select>
                            @error('state_id')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="city_id">City</label>
                            <select name="city_id" id="city_id" class="form-control">
                            </select>
                            @error('city_id')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" name="address" value="{{ old('address') }}" class="form-control">
                            @error('address')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="address2">Address 2</label>
                            <input type="text" name="address2" value="{{ old('address2') }}" class="form-control">
                            @error('address2')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="zip_code">ZIP code</label>
                            <input type="text" name="zip_code" value="{{ old('zip_code') }}" class="form-control">
                            @error('zip_code')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="po_box">P.O.Box</label>
                            <input type="text" name="po_box" value="{{ old('po_box') }}" class="form-control">
                            @error('po_box')
                            <div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">
                        <span class="icon text-white-50"><i class="fa fa-check fa-fw"></i></span>
                        <span class="text">Add Address</span>
                    </button>
                </div>
            </form>


        </div>
    </div>



@endsection
@push('script')
    <script src="{{ asset('js/typehead.js') }}"></script>
    <script>
        $('.typeahead').typeahead({
            autoSelect: true,
            minLength: 3,
            displayText: function (item) {
                return item.full_name + " - " + item.email
            },
            source: function (query, process) {
                return $.get("{{ route('backend.customer.get_customer') }}", {'query': query}, function (data) {
                    return process(data)
                })
            },
            afterSelect: function (data) {
                $('#user_id').val(data.id)
                $('#first_name').val(data.first_name)
                $('#last_name').val(data.last_name)
                $('#email').val(data.email)
                $('#mobile').val(data.phone)
            }
        })

        $('#country_id').change(function () {
            populateStates();
            populateCities();
        })
        $('#state_id').change(function () {
            populateCities();
        })

        function populateStates() {
            let country_id_val = $('#country_id').val() != null ? $('#country_id').val() : '{{ old('country_id') }}'
            $.get("{{ route('backend.states.get_states') }}", {country_id: country_id_val}, function (data) {
                $('option', $('#state_id')).remove();
                $('#state_id').append($('<option></option>').val('').html(' --- '));
                $.each(data, function (val, text) {
                    let selectedVal = text.id == '{{ old('state_id') }}' ? 'selected' : '';
                    $('#state_id').append($('<option ' + selectedVal + '></option>').val(text.id).html(text.name));
                });
            }, "json")
        }

        function populateCities() {
            let stateIdVal = $('#state_id').val() != null ? $('#state_id').val() : '{{ old('state_id') }}';
            $.get("{{ route('backend.cities.get_cities') }}", {state_id: stateIdVal}, function (data) {
                $('option', $("#city_id")).remove();
                $("#city_id").append($('<option></option>').val('').html(' --- '));
                $.each(data, function (val, text) {
                    let selectedVal = text.id == '{{ old('city_id') }}' ? "selected" : "";
                    $("#city_id").append($('<option ' + selectedVal + '></option>').val(text.id).html(text.name));
                });
            }, "json");
        }

        populateStates();
        populateCities();
    </script>
@endpush