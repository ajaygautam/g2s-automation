<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Membership;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Token as StripeToken;


class StripeController extends Controller
{

    public $stripe_response = [
        'customer_created' => '{"id":"evt_1F959cAye9PHCVermiJbgsuO","object":"event","api_version":"2019-05-16","created":1566199186,"data":{"object":{"id":"cus_FeNvl0jMer5H01","object":"customer","account_balance":0,"address":null,"balance":0,"created":1566199186,"currency":null,"default_source":null,"delinquent":false,"description":null,"discount":null,"email":"sarab@sdnatech.com","invoice_prefix":"BB836C02","invoice_settings":{"custom_fields":null,"default_payment_method":null,"footer":null},"livemode":false,"metadata":[],"name":null,"phone":null,"preferred_locales":[],"shipping":null,"sources":{"object":"list","data":[],"has_more":false,"total_count":0,"url":"\/v1\/customers\/cus_FeNvl0jMer5H01\/sources"},"subscriptions":{"object":"list","data":[{"id":"sub_FeNvGLPZDjV7T7","object":"subscription","application_fee_percent":null,"billing":"charge_automatically","billing_cycle_anchor":1566199187,"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":null,"collection_method":"charge_automatically","created":1566199187,"current_period_end":1568877587,"current_period_start":1566199187,"customer":"cus_FeNvl0jMer5H01","days_until_due":null,"default_payment_method":"pm_1F959aAye9PHCVerToXy91a8","default_source":null,"default_tax_rates":[],"discount":null,"ended_at":null,"items":{"object":"list","data":[{"id":"si_FeNvoBfiMTWqDK","object":"subscription_item","billing_thresholds":null,"created":1566199187,"metadata":[],"plan":{"id":"plan_Fc8mbkveh4Qnan","object":"plan","active":true,"aggregate_usage":null,"amount":25000,"billing_scheme":"per_unit","created":1565681546,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":[],"nickname":"Monthly","product":"prod_Fc8lbdYB80MaKb","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"subscription":"sub_FeNvGLPZDjV7T7","tax_rates":[]}],"has_more":false,"total_count":1,"url":"\/v1\/subscription_items?subscription=sub_FeNvGLPZDjV7T7"},"latest_invoice":"in_1F959bAye9PHCVerIxT0An0x","livemode":false,"metadata":[],"pending_setup_intent":null,"plan":{"id":"plan_Fc8mbkveh4Qnan","object":"plan","active":true,"aggregate_usage":null,"amount":25000,"billing_scheme":"per_unit","created":1565681546,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":[],"nickname":"Monthly","product":"prod_Fc8lbdYB80MaKb","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1566199187,"start_date":1566199187,"status":"active","tax_percent":null,"trial_end":null,"trial_start":null}],"has_more":false,"total_count":1,"url":"\/v1\/customers\/cus_FeNvl0jMer5H01\/subscriptions"},"tax_exempt":"none","tax_ids":{"object":"list","data":[],"has_more":false,"total_count":0,"url":"\/v1\/customers\/cus_FeNvl0jMer5H01\/tax_ids"},"tax_info":null,"tax_info_verification":null}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_LGYVcefkxymi4o","idempotency_key":null},"type":"customer.created"} ',
        'customer_subscription_created' => '{"id":"evt_1F959dAye9PHCVer4jMtt70P","object":"event","api_version":"2019-05-16","created":1566199187,"data":{"object":{"id":"sub_FeNvGLPZDjV7T7","object":"subscription","application_fee_percent":null,"billing":"charge_automatically","billing_cycle_anchor":1566199187,"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":null,"collection_method":"charge_automatically","created":1566199187,"current_period_end":1568877587,"current_period_start":1566199187,"customer":"cus_FeNvl0jMer5H01","days_until_due":null,"default_payment_method":"pm_1F959aAye9PHCVerToXy91a8","default_source":null,"default_tax_rates":[],"discount":null,"ended_at":null,"items":{"object":"list","data":[{"id":"si_FeNvoBfiMTWqDK","object":"subscription_item","billing_thresholds":null,"created":1566199187,"metadata":[],"plan":{"id":"plan_Fc8mbkveh4Qnan","object":"plan","active":true,"aggregate_usage":null,"amount":25000,"billing_scheme":"per_unit","created":1565681546,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":[],"nickname":"Monthly","product":"prod_Fc8lbdYB80MaKb","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"subscription":"sub_FeNvGLPZDjV7T7","tax_rates":[]}],"has_more":false,"total_count":1,"url":"\/v1\/subscription_items?subscription=sub_FeNvGLPZDjV7T7"},"latest_invoice":"in_1F959bAye9PHCVerIxT0An0x","livemode":false,"metadata":[],"pending_setup_intent":null,"plan":{"id":"plan_Fc8mbkveh4Qnan","object":"plan","active":true,"aggregate_usage":null,"amount":25000,"billing_scheme":"per_unit","created":1565681546,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":[],"nickname":"Monthly","product":"prod_Fc8lbdYB80MaKb","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1566199187,"start_date":1566199187,"status":"incomplete","tax_percent":null,"trial_end":null,"trial_start":null}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_LGYVcefkxymi4o","idempotency_key":null},"type":"customer.subscription.created"} ',
        'customer_updated' => '{"id":"evt_1F959dAye9PHCVer2MiXjhEs","object":"event","api_version":"2019-05-16","created":1566199187,"data":{"object":{"id":"cus_FeNvl0jMer5H01","object":"customer","account_balance":0,"address":null,"balance":0,"created":1566199186,"currency":"usd","default_source":null,"delinquent":false,"description":null,"discount":null,"email":"sarab@sdnatech.com","invoice_prefix":"BB836C02","invoice_settings":{"custom_fields":null,"default_payment_method":null,"footer":null},"livemode":false,"metadata":[],"name":null,"phone":null,"preferred_locales":[],"shipping":null,"sources":{"object":"list","data":[],"has_more":false,"total_count":0,"url":"\/v1\/customers\/cus_FeNvl0jMer5H01\/sources"},"subscriptions":{"object":"list","data":[{"id":"sub_FeNvGLPZDjV7T7","object":"subscription","application_fee_percent":null,"billing":"charge_automatically","billing_cycle_anchor":1566199187,"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":null,"collection_method":"charge_automatically","created":1566199187,"current_period_end":1568877587,"current_period_start":1566199187,"customer":"cus_FeNvl0jMer5H01","days_until_due":null,"default_payment_method":"pm_1F959aAye9PHCVerToXy91a8","default_source":null,"default_tax_rates":[],"discount":null,"ended_at":null,"items":{"object":"list","data":[{"id":"si_FeNvoBfiMTWqDK","object":"subscription_item","billing_thresholds":null,"created":1566199187,"metadata":[],"plan":{"id":"plan_Fc8mbkveh4Qnan","object":"plan","active":true,"aggregate_usage":null,"amount":25000,"billing_scheme":"per_unit","created":1565681546,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":[],"nickname":"Monthly","product":"prod_Fc8lbdYB80MaKb","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"subscription":"sub_FeNvGLPZDjV7T7","tax_rates":[]}],"has_more":false,"total_count":1,"url":"\/v1\/subscription_items?subscription=sub_FeNvGLPZDjV7T7"},"latest_invoice":"in_1F959bAye9PHCVerIxT0An0x","livemode":false,"metadata":[],"pending_setup_intent":null,"plan":{"id":"plan_Fc8mbkveh4Qnan","object":"plan","active":true,"aggregate_usage":null,"amount":25000,"billing_scheme":"per_unit","created":1565681546,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":[],"nickname":"Monthly","product":"prod_Fc8lbdYB80MaKb","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1566199187,"start_date":1566199187,"status":"active","tax_percent":null,"trial_end":null,"trial_start":null}],"has_more":false,"total_count":1,"url":"\/v1\/customers\/cus_FeNvl0jMer5H01\/subscriptions"},"tax_exempt":"none","tax_ids":{"object":"list","data":[],"has_more":false,"total_count":0,"url":"\/v1\/customers\/cus_FeNvl0jMer5H01\/tax_ids"},"tax_info":null,"tax_info_verification":null},"previous_attributes":{"currency":null}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_LGYVcefkxymi4o","idempotency_key":null},"type":"customer.updated"}  ',
        'charge' => '{"id":"evt_1F959dAye9PHCVerAJrJ7C0e","object":"event","api_version":"2019-05-16","created":1566199188,"data":{"object":{"id":"ch_1F959bAye9PHCVervIZetaSB","object":"charge","amount":25000,"amount_refunded":0,"application":null,"application_fee":null,"application_fee_amount":null,"balance_transaction":"txn_1F959cAye9PHCVeraTetd6Vv","billing_details":{"address":{"city":null,"country":"IN","line1":null,"line2":null,"postal_code":null,"state":null},"email":"sarab@sdnatech.com","name":"SArab","phone":null},"captured":true,"created":1566199187,"currency":"usd","customer":"cus_FeNvl0jMer5H01","description":"Payment for invoice BB836C02-0001","destination":null,"dispute":null,"failure_code":null,"failure_message":null,"fraud_details":[],"invoice":"in_1F959bAye9PHCVerIxT0An0x","livemode":false,"metadata":[],"on_behalf_of":null,"order":null,"outcome":{"network_status":"approved_by_network","reason":null,"risk_level":"normal","risk_score":20,"seller_message":"Payment complete.","type":"authorized"},"paid":true,"payment_intent":"pi_1F959bAye9PHCVerP5NaixRe","payment_method":"pm_1F959aAye9PHCVerToXy91a8","payment_method_details":{"card":{"brand":"visa","checks":{"address_line1_check":null,"address_postal_code_check":null,"cvc_check":"pass"},"country":"US","exp_month":1,"exp_year":2021,"fingerprint":"bv9BZ7MRzqimJ1Og","funding":"unknown","last4":"1111","three_d_secure":null,"wallet":null},"type":"card"},"receipt_email":null,"receipt_number":null,"receipt_url":"https:\/\/pay.stripe.com\/receipts\/acct_1F58VtAye9PHCVer\/ch_1F959bAye9PHCVervIZetaSB\/rcpt_FeNvejPjM6xiX6P1nkPXwNQ6JtSwDmP","refunded":false,"refunds":{"object":"list","data":[],"has_more":false,"total_count":0,"url":"\/v1\/charges\/ch_1F959bAye9PHCVervIZetaSB\/refunds"},"review":null,"shipping":null,"source":null,"source_transfer":null,"statement_descriptor":null,"statement_descriptor_suffix":null,"status":"succeeded","transfer_data":null,"transfer_group":null}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_LGYVcefkxymi4o","idempotency_key":null},"type":"charge.succeeded"} ',
        'checkout' => '{"id":"evt_1F959dAye9PHCVerFci6n1Yo","object":"event","api_version":"2019-05-16","created":1566199188,"data":{"object":{"id":"cs_test_fUbdI84Ld4dEt2PJ2ZrY5DSnHxlDIKpXAwRXTb3jem8XkK22Mfdvbt1A","object":"checkout.session","billing_address_collection":null,"cancel_url":"http:\/\/45.248.158.188\/gl-demo-admin\/public\/api\/acuity_post","client_reference_id":null,"customer":"cus_FeNvl0jMer5H01","customer_email":null,"display_items":[{"amount":25000,"currency":"usd","plan":{"id":"plan_Fc8mbkveh4Qnan","object":"plan","active":true,"aggregate_usage":null,"amount":25000,"billing_scheme":"per_unit","created":1565681546,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":[],"nickname":"Monthly","product":"prod_Fc8lbdYB80MaKb","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"type":"plan"}],"livemode":false,"locale":null,"payment_intent":null,"payment_method_types":["card"],"submit_type":null,"subscription":"sub_FeNvGLPZDjV7T7","success_url":"http:\/\/45.248.158.188\/gl-demo-admin\/public\/api\/acuity_post"}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_LGYVcefkxymi4o","idempotency_key":null},"type":"checkout.session.completed"} ',
        'customer_subscription_updated' => '{"id":"evt_1F959dAye9PHCVer0PodLY71","object":"event","api_version":"2019-05-16","created":1566199188,"data":{"object":{"id":"sub_FeNvGLPZDjV7T7","object":"subscription","application_fee_percent":null,"billing":"charge_automatically","billing_cycle_anchor":1566199187,"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":null,"collection_method":"charge_automatically","created":1566199187,"current_period_end":1568877587,"current_period_start":1566199187,"customer":"cus_FeNvl0jMer5H01","days_until_due":null,"default_payment_method":"pm_1F959aAye9PHCVerToXy91a8","default_source":null,"default_tax_rates":[],"discount":null,"ended_at":null,"items":{"object":"list","data":[{"id":"si_FeNvoBfiMTWqDK","object":"subscription_item","billing_thresholds":null,"created":1566199187,"metadata":[],"plan":{"id":"plan_Fc8mbkveh4Qnan","object":"plan","active":true,"aggregate_usage":null,"amount":25000,"billing_scheme":"per_unit","created":1565681546,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":[],"nickname":"Monthly","product":"prod_Fc8lbdYB80MaKb","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"subscription":"sub_FeNvGLPZDjV7T7","tax_rates":[]}],"has_more":false,"total_count":1,"url":"\/v1\/subscription_items?subscription=sub_FeNvGLPZDjV7T7"},"latest_invoice":"in_1F959bAye9PHCVerIxT0An0x","livemode":false,"metadata":[],"pending_setup_intent":null,"plan":{"id":"plan_Fc8mbkveh4Qnan","object":"plan","active":true,"aggregate_usage":null,"amount":25000,"billing_scheme":"per_unit","created":1565681546,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":[],"nickname":"Monthly","product":"prod_Fc8lbdYB80MaKb","tiers":null,"tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start":1566199187,"start_date":1566199187,"status":"active","tax_percent":null,"trial_end":null,"trial_start":null},"previous_attributes":{"status":"incomplete"}},"livemode":false,"pending_webhooks":1,"request":{"id":"req_LGYVcefkxymi4o","idempotency_key":null},"type":"customer.subscription.updated"}'
    ];

