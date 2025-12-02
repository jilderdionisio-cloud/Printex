<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoursePurchaseController extends Controller
{
    public function store(Request $request, Course $course): RedirectResponse
    {
        $user = $request->user();

        $alreadyEnrolled = CourseEnrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->exists();

        if ($alreadyEnrolled) {
            return redirect()
                ->route('courses.show', $course->id)
                ->with('status', 'Ya tienes acceso a este video.');
        }

        $data = $request->validate([
            'payment_method' => ['required', 'string', 'max:50'],
            'payment_reference' => ['nullable', 'string', 'max:255'],
            'payment_reference_transfer' => ['nullable', 'string', 'max:255'],
            'card_number' => ['nullable', 'string', 'max:32'],
            'card_exp' => ['nullable', 'string', 'max:8'],
            'card_cvv' => ['nullable', 'string', 'max:8'],
        ]);

        // Validamos campos segun metodo seleccionado
        if ($data['payment_method'] === 'tarjeta') {
            $request->validate([
                'card_number' => ['required', 'string', 'min:12', 'max:32'],
                'card_exp' => ['required', 'string', 'max:8'],
                'card_cvv' => ['required', 'string', 'max:8'],
            ]);
        } elseif ($data['payment_method'] === 'yape-plin') {
            $request->validate([
                'payment_reference' => ['required', 'string', 'max:255'],
            ]);
        } elseif ($data['payment_method'] === 'transferencia') {
            $request->validate([
                'payment_reference_transfer' => ['required', 'string', 'max:255'],
            ]);
        }

        // Normalizamos la referencia segun el metodo de pago
        $reference = null;
        if ($data['payment_method'] === 'tarjeta') {
            $last4 = isset($data['card_number']) ? substr(preg_replace('/\\D/', '', $data['card_number']), -4) : null;
            $reference = trim(($last4 ? 'Tarjeta ****' . $last4 . ' ' : '') . ($data['card_exp'] ?? ''));
        } elseif ($data['payment_method'] === 'yape-plin') {
            $reference = $data['payment_reference'] ?? null;
        } elseif ($data['payment_method'] === 'transferencia') {
            $reference = $data['payment_reference_transfer'] ?? null;
        }

        DB::transaction(function () use ($course, $user, $data, $reference) {
            $order = Order::create([
                'user_id' => $user->id,
                'subtotal' => $course->price,
                'discount' => 0,
                'total' => $course->price,
                'payment_method' => $data['payment_method'],
                // Usamos un estado permitido por el flujo de pedidos
                'status' => 'Procesando',
                'shipping_address' => 'Entrega digital - video',
                'notes' => $reference,
            ]);
            \App\Support\AuditLogger::log('created', $order);

            OrderItem::create([
                'order_id' => $order->id,
                'name' => $course->name,
                'quantity' => 1,
                'price' => $course->price,
                'item_type' => 'course',
                'product_id' => null,
                'course_id' => $course->id,
            ]);

            CourseEnrollment::create([
                'course_id' => $course->id,
                'user_id' => $user->id,
                'student_name' => $user->name ?? 'Cliente',
                'student_email' => $user->email ?? 'sin-correo',
                // Algunas columnas son NOT NULL en la base, aseguramos valores por defecto
                'student_phone' => $user->phone ?? 'sin-telefono',
                'student_address' => $user->address ?? 'sin-direccion',
                'status' => 'Activo',
            ]);

            $course->increment('enrollment_count');
            \App\Support\AuditLogger::log('enrolled_auto', $course);
        });

        return redirect()
            ->route('courses.show', $course->id)
            ->with('status', 'Ya puedes revisar el video en Mis cursos. Gracias por tu compra.');
    }
}
