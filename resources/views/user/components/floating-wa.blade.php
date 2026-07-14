@if(!empty($contactServicePhone))
<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactServicePhone) }}" target="_blank" class="floating-whatsapp" onmouseout="this.style.transform='scale(1)'">
    <i class="ti-comments"></i>
</a>
@endif
