<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Models\Invoices;
use Illuminate\Support\Facades\Auth;
use App\Models\InvoiceItems;
use App\Models\Promotions;
use Illuminate\Http\Request;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PayController extends Controller
{

    public static function client()
    {
        if (env('PAYPAL_MODE') == 'sandbox') {
            return new PayPalHttpClient(new SandboxEnvironment(env('PAYPAL_SANDBOX_CLIENTID'), env('PAYPAL_SANDBOX_SECRET')));
        } else {
            return new PayPalHttpClient(new ProductionEnvironment(env('PAYPAL_CLIENTID'), env('PAYPAL_SECRET')));
        }
    }
 
    private static function buildRequestBody($id, $price)
    {
        return array(
            'intent' => 'CAPTURE',
            'application_context' =>
                array(
                    'return_url' => route('invoice.result', ['id' => $id]),
                    'cancel_url' => route('invoice.result', ['id' => $id]),
                    'brand_name' => 'AstraCloud By SwizCloud',
                    'locale' => 'fr-FR',
                    'landing_page' => 'BILLING',
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'PAY_NOW',
                ),
            'purchase_units' => array(
                0 => array(
                    'reference_id' => 'SCFRFUNDS',
                    'description' => 'Invoice #'.$id,
                    'custom_id' => 'SCFR-CREDIT',
                    'soft_descriptor' => 'scfrcredit',
                    'amount' => array(
                        'currency_code' => 'EUR',
                        'value' => $price,
                        'breakdown' => array(
                            'item_total' => array(
                                'currency_code' => 'EUR',
                                'value' => $price,
                            ),
                        ),
                    ),
                ),
            ),
        );
    }

    /**
     * This is the sample function which can be sued to create an order. It uses the
     * JSON body returned by buildRequestBody() to create an new Order.
     */
    public static function createOrder($id, $price, $debug=false)
    {
        $request = new OrdersCreateRequest();
        $request->headers["prefer"] = "return=representation";
        $request->body = self::buildRequestBody($id, $price);

        $client = self::client();
        $response = $client->execute($request);
        if ($debug)
        {
            print "Status Code: {$response->statusCode}\n";
            print "Status: {$response->result->status}\n";
            print "Order ID: {$response->result->id}\n";
            print "Intent: {$response->result->intent}\n";
            print "Links:\n";
            foreach($response->result->links as $link)
            {
                print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
            }
            // To toggle printing the whole response body comment/uncomment below line
            echo json_encode($response->result, JSON_PRETTY_PRINT), "\n";
        }


        return $response;
    }

    public function create($id, Request $request)
    {
        $invoice = Invoices::where('invoiceid', $id)->where('userid', Auth::user()->id);
        $count = Invoices::where('invoiceid', $id)->where('userid', Auth::user()->id)->count();
        if ($count == '1') {
            $amount = InvoiceItems::where('invoiceid', $invoice->first()->invoiceid)->where('userid', Auth::user()->id)->sum('amount');
            if (!is_null($invoice->first()->promocode) AND Promotions::where('code', $invoice->first()->promocode)->count() == '1') {
                $total = ($amount - ($amount * (Promotions::where('code', $invoice->first()->promocode)->first()->value / 100)));
            } else {
                $total = $amount;
            }
            if ($request->method == 'stripe') {
                if ($total >= '1') {
                    \Stripe\Stripe::setApiKey(config('stripe.secret'));
                    $create = \Stripe\Checkout\Session::create([
                        'line_items' => [[
                            'price_data' => [
                                'currency' => 'eur',
                                'product_data' => [
                                    'name' => 'Invoice #'.$invoice->first()->invoiceid,
                                ],
                            'unit_amount' => $total * 100,
                            ],
                          'quantity' => 1,
                        ]],
                        'mode' => 'payment',
                        'success_url' => route('invoice.result', ['id' => $invoice->first()->invoiceid]),
                        'cancel_url' => route('invoice.result', ['id' => $invoice->first()->invoiceid]),
                    ]);
                    $invoice->update(['payment_method' => 'stripe', 'txid' => $create->id, 'status' => 'pending']);
                    return redirect($create->url);
                } else {
                    return back()->with('danger', 'Somme inférieur au montant requis');
                }
            } else if ($request->method == 'paypal') {
                $createOrder = self::createOrder($invoice->first()->invoiceid, $total);
                $invoice->update(['payment_method' => 'paypal', 'txid' => $createOrder->result->id, 'status' => 'pending']);
                return redirect($createOrder->result->links[1]->href);
            } else {
                return back()->with('danger', 'Méthode de paiement indisponible.');
            }
        } else {
            throw new NotFoundHttpException();
        }
    }

    public function store()
    {

    }
}
