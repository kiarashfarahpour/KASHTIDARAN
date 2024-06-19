<form method="post" action="{{ route('admin.contacts.destroy', $contact->id) }}" style="display: inline-block;">
    @csrf
    @method('DELETE')
    <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-primary btn-xs">
        <span class="fa fa-eye"></span> مشاهده
    </a>
    <button type="submit" name="delete" class="btn btn-danger btn-xs">
        <span class="fa fa-trash"></span> حذف
    </button>
</form>
