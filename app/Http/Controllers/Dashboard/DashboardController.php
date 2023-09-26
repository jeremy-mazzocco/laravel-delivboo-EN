<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Type;
use App\Models\Dish;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Termwind\Components\Dd;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.section.home-user');
    }

    public function show()
    {
        return view('dashboard.section.dish-show');
    }

    public function create()
    {
        $types = Type::all();

        return view('dashboard.section.dish-create', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(
            $this->getValidations(),
            $this->getValidationMessages()
        );

        if (array_key_exists('img', $data) && $data['img'] !== null) {
            $img_path = Storage::put('uploads', $data['img']);
        } else {
            $img_path = null;
        }
        $data['img'] = $img_path;

        $userId = Auth::user()->id;
        $data['user_id'] = $userId;

        $dish = Dish::create($data);

        return redirect()->route('dish.show');
    }

    public function edit($id)
    {
        $dish = Dish::findOrFail($id);
        return view('dashboard.section.dish-edit', compact('dish'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(
            $this->getValidations(),
            $this->getValidationMessages()
        );

        $dish = Dish::findOrFail($id);

        $oldImgPath = $dish->img;

        if (!array_key_exists("img", $data)) {
            $data['img'] = $oldImgPath;
        } else {
            if ($dish->img) {
                Storage::delete($oldImgPath);
            }
            $newImgPath = Storage::put('uploads', $data['img']);
            $data['img'] = $newImgPath;
        }

        $dish->update($data);

        return redirect()->route('dish.show');
    }

    public function changeDeleted($id)
    {
        $dish = Dish::findOrFail($id);
        $dish['deleted'] = !$dish['deleted'];

        $dish->save();
        return redirect()->route('dish.show');
    }

    public function deleteImg($id)
    {
        $dish = Dish::findOrFail($id);
        $img_path = $dish->img;

        if ($img_path) {
            Storage::delete($img_path);
        }

        $dish->img = null;
        $dish->save();
        return back();
    }

    public function showOrders($id)
    {
        $orders = Order::with('dishes')
            ->whereHas('dishes', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->get();

        return view('dashboard.section.orders-show', compact('orders'));
    }
    
    public function showStatistics($id)
    {
        $orders = Order::with('dishes')
            ->whereHas('dishes', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->get();

        $dailyTotals = array_fill(1, 31, 0);

        foreach ($orders as $order) {
            $dayOfMonth = (int)$order->created_at->format('d');
            $total = $order->total_price;
            $dailyTotals[$dayOfMonth] += $total;
        }

        return view('dashboard.section.statistics', compact('dailyTotals', 'orders'));
    }



    // Validation Functions

    private function getValidations()
    {
        return [
            'dish_name' => ['required', 'min:2', 'max:64'],
            'description' => ['max:1275'],
            'price' => ['required', 'numeric', 'min:0'],
            'img' => ['image', 'mimes:jpeg,png,jpg'],
            'visibility' => ['required']
        ];
    }

    private function getValidationMessages()
    {
        return [
            'dish_name.required' => 'Dish name is required.',
            'dish_name.min' => 'Dish name must be at least 2 characters long.',
            'dish_name.max' => 'Dish name cannot exceed 64 characters.',
            'description.max' => 'Description cannot exceed 1275 characters.',
            'price.required' => 'Dish price is required.',
            'price.numeric' => 'Dish price must be a number.',
            'price.min' => 'Dish price cannot be negative.',
            'img.image' => 'The file must be a valid image.',
            'img.mimes' => 'The image file must be of type JPEG, PNG, or JPG.',
            'visibility.required' => 'Dish visibility is required.'
        ];
    }
}
