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
        ]);

        DB::transaction(function () use ($course, $user, $data) {
            $order = Order::create([
                'user_id' => $user->id,
                'subtotal' => $course->price,
                'discount' => 0,
                'total' => $course->price,
                'payment_method' => $data['payment_method'],
                'status' => 'Pagado',
                'shipping_address' => 'Entrega digital - video',
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
                'student_name' => $user->name ?? null,
                'student_email' => $user->email ?? null,
                'student_phone' => $user->phone ?? null,
                'student_address' => $user->address ?? null,
                'status' => 'Activo',
            ]);

            $course->increment('enrollment_count');
            \App\Support\AuditLogger::log('enrolled_auto', $course);
        });

        return redirect()
            ->route('courses.show', $course->id)
            ->with('status', 'Pago confirmado. Ya puedes descargar o ver el video.');
    }
}
