<form method="post" action="{{ route('admin.inputs.destroy', $input->id) }}" style="display: inline-block;">
    @csrf
    @method('DELETE')
    <a href="{{ route('admin.inputs.edit', $input->id) }}" class="btn btn-primary btn-xs">
        <span class="fa fa-pencil"></span> ویرایش
    </a>
    <button type="submit" name="delete" class="btn btn-danger btn-xs">
        <span class="fa fa-trash"></span> حذف
    </button>
</form>
