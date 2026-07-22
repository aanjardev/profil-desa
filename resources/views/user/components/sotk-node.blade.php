<li>
    <div class="org-node">
        @php
            $typeStyles = match($official->type) {
                'legislatif' => ['border' => '#9333ea', 'badge_bg' => '#f3e8ff', 'badge_text' => '#7e22ce', 'badge_label' => '⚖️ BPD / Legislatif', 'header' => '#9333ea'],
                'kasun'      => ['border' => '#d97706', 'badge_bg' => '#fef3c7', 'badge_text' => '#92400e', 'badge_label' => '🏘️ Kasun', 'header' => '#d97706'],
                'staf'       => ['border' => '#94a3b8', 'badge_bg' => '#f1f5f9', 'badge_text' => '#475569', 'badge_label' => '👤 Staf', 'header' => '#94a3b8'],
                default      => ['border' => '#3b82f6', 'badge_bg' => '#eff6ff', 'badge_text' => '#1d4ed8', 'badge_label' => '🏛️ Eksekutif', 'header' => '#3b82f6'],
            };
        @endphp

        <div class="official-card" style="border-top: 3px solid {{ $typeStyles['border'] }};">

            <div class="official-photo-wrapper">
                @if($official->photo)
                    <img src="{{ asset('storage/'.$official->photo) }}" alt="{{ $official->name }}" class="official-photo">
                @else
                    <i class="ti-user official-photo-placeholder"></i>
                @endif
            </div>
            <div class="g-padding-x-15--xs g-padding-b-15--xs">
                <h3 class="g-font-size-16--xs g-font-weight--700 g-margin-b-5--xs" style="color: #2d3748; line-height: 1.2;">{{ $official->name }}</h3>
                <p class="g-font-size-12--xs g-font-weight--600 g-margin-b-5--xs" style="color: {{ $typeStyles['border'] }};">{{ $official->position }}</p>
                @if($official->nip)
                    <p class="g-font-size-11--xs" style="color: #a0aec0; margin-bottom: 0;">NIP: {{ $official->nip }}</p>
                @endif
            </div>
        </div>
    </div>
    
    @php
        $children = $allOfficials->where('parent_id', $official->id)->sortBy('order_num');
    @endphp

    @if($children->count() > 0)
        <ul>
            @foreach($children as $child)
                @include('user.components.sotk-node', ['official' => $child, 'allOfficials' => $allOfficials])
            @endforeach
        </ul>
    @endif
</li>