    public function StripePost(Request $request)
    {
        $customer = [];
        $payment = [];
        $subscription = [];

        foreach ($this->stripe_response as $response) {
            $res = json_decode($response);




            if ($res->type == 'customer.updated') {
                $customer['stripe_customer_id'] = $res->data->object->id;
                $customer['email'] = $res->data->object->email;
                $customer['invoice_prefix'] = $res->data->object->invoice_prefix;
                $customer['name'] = $res->data->object->name;
                $customer['phone'] = $res->data->object->phone;
                $customer['subscription_id'] = $res->data->object->subscriptions->data[0]->id;
                $customer['subscription_start_time'] = date('Y-m-d H:i:s', $res->data->object->subscriptions->data[0]->billing_cycle_anchor);
                $customer['current_period_start'] = date('Y-m-d H:i:s', $res->data->object->subscriptions->data[0]->current_period_start);
                $customer['current_period_end'] = date('Y-m-d H:i:s', $res->data->object->subscriptions->data[0]->current_period_end);
                $customer['collection_method'] = $res->data->object->subscriptions->data[0]->collection_method;
                $customer['discount'] = $res->data->object->subscriptions->data[0]->discount;
                $customer['plan_id'] = $res->data->object->subscriptions->data[0]->items->data[0]->plan->id;
                $customer['amount'] = $res->data->object->subscriptions->data[0]->items->data[0]->plan->amount;
                $customer['interval'] = $res->data->object->subscriptions->data[0]->items->data[0]->plan->interval;
                $customer['product'] = $res->data->object->subscriptions->data[0]->items->data[0]->plan->product;
                pa($res);

                $customerObj = Customer::create([
                    'first_name' =>  $customer['name'],
                    'primary_phone' => $customer['phone'],
                    'primary_email' =>  $customer['email'],
                    'plan_starts_on' => $customer['current_period_start'],
                    'plan_ends_on' => $customer['current_period_end'],
                    'is_plan_hold' => 0,
                    'stripe_product_id' => $customer['product'],
                    'stripe_customer_id' => $customer['stripe_customer_id'],
                    'stripe_subscription_id' => $customer['subscription_id']
                ]);
            }

            if ($res->type == 'charge.succeeded') {
                $payment['charge_id'] = $res->data->object->id;
                $payment['amount'] = number_format(($res->data->object->amount) / 100, 2, '.', '');
                $payment['balance_transaction'] = $res->data->object->balance_transaction;
                $payment['created'] = $res->data->object->created;
                $payment['currency'] = $res->data->object->currency;
                $payment['customer'] = $res->data->object->customer;
                $payment['invoice'] = $res->data->object->invoice;
                $payment['brand'] = $res->data->object->payment_method_details->card->brand;
                $payment['cc_exp_month'] = $res->data->object->payment_method_details->card->exp_month;
                $payment['cc_exp_year'] = $res->data->object->payment_method_details->card->exp_year;
                $payment['cc_last_four'] = $res->data->object->payment_method_details->card->last4;
                $payment['fingerprint'] = $res->data->object->payment_method_details->card->fingerprint;
                $payment['receipt_url'] = $res->data->object->receipt_url;
                $payment['status'] = $res->data->object->status;
                //  pa($res);

                $paymentObj = Payment::create([
                    // 'user_id' => $customerObj->id,
                    'amount' => $payment['amount'],
                    'payment_for' => 'New Membership',
                    'payment_status' => $payment['status'],
                    'transaction_id' => $payment['balance_transaction'],
                    'stripe_customer_id' =>  $payment['customer'],
                    'stripe_charge_id' =>  $payment['charge_id'],
                    'stripe_balance_transaction' =>  $payment['balance_transaction'],
                    'stripe_invoice' => $payment['invoice'],
                    'stripe_card_last_4' => $payment['cc_last_four'],
                    'stripe_card_exp_month' => $payment['cc_exp_month'],
                    'stripe_card_exp_year' => $payment['cc_exp_year'],
                    'stripe_payment_fingureprint' =>  $payment['fingerprint'],
                    'stripe_receipt_url' => $payment['receipt_url'],
                    'stripe_payment_created' => date('Y-m-d H:i:s',  $payment['created']),
                    'stripe_currency' =>  $payment['currency'],
                ]);
            }
        }

        pa($customer);
        pa($payment);
    }



