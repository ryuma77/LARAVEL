<?php

namespace App\Http\Controllers;

use App\Models\BusinessPartner;
use App\Models\BPContact;
use App\Models\BPAddress;
use App\Models\BPAccounting;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;

class BusinessPartnerController extends Controller
{
    /* ----------------------------------------------------
     | HEADER
     ---------------------------------------------------- */
    public function index()
    {
        $partners = BusinessPartner::orderBy('name')->paginate(20);
        return view('business-partner.index', compact('partners'));
    }

    public function create()
    {
        return view('business-partner.create');
    }

    public function store(Request $r)
    {
        $r->validate([
            'code' => 'required|unique:business_partners,code',
            'name' => 'required',
            'type' => 'required|in:customer,vendor,both',
        ]);

        $bp = BusinessPartner::create([
            'code'           => $r->code,
            'name'           => $r->name,
            'type'           => $r->type,
            'tax_id'         => $r->tax_id,
            'phone'          => $r->phone,
            'email'          => $r->email,
            'website'        => $r->website,
            'credit_limit'   => $r->credit_limit ?? 0,
            'payment_term_id' => $r->payment_term_id,
            'description'    => $r->description,
            'is_active'      => true,
        ]);

        // setelah create → redirect ke edit agar tab contact/address/accounting bisa digunakan
        return redirect()->route('business-partner.edit', $bp->id)
            ->with('success', 'Business Partner created');
    }

    public function edit(BusinessPartner $business_partner)
    {
        $bp = $business_partner;

        $coa = ChartOfAccount::orderBy('code')->get();

        return view('business-partner.edit', [
            'bp' => $bp,
            'coa' => $coa,
        ]);
    }

    public function update(Request $r, BusinessPartner $business_partner)
    {
        $business_partner->update([
            'code'           => $r->code,
            'name'           => $r->name,
            'type'           => $r->type,
            'tax_id'         => $r->tax_id,
            'phone'          => $r->phone,
            'email'          => $r->email,
            'website'        => $r->website,
            'credit_limit'   => $r->credit_limit,
            'payment_term_id' => $r->payment_term_id,
            'description'    => $r->description,
            'is_active'      => $r->is_active ? true : false,
        ]);

        return back()->with('success', 'Business Partner updated');
    }

    /* ----------------------------------------------------
     | CONTACT
     ---------------------------------------------------- */
    public function storeContact(Request $r, BusinessPartner $business_partner)
    {
        $r->validate([
            'name' => 'required',
        ]);

        BPContact::create([
            'business_partner_id' => $business_partner->id,
            'name'         => $r->name,
            'phone'        => $r->phone,
            'email'        => $r->email,
            'job_title'    => $r->job_title,
        ]);

        return back()->with('success', 'Contact added');
    }

    public function deleteContact(BPContact $contact)
    {
        $contact->delete();
        return back()->with('success', 'Contact deleted');
    }

    /* ----------------------------------------------------
     | ADDRESS
     ---------------------------------------------------- */
    public function storeAddress(Request $r, BusinessPartner $business_partner)
    {
        $r->validate([
            'address_line1' => 'required',
            'address_type'  => 'required|in:billing,shipping,other',
        ]);

        BPAddress::create([
            'business_partner_id' => $business_partner->id,
            'address_type'  => $r->address_type,
            'address_line1' => $r->address_line1,
            'address_line2' => $r->address_line2,
            'city'          => $r->city,
            'state'         => $r->state,
            'country'       => $r->country,
            'postal_code'   => $r->postal_code,
        ]);

        return back()->with('success', 'Address added');
    }

    public function deleteAddress(BPAddress $address)
    {
        $address->delete();
        return back()->with('success', 'Address deleted');
    }

    /* ----------------------------------------------------
     | ACCOUNTING
     ---------------------------------------------------- */
    public function updateAccounting(Request $r, BusinessPartner $business_partner)
    {
        BPAccounting::updateOrCreate(
            ['business_partner_id' => $business_partner->id],
            [
                'ar_account_id' => $r->ar_account_id,
                'ap_account_id' => $r->ap_account_id,
            ]
        );

        return back()->with('success', 'Accounting updated');
    }
}
