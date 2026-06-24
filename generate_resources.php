<?php

$fieldsData = json_decode(file_get_contents('model_fields.json'), true);

$config = [
    'WebSetting' => ['label' => 'Info Web', 'icon' => 'globe'],
    'VillageIdentity' => ['label' => 'Profil Desa', 'icon' => 'book-open'],
    'VillageStatistic' => ['label' => 'Data Statistik', 'icon' => 'bar-chart'],
    'Post' => ['label' => 'Publikasi', 'icon' => 'newspaper'],
    'Gallery' => ['label' => 'Galeri Foto', 'icon' => 'image'],
    'TourismUmkm' => ['label' => 'Wisata & UMKM', 'icon' => 'store'],
    'TourismUmkmImage' => ['label' => 'Foto Wisata', 'icon' => 'camera'],
    'VillageOfficial' => ['label' => 'Perangkat Desa', 'icon' => 'user-check'],
    'Institution' => ['label' => 'Lembaga', 'icon' => 'building'],
    'InstitutionMember' => ['label' => 'Pengurus Lembaga', 'icon' => 'users'],
    'RtRw' => ['label' => 'Data RT/RW', 'icon' => 'map'],
    'PpidOfficial' => ['label' => 'Petugas PPID', 'icon' => 'user-cog'],
    'PpidDocument' => ['label' => 'Produk Hukum', 'icon' => 'scale'],
    'ContactService' => ['label' => 'Kontak Layanan', 'icon' => 'phone-call'],
    'ServiceLetter' => ['label' => 'Layanan Surat', 'icon' => 'mail'],
    'Complaint' => ['label' => 'Pengaduan', 'icon' => 'message-square'],
    'EmergencyContact' => ['label' => 'Darurat', 'icon' => 'alert-triangle'],
    'Faq' => ['label' => 'Tanya Jawab', 'icon' => 'help-circle'],
    'User' => ['label' => 'Pengguna', 'icon' => 'user'],
    'Setting' => ['label' => 'Pengaturan', 'icon' => 'sliders'],
];

foreach ($fieldsData as $model => $fields) {
    if (!isset($config[$model])) continue;
    
    $label = $config[$model]['label'];
    $icon = $config[$model]['icon'];
    
    $formCode = "        return [\n";
    $tableCode = "        return [\n";
    
    $imports = [
        'MyLaravelTools\Panel\Resources\Resource',
        "App\Models\\$model",
        "MyLaravelTools\Panel\Fields\TextField",
        "MyLaravelTools\Panel\Columns\TextColumn",
    ];

    foreach ($fields as $field) {
        if (in_array($field, ['password', 'remember_token', 'created_at', 'updated_at'])) {
            if ($field === 'password') {
                $formCode .= "            TextField::make('$field')->type('password'),\n";
            }
            continue;
        }

        $fieldLabel = ucwords(str_replace('_', ' ', $field));
        
        // Basic mapping
        if (str_contains($field, 'is_')) {
            $imports[] = "MyLaravelTools\Panel\Fields\ToggleField";
            $imports[] = "MyLaravelTools\Panel\Columns\BooleanColumn";
            $formCode .= "            ToggleField::make('$field')->label('$fieldLabel'),\n";
            $tableCode .= "            BooleanColumn::make('$field')->label('$fieldLabel')->sortable(),\n";
        } elseif (str_contains($field, 'image') || str_contains($field, 'photo') || str_contains($field, 'logo') || str_contains($field, 'file') || str_contains($field, 'attachment')) {
            $imports[] = "MyLaravelTools\Panel\Fields\ImageField";
            $imports[] = "MyLaravelTools\Panel\Columns\ImageColumn";
            $formCode .= "            ImageField::make('$field')->label('$fieldLabel'),\n";
            $tableCode .= "            ImageColumn::make('$field')->label('$fieldLabel'),\n";
        } elseif (str_contains($field, 'content') || str_contains($field, 'description') || str_contains($field, 'answer')) {
            $imports[] = "MyLaravelTools\Panel\Fields\TextareaField";
            $formCode .= "            TextareaField::make('$field')->label('$fieldLabel'),\n";
        } else {
            $formCode .= "            TextField::make('$field')->label('$fieldLabel'),\n";
            $tableCode .= "            TextColumn::make('$field')->label('$fieldLabel')->searchable()->sortable(),\n";
        }
    }
    
    $formCode .= "        ];";
    $tableCode .= "        ];";
    
    $imports = array_unique($imports);
    sort($imports);
    
    $useStatements = implode("\n", array_map(fn($cls) => "use $cls;", $imports));

    $template = "<?php\n\ndeclare(strict_types=1);\n\nnamespace App\Panel\Resources;\n\n$useStatements\n\nfinal class {$model}Resource extends Resource\n{\n    protected static string \$model = $model::class;\n\n    protected static ?string \$label = '$label';\n\n    protected static ?string \$icon = '$icon';\n\n    public static function form(): array\n    {\n$formCode\n    }\n\n    public static function table(): array\n    {\n$tableCode\n    }\n}\n";

    file_put_contents("app/Panel/Resources/{$model}Resource.php", $template);
}

echo "Done generating resource contents.";
