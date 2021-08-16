<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class FactureController extends Controller
{
    public function login()
    {
        return view('mylogin');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('idUser');
        $request->session()->forget('loginUser');
        $request->session()->forget('passwordUser');

        return redirect()->route('mylogin');
    }

    public function index(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        $response = Http::get('http://localhost:8080/api/user/'.$request->login.'/'.$request->password);

        if($response->successful())
        {
            $user = $response->json();

            $request->session()->put('idUser', $user['id']);
            $request->session()->put('loginUser', $user['login']);
            $request->session()->put('passwordUser', $user['password']);

            return redirect()->route('dashboard');

        }
        else
        {
            return redirect()->route('mylogin')->with('myerror', 'identifiant ou mot de passe incorrect');
        }

    }

    public function dashboard(Request $request)
    {
        $request->session()->forget('listProduct');

        $bills = Http::get('http://localhost:8080/api/billByCustomers')->json();
        $customers = Http::get('http://localhost:8080/api/customers')->json();

        return view('dashboard',
            [
                'bills' => $bills,
                'customers' => $customers
            ]
        );
    }

    public function facture(Request $request)
    {
        $request->session()->forget('listProduct');
        $customers = Http::get('http://localhost:8080/api/customers')->json();
        $products = Http::get('http://localhost:8080/api/products')->json();

        return view('facture',
            [
                'customers' => $customers,
                'products' => $products
            ]
        );

    }

    public function listProduct(Request $request, $list, $customer, $mtn)
    {
        $t = explode(',', $list);
        $m = explode(',', $mtn);
        $c = explode(',', $customer);
        $tva = (float) $m[0];
        $amount = (float) $m[1];

        $bill = Http::post('http://localhost:8080/api/bill', ['amount' => $amount, 'tva' => $tva])->json();

        if($c[0] == "")
        {
            $response = Http::post('http://localhost:8080/api/customers', ['name' => $c[1], 'fisrtname' => $c[2] , 'contact' => $c[3]])->json();
            $customerId = $response['id'];
        }
        else
        {
            $customerId = $c[0];
        }

        $billByCustomer = Http::post('http://localhost:8080/api/billByCustomers', [
            'key' => [
                'customerId' => $customerId,
                'billId' => $bill['id']
            ],
            'amount' => $amount,
            'tva' => $tva
        ])->json();

        for($i = 0; $i < count($t); $i = $i+4)
        {
            $response = Http::post('http://localhost:8080/api/productByBills', [
                'key' => [
                    'billId' => $bill['id'],
                    'productId' => $t[$i]
                ],
                'name' => $t[$i+1],
                'price' => $t[$i+2],
                'quantity' => $t[$i+3],
                'amount' => intval($t[$i+2]) * intval($t[$i+3]),
            ])->successful();
        }

        if($response)
        {
            return redirect()->route('facture.details', ['billId' => $bill['id'], 'customerId' => $customerId])->with('message', 'Bill created successfully');
        }
        else
        {
            abort(500);
        }
    }

    public function details($billId, $customerId)
    {
        $customer = Http::get('http://localhost:8080/api/customers/'.$customerId)->json();
        $bill = Http::get('http://localhost:8080/api/bills/'.$billId)->json();
        $productByBills = Http::get('http://localhost:8080/api/productByBills/bills/'.$billId)->json();
        return view('details', [
            'bill' => $bill,
            'customer' => $customer,
            'productByBills' => $productByBills
        ]);
    }

    public function pay($billId, $customerId)
    {
        $response1 = Http::put('http://localhost:8080/api/bill/pay/'.$billId)->successful();
        $response2 = Http::put('http://localhost:8080/api/billByCustomers/pay', ['customerId' => $customerId, 'billId' => $billId])->successful();

        if($response1 && $response2)
        {
            return redirect()->route('dashboard')->with('message', 'Facture payée avec succées');
        }
        else
        {
            abort(500);
        }
    }

    public function delete(Request $request, $billId, $customerId, $pass)
    {
        $truePass = $request->session()->get('passwordUser');

        if($pass != $truePass)
        {
            return redirect()->route('dashboard')->with('myerror', 'Impossible d\'annuler le payement mot de passe incorrect');
        }
        else
        {

            $response1 = Http::put('http://localhost:8080/api/bill/cancel/'.$billId)->successful();
            $response2 = Http::put('http://localhost:8080/api/billByCustomers/cancel', ['customerId' => $customerId, 'billId' => $billId])->successful();

            if($response1 && $response2)
            {
                return redirect()->route('dashboard')->with('message', 'Facture annulée avec succées');
            }
            else
            {
                abort(500);
            }
        }

    }
}
