<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource with advanced filters
     */
    public function index(Request $request)
    {
        $query = InventoryItem::with(['creator', 'updater', 'movements']);

        // Advanced Filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'in_stock':
                    $query->where('quantity', '>', 0);
                    break;
                case 'low_stock':
                    $query->where('quantity', '>', 0)->where('quantity', '<', 10);
                    break;
                case 'out_of_stock':
                    $query->where('quantity', '<=', 0);
                    break;
            }
        }

        if ($request->filled('quantity_min')) {
            $query->where('quantity', '>=', $request->quantity_min);
        }

        if ($request->filled('quantity_max')) {
            $query->where('quantity', '<=', $request->quantity_max);
        }

        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->amount_min);
        }

        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->amount_max);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['name', 'quantity', 'amount', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }

        $items = $query->paginate(15)->withQueryString();

        // Statistics
        $stats = [
            'total_items' => InventoryItem::count(),
            'in_stock' => InventoryItem::where('quantity', '>', 0)->count(),
            'low_stock' => InventoryItem::where('quantity', '>', 0)->where('quantity', '<', 10)->count(),
            'out_of_stock' => InventoryItem::where('quantity', '<=', 0)->count(),
            'total_value' => InventoryItem::sum(DB::raw('quantity * amount')),
        ];

        return view('module.inventory.index', compact('items', 'stats'));
    }

    /**
     * Store a newly created resource in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:0'],
            'amount' => ['required', 'numeric', 'min:0.01'],
        ], [
            'amount.min' => 'Amount must be a positive number.',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['created_by'] = Auth::id();
            $data['updated_by'] = Auth::id();

            $item = InventoryItem::create($data);

            // Create initial movement record
            InventoryMovement::create([
                'inventory_item_id' => $item->id,
                'user_id' => Auth::id(),
                'change_qty' => $request->quantity,
                'reason' => 'Initial stock entry',
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Inventory item created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error creating inventory item: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage
     */
    public function update(Request $request, InventoryItem $inventory)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0.01'],
        ], [
            'amount.min' => 'Amount must be a positive number.',
        ]);

        try {
            $data = $request->all();
            $data['updated_by'] = Auth::id();

            $inventory->update($data);

            return redirect()->back()->with('success', 'Inventory item updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating inventory item: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy(InventoryItem $inventory)
    {
        try {
            $inventory->delete();
            return redirect()->back()->with('success', 'Inventory item deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting inventory item: ' . $e->getMessage());
        }
    }

    /**
     * Adjust inventory quantity (add or subtract)
     */
    public function adjustQuantity(Request $request, InventoryItem $inventory)
    {
        $request->validate([
            'change_qty' => 'required|integer',
            'reason' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $changeQty = (int) $request->change_qty;
            $newQuantity = $inventory->quantity + $changeQty;

            if ($newQuantity < 0) {
                return redirect()->back()->with('error', 'Cannot adjust quantity. Resulting quantity would be negative.');
            }

            // Update inventory quantity
            $inventory->update([
                'quantity' => $newQuantity,
                'updated_by' => Auth::id(),
            ]);

            // Create movement record
            InventoryMovement::create([
                'inventory_item_id' => $inventory->id,
                'user_id' => Auth::id(),
                'change_qty' => $changeQty,
                'reason' => $request->reason,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            DB::commit();

            $action = $changeQty > 0 ? 'added' : 'deducted';
            return redirect()->back()->with('success', "Successfully {$action} " . abs($changeQty) . " units from inventory.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error adjusting inventory: ' . $e->getMessage());
        }
    }

    /**
     * Get movement history for an item
     */
    public function getMovements(InventoryItem $inventory)
    {
        $movements = $inventory->movements()
            ->with('user')
            ->latest()
            ->paginate(10);

        return response()->json($movements);
    }
}
