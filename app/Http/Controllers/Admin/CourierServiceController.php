<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourierService;

class CourierServiceController extends Controller
{
    public function index()
    {
        $courierServices = CourierService::orderBy('name')->paginate(15);
        return view('admin.courier-services.index', compact('courierServices'));
    }

    public function create()
    {
        return view('admin.courier-services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:courier_services,code',
            'contact_phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:1000',
            'base_charge' => 'required|numeric|min:0',
            'inside_dhaka_charge' => 'required|numeric|min:0',
            'outside_dhaka_charge' => 'required|numeric|min:0',
            'delivery_days_inside' => 'required|integer|min:1',
            'delivery_days_outside' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        CourierService::create($request->all());

        return redirect()->route('admin.courier-services.index')
            ->with('success', 'Courier service created successfully.');
    }

    public function show(CourierService $courierService)
    {
        return view('admin.courier-services.show', compact('courierService'));
    }

    public function edit(CourierService $courierService)
    {
        return view('admin.courier-services.edit', compact('courierService'));
    }

    public function update(Request $request, CourierService $courierService)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:courier_services,code,'.$courierService->id,
            'contact_phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:1000',
            'base_charge' => 'required|numeric|min:0',
            'inside_dhaka_charge' => 'required|numeric|min:0',
            'outside_dhaka_charge' => 'required|numeric|min:0',
            'delivery_days_inside' => 'required|integer|min:1',
            'delivery_days_outside' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $courierService->update($request->all());

        return redirect()->route('admin.courier-services.index')
            ->with('success', 'Courier service updated successfully.');
    }

    public function destroy(CourierService $courierService)
    {
        // Check if courier service is being used by any special orders
        if ($courierService->specialOrders()->exists()) {
            return redirect()->route('admin.courier-services.index')
                ->with('error', 'Cannot delete courier service. It is being used by special orders.');
        }

        $courierService->delete();

        return redirect()->route('admin.courier-services.index')
            ->with('success', 'Courier service deleted successfully.');
    }

    public function toggleStatus(CourierService $courierService)
    {
        $courierService->update(['is_active' => !$courierService->is_active]);
        
        $status = $courierService->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Courier service {$status} successfully.");
    }
}
