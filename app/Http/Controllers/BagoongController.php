<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bagoong;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use App\Events\UserLog;
use App\Notifications\DownloadNotification;

class BagoongController extends Controller
{
    public function index()
    {
        $bagoongs = Bagoong::all();
        return view('dashboard', compact('bagoongs'));
    }

    public function create()
    {
        return view('dashboard');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'flavor' => 'required',
            'size' => 'required',

        ]);



        // Create the bagoong
        $bagoong = Bagoong::create($data);

        $log_entry = Auth::user()->name . " added a bagoong ". '"' . $bagoong->name . '"';
        event(new UserLog($log_entry));

        return redirect()->route('dashboard');
    }

    public function destroy(Bagoong $bagoong)
    {
        // Delete the bagoong record here
        $bagoong->delete();
        $log_entry = Auth::user()->name . " deleted a bagoong ". '"' . $bagoong->name . '"';
        event(new UserLog($log_entry));

        return redirect()->route('bagoongs.index')->with('success', 'Bagoong deleted successfully.');
    }

    public function update(Request $request, Bagoong $bagoong)
    {
        // Get the current values of the bagoong before updating
        $oldName = $bagoong->name;
        $oldDescription = $bagoong->description;
        $oldPrice = $bagoong->price;
        $oldFlavor = $bagoong->flavor;
        $oldSize = $bagoong->size;



        // You can add similar lines for other fields as needed

        // Validate and update the bagoong's data here
        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'flavor' => $request->input('flavor'),
            'size' => $request->input('size'),

        ];


        $bagoong->update($data);

        $name_updated = false;
        $description_updated = false;
        $price_updated = false;
        $flavor_updated = false;
        $size_updated = false;




        // Create log entry for name update
        $log_entry_name = Auth::user()->name . " updated a bagoong name";
        if ($oldName !== $data['name']) {
            $log_entry_name .= ' from "' . $oldName . '" to "' . $data['name'] . '"';
            $name_updated = true;
        }

        // Create log entry for description update
        $log_entry_desc = Auth::user()->name . " updated a bagoong " . $bagoong->name . "'s " . "description";
        if ($oldDescription !== $data['description']) {
            $log_entry_desc .= ' from "' . $oldDescription . '" to "' . $data['description'] . '"';
            $description_updated = true;
        }

          // Create log entry for price update
          $log_entry_price = Auth::user()->name . " updated a bagoong " . $bagoong->name . "'s " .  "price";
          if ($oldPrice !== $data['price']) {
              $log_entry_price .= ' from "' . $oldPrice . '" to "' . $data['price'] . '"';
              $price_updated = true;
          }


        // Create log entry for description update
        $log_entry_flavor = Auth::user()->name . " updated a bagoong " . $bagoong->name . "'s " . "flavor";
        if ($oldFlavor !== $data['flavor']) {
            $log_entry_flavor .= ' from "' . $oldFlavor . '" to "' . $data['flavor'] . '"';
            $flavor_updated = true;
        }


         // Create log entry for description update
         $log_entry_size = Auth::user()->name . " updated a bagoong " . $bagoong->name . "'s " . "size";
         if ($oldSize !== $data['size']) {
             $log_entry_size .= ' from "' . $oldSize . '" to "' . $data['size'] . '"';
             $size_updated = true;
         }



          if ($name_updated) {
              event(new UserLog($log_entry_name));
          }
          if ($description_updated) {
              event(new UserLog($log_entry_desc));
          }
          if ($price_updated) {
              event(new UserLog($log_entry_flavor));
          }
          if ($flavor_updated) {
            event(new UserLog($log_entry_desc));
        }
        if ($size_updated) {
            event(new UserLog($log_entry_size));
        }




        return redirect()->route('bagoongs.index')->with('success', 'Bagoong updated successfully.');
    }


    public function download(Request $request, Bagoong $bagoong){
        $user = User::find(1); // Replace with your notifiable entity retrieval logic

        $user->notify(new DownloadNotification($bagoong));

        return redirect()->route('dashboard')->with('success', 'Thanks for downloading! Check your email for details.');

    }



}
