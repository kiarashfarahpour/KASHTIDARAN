<form method="post" action="{{ route('admin.forms.destroy', $form->id) }}" style="display: inline-block;">
    @csrf
    @method('DELETE')
    <a href="{{ route('admin.forms.edit', $form->id) }}" class="btn btn-primary btn-xs">
        <span class="fa fa-pencil"></span> ویرایش
    </a>
    <a href="{{ route('admin.inputs.index', $form->id) }}" class="btn btn-default btn-xs">
        <span class="fa fa-tasks"></span> فیلدها
    </a>
    <button type="submit" name="delete" class="btn btn-danger btn-xs">
        <span class="fa fa-trash"></span> حذف
    </button>
</form>