    public static function StripePostStatic($payload)
    {
        $customer = [];
        $payment = [];
        $subscription = [];

        Log::info('StripePostStatic');

        $res = json_decode($payload);

        //get Membership Plan Id
        $membership = Membership::where('stripe_product_id', $res->data->object->subscriptions->data[0]->items->data[0]->plan->product )->first();


        if ($res->type == 'customer.updated') {
            $customer['stripe_customer_id'] = $res->data->object->id;
            $customer['email'] = $res->data->object->email;
            $customer['invoice_prefix'] = $res->data->object->invoice_prefix;
            $customer['name'] = $res->data->object->name;
            $customer['phone'] = $res->data->object->phone;
            $customer['subscription_id'] = $res->data->object->subscriptions->data[0]->id;
            $customer['subscription_start_time'] = date('Y-m-d H:i:s', $res->data->object->subscriptions->data[0]->billing_cycle_anchor);
            $customer['current_period_start'] = date('Y-m-d H:i:s', $res->data->object->subscriptions->data[0]->current_period_start);
            $customer['current_period_end'] = date('Y-m-d H:i:s', $res->data->object->subscriptions->data[0]->current_period_end);
            $customer['collection_method'] = $res->data->object->subscriptions->data[0]->collection_method;
            $customer['discount'] = $res->data->object->subscriptions->data[0]->discount;
            $customer['plan_id'] = $res->data->object->subscriptions->data[0]->items->data[0]->plan->id;
            $customer['amount'] = $res->data->object->subscriptions->data[0]->items->data[0]->plan->amount;
            $customer['interval'] = $res->data->object->subscriptions->data[0]->items->data[0]->plan->interval;
            $customer['product'] = $res->data->object->subscriptions->data[0]->items->data[0]->plan->product;
            



            $customerObj = Customer::create([
                'first_name' =>  $customer['name'],
                'primary_phone' => $customer['phone'],
                'primary_email' =>  $customer['email'],
                'plan_starts_on' => $customer['current_period_start'],
                'plan_ends_on' => $customer['current_period_end'],
                'is_plan_hold' => 0,
                'membership_plan_id' => $membership->id,
                'stripe_product_id' => $customer['product'],
                'stripe_customer_id' => $customer['stripe_customer_id'],
                'stripe_subscription_id' => $customer['subscription_id']
            ]);
        }

        if ($res->type == 'charge.succeeded') {
            $payment['charge_id'] = $res->data->object->id;
            $payment['amount'] = number_format(($res->data->object->amount) / 100, 2, '.', '');
            $payment['balance_transaction'] = $res->data->object->balance_transaction;
            $payment['created'] = $res->data->object->created;
            $payment['currency'] = $res->data->object->currency;
            $payment['customer'] = $res->data->object->customer;
            $payment['invoice'] = $res->data->object->invoice;
            $payment['brand'] = $res->data->object->payment_method_details->card->brand;
            $payment['cc_exp_month'] = $res->data->object->payment_method_details->card->exp_month;
            $payment['cc_exp_year'] = $res->data->object->payment_method_details->card->exp_year;
            $payment['cc_last_four'] = $res->data->object->payment_method_details->card->last4;
            $payment['fingerprint'] = $res->data->object->payment_method_details->card->fingerprint;
            $payment['receipt_url'] = $res->data->object->receipt_url;
            $payment['status'] = $res->data->object->status;
            //  pa($res);

            $paymentObj = Payment::create([
               // 'user_id' => $customerObj->id,
                'amount' => $payment['amount'],
                'payment_for' => 'New Membership',
                'payment_status' => $payment['status'],
                'transaction_id' => $payment['balance_transaction'],
                'stripe_customer_id' =>  $payment['customer'],
                'stripe_charge_id' =>  $payment['charge_id'],
                'stripe_balance_transaction' =>  $payment['balance_transaction'],
                'stripe_invoice' => $payment['invoice'],
                'stripe_card_last_4' => $payment['cc_last_four'],
                'stripe_card_exp_month' => $payment['cc_exp_month'],
                'stripe_card_exp_year' => $payment['cc_exp_year'],
                'stripe_payment_fingureprint' =>  $payment['fingerprint'],
                'stripe_receipt_url' => $payment['receipt_url'],
                'stripe_payment_created' => date('Y-m-d H:i:s',  $payment['created']),
                'stripe_currency' =>  $payment['currency'],
            ]);
        }

        Log::info('Stripe payload handled successfully');

       
    }



