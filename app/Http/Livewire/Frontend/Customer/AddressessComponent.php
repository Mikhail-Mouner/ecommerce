<?php

namespace App\Http\Livewire\Frontend\Customer;

use App\Http\Livewire\Frontend\traits\SendSweetAlertTrait;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\UserAddress;
use Exception;
use Livewire\Component;

class AddressessComponent extends Component
{
    use SendSweetAlertTrait;

    public $show_form = false;
    public $edit_mode = false;
    public $address_id = null;
    public $addresses = null;
    public $address_title = null;
    public $default_address = null;
    public $first_name = null;
    public $last_name = null;
    public $email = null;
    public $mobile = null;
    public $address = null;
    public $address2 = null;
    public $country_id = null;
    public $state_id = null;
    public $city_id = null;
    public $zip_code = null;
    public $po_box = null;
    public $countries = [];
    public $states = [];
    public $cities = [];


    public function storeAddress()
    {
        $this->validate();
        try {

            $address = auth()->user()->addresses()->create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'mobile' => $this->mobile,
                'address' => $this->address,
                'address2' => $this->address2,
                'country_id' => $this->country_id,
                'state_id' => $this->state_id,
                'city_id' => $this->city_id,
                'address_title' => $this->address_title,
                'default_address' => $this->default_address,
                'zip_code' => $this->zip_code,
                'po_box' => $this->po_box,
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
        if ($this->default_address) {
            auth()->user()->addresses()->where('id', '!=', $address->id)->update(['default_address' => FALSE]);
        }
        $this->resetFormInputs('Address created successfully!');
    }

    public function updateAddress()
    {
        $this->validate();
        try {

            $address = auth()->user()->addresses()->where('id', $this->address_id)->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'mobile' => $this->mobile,
                'address' => $this->address,
                'address2' => $this->address2,
                'country_id' => $this->country_id,
                'state_id' => $this->state_id,
                'city_id' => $this->city_id,
                'address_title' => $this->address_title,
                'default_address' => $this->default_address,
                'zip_code' => $this->zip_code,
                'po_box' => $this->po_box,
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
        if ($this->default_address) {
            auth()->user()->addresses()->where('id', '!=', $this->address_id)->update(['default_address' => FALSE]);
        }
        $this->resetFormInputs('Address updated successfully!');
    }

    public function editAddress($id)
    {
        $address = UserAddress::find($id);
        $this->address_id = $address->id;
        $this->first_name = $address->first_name;
        $this->last_name = $address->last_name;
        $this->email = $address->email;
        $this->mobile = $address->mobile;
        $this->address = $address->address;
        $this->address2 = $address->address2;
        $this->country_id = $address->country_id;
        $this->state_id = $address->state_id;
        $this->city_id = $address->city_id;
        $this->address_title = $address->address_title;
        $this->default_address = $address->default_address;
        $this->zip_code = $address->zip_code;
        $this->po_box = $address->po_box;
        $this->edit_mode = true;
        $this->show_form = true;
    }

    public function deleteAddress($id)
    {
        $address = auth()->user()->addresses()->where('id', $id)->first();

        if ($address->default_address) {
            auth()->user()->addresses()->where('id', '!=', $address->id)->first()->update(['default_address' => true]);
        }

        $address->delete();
        $this->sendSweetAlert('success', 'Address Deleted Successfully!');
    }

    public function resetFormInputs($mssg = null)
    {
        $this->reset();
        $this->resetValidation();
        $this->show_form = false;
        $this->edit_mode = false;
        if (!is_null($mssg)) {
            $this->sendSweetAlert('success', $mssg);
        }
    }

    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'address' => 'required',
            'address2' => 'nullable',
            'country_id' => 'required|exists:App\Models\Country,id',
            'state_id' => 'required|exists:App\Models\State,id',
            'city_id' => 'required|exists:App\Models\City,id',
            'address_title' => 'required',
            'default_address' => 'required|boolean',
            'zip_code' => 'required',
            'po_box' => 'required',
        ];
    }

    public function render()
    {

        $this->addresses = auth()->user()->addresses;
        $this->countries = Country::Active()->get();
        $this->states = $this->country_id > 0 ? State::Active()->whereCountryId($this->country_id)->get() : [];
        $this->cities = $this->country_id > 0 ? City::Active()->whereStateId($this->state_id)->get() : [];

        return view(
            'livewire.frontend.customer.addressess-component',
            [
                'addresses' => auth()->user()->addresses,
                'countries' => $this->countries,
                'states' => $this->states,
                'cities' => $this->cities,
            ]
        );
    }
}
