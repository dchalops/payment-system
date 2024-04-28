<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Payments\PaymentsModel;
use App\Models\Payments\PaymentMethodModel;
use App\Models\Auth\UserModel;
use App\Models\Clients\ClientModel;
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

        $query = PaymentsModel::with('client');
        
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
                      ->orWhereHas('client', function ($subQuery) use ($filter) {
                          $subQuery->where('name', 'LIKE', '%' . $filter . '%')
                                   ->orWhere('cpf', 'LIKE', '%' . $filter . '%');
                      });
            });
        }

        $payments = $query->paginate($perPage, ['*'], 'page', $currentPage);
        
        return ResponseHandler::success($payments, Lang::get('messages.payments.payment_list'), 200);
    }
    
    public function getPayment($id)
    {
        $payment = PaymentsModel::find($id);

        if (!$payment) {
            return ResponseHandler::error(Lang::get('messages.payments.payment_not_found'), 404);
        }

        $payment->load(['user', 'paymentMethod', 'client']);
        
        return ResponseHandler::success($payment, Lang::get('messages.payments.payment_details'), 200);
    }

    public function createPayment(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        $payment = PaymentsModel::create([
            'client_id' => $validatedData['client_id'],
            'description' => $validatedData['description'],
            'amount' => $validatedData['amount'],
            'status' => 'pending',
            'user_id' => $validatedData['user_id'],
            'payment_method_id' => $validatedData['payment_method_id'],
        ]);

        $simulationResult = $this->paymentSimulator->process($payment);

        if ($simulationResult['success']) {
            return ResponseHandler::success($payment, 'Payment processed successfully.', 201);
        } else {
            return ResponseHandler::error('Payment processing failed.', 500);
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
