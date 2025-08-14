<div class="d-flex align-items-center">
    @can('coupon_edit')
        <a class="btn btn-outline-info btn-icon m-1 btn-sm" href="{{ route('coupons.edit', $coupon->id) }}">
            <span class="ul-btn__icon"><i class="fas fa-pencil-alt"></i></span>
        </a>
    @endcan
    @can('coupon_delete')
        <form action="{{ route('coupons.destroy', $coupon->id) }}" method="post" class="mb-0">
            @csrf
            @method('delete')
            <button type="button" class="btn btn-outline-danger btn-icon m-1 btn-sm"
                onclick="confirm('{{ __("Are you sure you want to delete this?") }}') ? this.parentElement.submit() : ''">
                <span class="ul-btn__icon"><i class="far fa-trash-alt"></i></span>
            </button>
        </form>
    @endcan
</div>