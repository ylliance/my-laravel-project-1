<div class="d-flex align-items-center">
    @can('member_edit')
        <a class="btn btn-outline-info btn-icon m-1 btn-sm" href="{{ route('members.edit', $member->id) }}">
            <span class="ul-btn__icon"><i class="fas fa-pencil-alt"></i></span>
        </a>
    @endcan
    @can('member_delete')
        <form action="{{ route('members.destroy', $member->id) }}" method="post" class="mb-0">
            @csrf
            @method('delete')
            <button type="button" class="btn btn-outline-danger btn-icon m-1 btn-sm"
                onclick="confirm('{{ __("Are you sure you want to delete this?") }}') ? this.parentElement.submit() : ''">
                <span class="ul-btn__icon"><i class="far fa-trash-alt"></i></span>
            </button>
        </form>
    @endcan
</div>