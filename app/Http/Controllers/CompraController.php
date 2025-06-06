<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function comprar(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $articulo = Articulo::findOrFail($id);

        $cantidad = $request->input('cantidad');

        if ($cantidad > $articulo->stock) {
            return back()->withErrors(['cantidad' => 'Cantidad solicitada supera el stock disponible.']);
        }

        DB::beginTransaction();

        try {
            // Crear pedido
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $articulo->precio * $cantidad,
                'estado' => 'pendiente',
            ]);

            // Crear item de pedido
            OrderItem::create([
                'order_id' => $order->id,
                'articulo_id' => $articulo->id,
                'cantidad' => $cantidad,
                'precio_unitario' => $articulo->precio,
            ]);

            // Reducir stock
            $articulo->stock -= $cantidad;
            $articulo->save();

            DB::commit();

            return redirect()->route('articulos.index')->with('success', 'Compra realizada exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Error al procesar la compra. Inténtalo de nuevo.']);
        }
    }
}