    public function StripeSubscription(){
        // Stripe::setApiKey(env('STRIPE_SECRET'));

        // $stripeToken = StripeToken::create(array(
        //     "card" => array(
        //         "number"    => '4111111111111111',
        //         "exp_month" => '01',
        //         "exp_year"  => '21',
        //         "cvc"       => '123',
        //         "name"      => 'sarav'
        //     )
        // ));

        // $customer = \Stripe\Customer::create([
        //     'source' => $stripeToken->id,
        //     'email' => 'sarabjeet.dhillon+19@sdnatech.com',
        // ]);

        // pa($stripeToken);
        // pa($customer);die;

        // $customer = Customer::find(6);
        // $result =   $customer->newSubscription('main', 'prod_Fc8lbdYB80MaKb')->create($stripeToken,[
        //     'email' => 'sarabjeet.dhillon+20@sdnatech.com',
        // ]);

            // pa($stripeToken);die;
            
        // echo $customer->primary_email;    
        // die;    

        // $result = $customer->newSubscription('My Subscription', 'plan_Fc8mbkveh4Qnan')
        //     ->create($stripeToken->id, [
        //     'name' => 'SARABJEET DHILLON',
        //     'email' => $customer->primary_email,
        //     'description' => 'SARAB TEST'
        // ]);

        // pa($result);
    }

