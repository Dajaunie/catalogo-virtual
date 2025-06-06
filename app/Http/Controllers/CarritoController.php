<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    public function ver()
    {
        $carrito = session()->get('carrito', []);
        return view('carrito.index', compact('carrito'));
    }

    public function agregar(Request $request, $id)
    {
        $articulo = Articulo::findOrFail($id);
        $cantidad = $request->input('cantidad', 1);

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] += $cantidad;
        } else {
            $carrito[$id] = [
                "nombre" => $articulo->nombre,
                "precio" => $articulo->precio,
                "imagen" => $articulo->imagen,
                "cantidad" => $cantidad,
                "stock" => $articulo->stock,
            ];
        }

        session()->put('carrito', $carrito);

        return redirect()->route('carrito.ver')->with('success', 'Artículo agregado al carrito.');
    }

    public function actualizar(Request $request, $id)
    {
        $cantidad = $request->input('cantidad');

        $carrito = session()->get('carrito', []);
        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] = $cantidad;
            session()->put('carrito', $carrito);
        }

        return redirect()->route('carrito.ver')->with('success', 'Cantidad actualizada.');
    }

    public function eliminar($id)
    {
        $carrito = session()->get('carrito', []);
        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }

        return redirect()->route('carrito.ver')->with('success', 'Artículo eliminado del carrito.');
    }

    public function comprar()
    {
        $carrito = session()->get('carrito', []);
        if (empty($carrito)) {
            return redirect()->route('carrito.ver')->withErrors(['carrito' => 'El carrito está vacío.']);
        }

        DB::beginTransaction();

        try {
            $total = 0;
            foreach ($carrito as $id => $item) {
                $total += $item['precio'] * $item['cantidad'];
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'estado' => 'pendiente',
            ]);

            foreach ($carrito as $id => $item) {
                $articulo = Articulo::findOrFail($id);

                if ($item['cantidad'] > $articulo->stock) {
                    throw new \Exception("No hay suficiente stock para " . $articulo->nombre);
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'articulo_id' => $id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                ]);

                $articulo->stock -= $item['cantidad'];
                $articulo->save();
            }

            session()->forget('carrito');

            DB::commit();

            return redirect()->route('articulos.index')->with('success', 'Compra completada con éxito.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('carrito.ver')->withErrors(['error' => 'Error al procesar la compra: ' . $e->getMessage()]);
        }
    }
}
