<form method="post" action="{{ route('admin.provinces.destroy', $province->code) }}" style="display: inline-block;">
    @csrf
    @method('DELETE')
    <a href="{{ route('admin.provinces.edit', $province->code) }}" class="btn btn-primary btn-xs">
        <span class="fa fa-pencil"></span> ویرایش
    </a>
    <button type="submit" name="delete" class="btn btn-danger btn-xs">
        <span class="fa fa-trash"></span> حذف
    </button>
</form>
