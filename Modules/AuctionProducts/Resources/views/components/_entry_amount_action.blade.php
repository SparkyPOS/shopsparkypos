<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('common.select') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">

        <a href="{{ route('auctionproducts.entryAmountDetails',$payment->id) }}" class="dropdown-item details" >{{__('auctionproduct.details')}}</a>

    </div>
</div>
