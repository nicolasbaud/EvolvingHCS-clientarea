<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use Illuminate\Http\View;
use App\Models\Invoices;
use Illuminate\Support\Facades\Auth;
use App\Models\InvoiceItems;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Controllers\Invoices\PayController;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use App\Models\Transactions;

class ResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function getOrder($orderId)
    {

        $client = PayController::client();
        $response = $client->execute(new OrdersGetRequest($orderId));

        return $response;
    }

    public static function captureOrder($orderId, $debug=false)
    {
        $request = new OrdersCaptureRequest($orderId);

        $client = PayController::client();
        $response = $client->execute($request);

        return $response;
    }

    public function render($id)
    {
        $info = Invoices::where('invoiceid', $id)->where('userid', Auth::user()->id);
        $items = InvoiceItems::where('invoiceid', $id)->where('userid', Auth::user()->id);
        if ($info->count() == '1') {
            if ($info->first()->status == 'pending') {
                if ($info->first()->payment_method == 'stripe') {
                    \Stripe\Stripe::setApiKey(config('stripe.secret'));
                    $retrieve = \Stripe\Checkout\Session::retrieve($info->first()->txid, []);
                    if ($retrieve->payment_status == 'paid') {
                        $status = 'paid';
                        Transactions::insert(['gateway' => $info->first()->payment_method, 'amount' => $items->sum('amount'), 'status' => 'remove']);
                        $info->update([
                            'paid_on' => now(),
                            'status' => 'paid',
                        ]);
                        $items->update(['status' => 'pending']);
                    } else {
                        $status = 'unpaid';
                    }
                } elseif ($info->first()->payment_method == 'paypal') {
                    $getOrder = self::getOrder($info->first()->txid);
                    if ($getOrder->result->status == 'APPROVED') {
                        $capture = self::captureOrder($info->first()->txid);
                        if ($capture->result->status == 'COMPLETED') {
                            $status = 'paid';
                            Transactions::insert(['gateway' => $info->first()->payment_method, 'amount' => $items->sum('amount'), 'status' => 'remove']);
                            $info->update([
                                'txid' => $capture->result->id,
                                'paid_on' => now(),
                                'status' => 'paid',
                            ]);
                            $items->update(['status' => 'pending']);
                        } else {
                            $status = 'unpaid';
                        }
                    } else {
                        $status = 'unpaid';
                    }
                } elseif ($info->first()->payment_method == 'balance') {
                    if (Auth::user()->balance >= $items->sum('amount')) {
                        Transactions::insert(['gateway' => $info->first()->payment_method, 'amount' => $items->sum('amount'), 'status' => 'remove']);
                        $user = Auth::user();
                        $user->update(['balance' => Auth::user()->balance - $items->sum('amount')]);
                        $info->update([
                            'paid_on' => now(),
                            'status' => 'paid',
                        ]);
                        $items->update(['status' => 'pending']);
                        $status = 'paid';
                    } else {
                        $status = 'unpaid';
                    }
                }
            } else {
                $status = 'unpaid';
            }
            return view('invoices.result', [
                'status' => $status,
            ]);
        } else {
            throw new NotFoundHttpException();
        }
    }
}
