<?php

namespace App\Http\Controllers;

use App\Models\MpesaTransaction;
use Iankumu\Mpesa\Facades\Mpesa;
use Illuminate\Http\Request;

class MpesaController extends Controller
{
    /**
     * Initiate STK Push for Nachu Hostel Fee Payment
     */
    public function initiateStkPush(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => 'required|regex:/^2547[0-9]{8}$/', // Must be 2547XXXXXXXX
            'amount'       => 'required|numeric|min:1|max:150000',
            'student_id'   => 'required|exists:students,id', // Add this for your hostel
            'account_reference' => 'required|string|max:12', // e.g. "STUDENT123"
        ]);

        try {
            $response = Mpesa::stkpush(
                phonenumber: $validated['phone_number'],
                amount: $validated['amount'],
                account_number: $validated['account_reference'], // Student ID or Reg No
                transactionType: Mpesa::PAYBILL, // Change to Mpesa::TILL if using Buy Goods
                description: "Nachu Hostel Fee Payment - Student #{$validated['student_id']}"
            );

            $result = $response->json();

            // Success response from Safaricom
            if (isset($result['ResponseCode']) && $result['ResponseCode'] === '0') {

                MpesaTransaction::create([
                    'student_id'         => $validated['student_id'],
                    'phone_number'       => $validated['phone_number'],
                    'amount'             => $validated['amount'],
                    'account_reference'  => $validated['account_reference'],
                    'merchant_request_id'=> $result['MerchantRequestID'],
                    'checkout_request_id'=> $result['CheckoutRequestID'],
                    'response_code'      => $result['ResponseCode'],
                    'response_description'=> $result['ResponseDescription'] ?? 'Success',
                    'status'             => 'pending', // Will be updated by callback
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'M-PESA STK Push sent! Check your phone to complete payment.',
                    'checkout_request_id' => $result['CheckoutRequestID']
                ], 200);
            }

            // Failed to initiate
            return response()->json([
                'success' => false,
                'message' => 'Failed to initiate payment',
                'error'   => $result['errorMessage'] ?? 'Unknown error'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Optional: Handle Callback (Recommended)
     */
    public function callback(Request $request)
    {
        $callbackData = $request->all();

        \Log::info('M-PESA Callback:', $callbackData); // Check storage/logs/laravel.log

        $resultCode = $callbackData['Body']['stkCallback']['ResultCode'] ?? null;

        if ($resultCode == 0) {
            $items = $callbackData['Body']['stkCallback']['CallbackMetadata']['Item'];

            $receipt = collect($items)->firstWhere('Name', 'MpesaReceiptNumber')['Value'] ?? null;
            $amount  = collect($items)->firstWhere('Name', 'Amount')['Value'] ?? null;
            $phone   = collect($items)->firstWhere('Name', 'PhoneNumber')['Value'] ?? null;

            $checkoutId = $callbackData['Body']['stkCallback']['CheckoutRequestID'];

            MpesaTransaction::where('checkout_request_id', $checkoutId)->update([
                'status' => 'completed',
                'receipt_number' => $receipt,
                'amount_paid' => $amount,
                'completed_at' => now(),
            ]);

            // Optional: Mark student fee as paid here
            // Student::where('id', $transaction->student_id)->update(['fee_status' => 'paid']);
        } else {
            $checkoutId = $callbackData['Body']['stkCallback']['CheckoutRequestID'];
            $error = $callbackData['Body']['stkCallback']['ResultDesc'] ?? 'Unknown';

            MpesaTransaction::where('checkout_request_id', $checkoutId)->update([
                'status' => 'failed',
                'error_message' => $error
            ]);
        }

        return response()->json(['status' => 'OK']);
    }
}