@if(isset($setting) && $setting->phone)
<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $setting->phone) }}" target="_blank" style="position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px; background-color: #25d366; color: white; border-radius: 50%; text-align: center; font-size: 30px; box-shadow: 2px 2px 10px rgba(0,0,0,0.2); z-index: 9999; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
    <i class="ti-comments"></i>
</a>
@endif
