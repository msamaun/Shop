<?php

namespace App\Http\Controllers;

use App\Models\CustomerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CustomerProfileController extends Controller
{
  public function userProfile(Request $request)
  {
      $user_id = Auth::id();
      $cus_name = $request->input('cus_name');
      $cus_address = $request->input('cus_add');
      $cus_city = $request->input('cus_city');
      $cus_state = $request->input('cus_state');
      $cus_country = $request->input('cus_country');
      $cus_zip = $request->input('cus_postcode');
      $cus_phone = $request->input('cus_phone');
      $cus_fax = $request->input('cus_fax');

      $ship_name = $request->input('ship_name');
      $ship_address = $request->input('ship_add');
      $ship_city = $request->input('ship_city');
      $ship_state = $request->input('ship_state');
      $ship_country = $request->input('ship_country');
      $ship_zip = $request->input('ship_postcode');
      $ship_phone = $request->input('ship_phone');

      return CustomerProfile::updateOrCreate([
          'user_id' => $user_id,
          'cus_name' => $cus_name,
          'cus_add' => $cus_address,
          'cus_city' => $cus_city,
          'cus_state' => $cus_state,
          'cus_country' => $cus_country,
          'cus_postcode' => $cus_zip,
          'cus_phone' => $cus_phone,
          'cus_fax' => $cus_fax,

          'ship_name' => $ship_name,
          'ship_add' => $ship_address,
          'ship_city' => $ship_city,
          'ship_state' => $ship_state,
          'ship_country' => $ship_country,
          'ship_postcode' => $ship_zip,
          'ship_phone' => $ship_phone
          ]);

  }
}