    public function StripeSubscriptionPost(Request $request){
       
       $allRequests = $request->all();
       $stripeToken = $request->stripeToken;
       Stripe::setApiKey(env('STRIPE_SECRET'));
       
       $customer = Customer::where('primary_email', $request->primary_email)->get();

       if($customer->count()== 0){
            $stripeCustomer = \Stripe\Customer::create([
                'source' => $stripeToken,
                'name' => $request->customer_name,
                'email' => $request->primary_email,
            ]);
            if($stripeCustomer){
                $name = explode(' ', $request->customer_name);
                $plan_starts_on = date('Y-m-d');
                $plan_ends_on = date('Y-m-d', strtotime('+1 year'));
                $next_billing_date = date('Y-m-d', strtotime('+1 month'));
                        
                $customer = Customer::create([
                        'primary_email' => $request->primary_email,
                        'first_name' => $name[0],
                        'last_name' => $name[count($name)-1],
                        'membership_plan_id' => $request->membership_plan_id,
                        'plan_starts_on' => $plan_starts_on,
                        'plan_ends_on' => $plan_ends_on,
                        'next_billing_date' => $next_billing_date,
                        'stripe_customer_id' => $stripeCustomer->id,
                    ]
                );
            }
       }
      
        $membership = Membership::find($request->membership_plan_id);
        $membership_cost = $membership->cost;

        $charge = \Stripe\Charge::create([
            "amount" => $membership_cost * 100, // convert to cents - stripe accepts in cents
            "currency" => "usd",
            "customer" => $customer->stripe_customer_id, // Stripe customer ID
            "description" => "Charge for ". $request->customer_name
        ]);

        if($charge){
            $payment = Payment::create([
                'customer_id' => $customer->id,
                'amount' => $membership_cost,
                'payment_type' => 'new_membership',
                'payment_status' => $charge->status,
                'stripe_charge_id' => $charge->id,
                'stripe_invoice' => $charge->invoice,
                'stripe_card_last_4' => $charge->source->last4,
                'stripe_card_exp_month' => $charge->source->exp_month,
                'stripe_card_exp_year' => $charge->source->exp_year,
                'stripe_receipt_url' => $charge->receipt_url,
                'stripe_currency' => $charge->currency,
                'raw_response' => json_encode($charge),
            ]);
        }    

        return Redirect::to('payment_success/'.$payment->id);
    }

