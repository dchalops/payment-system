<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Payments\PaymentsModel;
use App\Models\Payments\PaymentMethodModel;
use App\Services\PaymentSimulator;
use App\Http\Utils\ResponseHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class PaymentController extends Controller
{
    protected $paymentSimulator;

    public function __construct(PaymentSimulator $paymentSimulator)
    {
        $this->paymentSimulator = $paymentSimulator;
    }
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $currentPage = $request->query('page', 1);
        
        if ($perPage < 1 || $currentPage < 1) {
            return ResponseHandler::error(Lang::get('messages.payments.payment_params'), 400);
        }

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $filter = $request->query('filter');
        $status = $request->query('status'); 

        $query = PaymentsModel::query();
        
        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }

        if ($status) {
            $query->where('status', $status);
        }
        
        if ($filter) {
            $query->where(function ($query) use ($filter) {
                $query->where('description', 'LIKE', '%' . $filter . '%')
                      ->orWhere('client_name', 'LIKE', '%' . $filter . '%')
                      ->orWhere('client_cpf', 'LIKE', '%' . $filter . '%');
            });
        }

        $payments = $query->paginate($perPage, ['*'], 'page', $currentPage);
        
        return ResponseHandler::success($payments, Lang::get('messages.payments.payment_list'), 200);
    }
    
    public function createPayment(Request $request)
    {
        if ($paymentCreated) {
            return ResponseHandler::success(Lang::get('messages.payment_created'), 201);
        } else {
            return ResponseHandler::error('Failed to create payment', 500);
        }
    }

    public function updatePayment(Request $request, $id)
    {
        if ($paymentUpdated) {
            return ResponseHandler::success(Lang::get('messages.payment_updated'));
        } else {
            return ResponseHandler::notFound(Lang::get('messages.payment_not_found'));
        }
    }

    public function process(Request $request)
    {
        $validatedData = $request->validate([
            'payment_id' => 'required|integer|exists:payments,id',
        ]);

        $payment = PaymentModel::find($validatedData['payment_id']);
        $result = $this->paymentSimulator->process($payment);

        return response()->json($result, $result['success'] ? 200 : 400);
    }
}
