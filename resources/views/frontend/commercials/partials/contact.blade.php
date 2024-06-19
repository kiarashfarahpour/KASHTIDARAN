<li>
    <strong>شماره تماس:</strong>
    <a href="tel:{{ $commercial->user->mobile }}"><span class="fa fa-phone"></span> <span>{{ $commercial->user->mobile }}</span></a>
</li>
@if($commercial->whatsapp)
<li class="mt-4">
    <strong>شماره واتس اپ:</strong>
    @php
        $text = 'سلام، آگهی (' . $commercial->title . ') شماره (' . $commercial->id . ') شما را در وب سایت *کشتی داران* دیدم .

        ' . url('/');
    @endphp
    <a href="https://api.whatsapp.com/send?phone=+98{{ ltrim(to_latin_numbers($commercial->whatsapp), '0') }}&text={{ $text }}" class="text-success">
        <span class="fab fa-whatsapp"></span> <span>{{ $commercial->whatsapp }}</span>
    </a>
</li>
@endif