    public function paymentSuccessPage($id){
        $payment = Payment::find($id);
        $link = $payment->stripe_receipt_url;
        
        return view('payment_success',['link'=>$link]);
    }


    //same as commange StripeCharge - will be removed from here
    public function charge($month=null, $year = null){
        if($month == null){
            $month = date('m');
        }
        if($year == null){
            $year = date('Y');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));
         

        // die;
         $customers = Customer::with('membership','last_visit','peak_hours_usage','off_peak_hours_usage')->where('next_billing_date',date('Y-m-d'))->get();

         $peak_hour_charge = 60; 
         $off_peak_hour_charge = 45;
         $discount_play = 15;  //in percent

        foreach($customers as $customer){
            // echo count($customer->peak_hours_usage);
            // pa($customer);die;
            $used_peak_hours = $used_off_peak_hours = 0;
            
            if(count($customer->peak_hours_usage)){
                $used_peak_hours = $customer->peak_hours_usage[0]->peak_hours_used; 
            }
            if(count($customer->off_peak_hours_usage)){
                $used_off_peak_hours = $customer->off_peak_hours_usage[0]->off_peak_hours_used; 
            }
            
            $included_peak_hours = $customer->membership->included_peak_hours;
            $included_off_peak_hours = $customer->membership->included_off_peak_hours;
   
            $additional = (($used_peak_hours - $included_peak_hours) * $peak_hour_charge) +  (($used_off_peak_hours - $included_off_peak_hours) * $off_peak_hour_charge);
            $additional_final = $additional - ($additional * $discount_play)/100;

            if($additional_final>0){
                $chargable_amount = $customer->membership->cost + $additional_final;
            }
            else{
                $chargable_amount = $customer->membership->cost;
            }
            // pa($chargable_amount);

            if($chargable_amount > 0){
                $charge = Charge::create([
                    "amount" => $chargable_amount * 100, //convert into cents
                    "currency" => "usd",
                    "customer" => $customer->stripe_customer_id,
                    "description" => "Play charges"
                  ]);

                if($charge){
                    $payment = Payment::create([
                        'customer_id' => $customer->id,
                        'amount' => $chargable_amount,
                        'payment_type' => $additional_final>0 ? 'membership_fee_plus_additional' : 'membership_fee' ,
                        'payment_status' => $charge->status,
                        'stripe_charge_id' => $charge->id,
                        'stripe_card_last_4' => $charge->source->last4,
                        'stripe_card_exp_month' => $charge->source->exp_month,
                        'stripe_card_exp_year' => $charge->source->exp_year,
                        'stripe_receipt_url' => $charge->receipt_url,
                        'stripe_currency' => $charge->currency,
                        'raw_response' => json_encode($charge),
                    ]);
                
                    //update next billing date
                    $next_billing_date = date('Y-m-d', strtotime('+1 month'));
                    if($next_billing_date != $customer->plan_ends_on)
                    {
                        $customer->next_billing_date = $next_billing_date;
                        $customer->save();
                    }
                }    
            }


        } 

       
    }




}
