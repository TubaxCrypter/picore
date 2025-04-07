<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MakeCrud extends Command
{
    /**
     * Komut tanımı
     *
     * @var string
     */
    protected $signature = 'make:crud 
                            {name : Modül adı (tekil)}
                            {--model : Model oluştur}
                            {--migration : Migration oluştur}
                            {--controller : Controller oluştur}
                            {--api : API Controller oluştur}
                            {--force : Var olan dosyaların üzerine yaz}';

    /**
     * Komut açıklaması
     *
     * @var string
     */
    protected $description = 'Vue.js bileşenleri dahil tam bir CRUD modülü oluşturur';

    /**
     * Stub klasörü
     */
    protected $stubDir = __DIR__ . '/stubs';

    /**
     * Crud yapısını oluştur
     */
    public function handle()
    {
        $name = $this->argument('name');
        
        // İsim dönüşümleri
        $modelName = Str::studly(Str::singular($name));
        $modelNamePlural = Str::studly(Str::plural($name));
        $modelNamePluralLowerCase = Str::camel(Str::plural($name));
        $modelNameLowerCase = Str::camel(Str::singular($name));
        $modelNamePluralKebab = Str::kebab(Str::plural($name));
        $modelNamePluralSnake = Str::snake(Str::plural($name));
        
        // Vue bileşenlerini oluştur
        $this->createVueComponents($modelName, $modelNamePlural, $modelNamePluralLowerCase, $modelNameLowerCase, $modelNamePluralKebab);
        
        // Controller oluştur
        if ($this->option('controller')) {
            $this->createController($modelName, $modelNamePlural);
        }
        
        // API Controller oluştur
        if ($this->option('api')) {
            $this->createApiController($modelName, $modelNamePlural);
        }
        
        // Model oluştur
        if ($this->option('model')) {
            $this->createModel($modelName, $modelNamePlural);
        }
        
        // Migration oluştur
        if ($this->option('migration')) {
            $this->createMigration($modelName, $modelNamePlural, $modelNamePluralSnake);
        }
        
        // Rotaları ekle
        $this->addRoutes($modelName, $modelNamePluralKebab);
        
        $this->info("$modelName için CRUD işlemleri başarıyla oluşturuldu.");
    }
    
    /**
     * Vue bileşenlerini oluştur
     */
    protected function createVueComponents($modelName, $modelNamePlural, $modelNamePluralLowerCase, $modelNameLowerCase, $modelNamePluralKebab)
    {
        // Bileşenlerin klasörlerini oluştur
        $componentsDir = resource_path('js/Components/' . $modelName);
        if (!File::exists($componentsDir)) {
            File::makeDirectory($componentsDir, 0755, true);
        }
        
        $pageDir = resource_path('js/Pages/' . $modelNamePlural);
        if (!File::exists($pageDir)) {
            File::makeDirectory($pageDir, 0755, true);
        }
        
        // Index bileşeni oluştur
        $indexContent = $this->getStub('vue/index.stub', [
            '{{modelName}}' => $modelName,
            '{{modelNamePlural}}' => $modelNamePlural,
            '{{modelNamePluralLowerCase}}' => $modelNamePluralLowerCase,
            '{{modelNameLowerCase}}' => $modelNameLowerCase,
            '{{modelNamePluralKebab}}' => $modelNamePluralKebab,
        ]);
        
        File::put($pageDir . '/Index.vue', $indexContent);
        $this->info("Vue Index bileşeni oluşturuldu: " . $pageDir . '/Index.vue');
        
        // Modal bileşeni oluştur
        $modalContent = $this->getStub('vue/modal.stub', [
            '{{modelName}}' => $modelName,
            '{{modelNamePlural}}' => $modelNamePlural,
            '{{modelNamePluralLowerCase}}' => $modelNamePluralLowerCase,
            '{{modelNameLowerCase}}' => $modelNameLowerCase,
            '{{modelNamePluralKebab}}' => $modelNamePluralKebab,
        ]);
        
        File::put($componentsDir . '/' . $modelName . 'Modal.vue', $modalContent);
        $this->info("Vue Modal bileşeni oluşturuldu: " . $componentsDir . '/' . $modelName . 'Modal.vue');
        
        // View bileşeni oluştur
        $viewContent = $this->getStub('vue/view.stub', [
            '{{modelName}}' => $modelName,
            '{{modelNamePlural}}' => $modelNamePlural,
            '{{modelNamePluralLowerCase}}' => $modelNamePluralLowerCase,
            '{{modelNameLowerCase}}' => $modelNameLowerCase,
            '{{modelNamePluralKebab}}' => $modelNamePluralKebab,
        ]);
        
        File::put($componentsDir . '/' . $modelName . 'View.vue', $viewContent);
        $this->info("Vue View bileşeni oluşturuldu: " . $componentsDir . '/' . $modelName . 'View.vue');
        
        // Delete Confirm bileşeni oluştur
        $deleteContent = $this->getStub('vue/delete-confirm.stub', [
            '{{modelName}}' => $modelName,
            '{{modelNamePlural}}' => $modelNamePlural,
            '{{modelNamePluralLowerCase}}' => $modelNamePluralLowerCase,
            '{{modelNameLowerCase}}' => $modelNameLowerCase,
            '{{modelNamePluralKebab}}' => $modelNamePluralKebab,
        ]);
        
        File::put($componentsDir . '/' . $modelName . 'DeleteConfirm.vue', $deleteContent);
        $this->info("Vue Delete Confirm bileşeni oluşturuldu: " . $componentsDir . '/' . $modelName . 'DeleteConfirm.vue');
    }
    
    /**
     * Controller oluştur
     */
    protected function createController($modelName, $modelNamePlural)
    {
        $controllerPath = app_path('Http/Controllers/' . $modelName . 'Controller.php');
        
        if (File::exists($controllerPath) && !$this->option('force')) {
            if (!$this->confirm("Controller zaten var. Üzerine yazmak istiyor musunuz?")) {
                return;
            }
        }
        
        $controllerContent = $this->getStub('controller.stub', [
            '{{modelName}}' => $modelName,
            '{{modelNamePlural}}' => $modelNamePlural,
        ]);
        
        File::put($controllerPath, $controllerContent);
        $this->info("Controller oluşturuldu: " . $controllerPath);
    }
    
    /**
     * API Controller oluştur
     */
    protected function createApiController($modelName, $modelNamePlural)
    {
        $apiDir = app_path('Http/Controllers/Api');
        if (!File::exists($apiDir)) {
            File::makeDirectory($apiDir, 0755, true);
        }
        
        $controllerPath = $apiDir . '/' . $modelName . 'Controller.php';
        
        if (File::exists($controllerPath) && !$this->option('force')) {
            if (!$this->confirm("API Controller zaten var. Üzerine yazmak istiyor musunuz?")) {
                return;
            }
        }
        
        $controllerContent = $this->getStub('api-controller.stub', [
            '{{modelName}}' => $modelName,
            '{{modelNamePlural}}' => $modelNamePlural,
        ]);
        
        File::put($controllerPath, $controllerContent);
        $this->info("API Controller oluşturuldu: " . $controllerPath);
    }
    
    /**
     * Model oluştur
     */
    protected function createModel($modelName, $modelNamePlural)
    {
        $modelPath = app_path('Models/' . $modelName . '.php');
        
        if (File::exists($modelPath) && !$this->option('force')) {
            if (!$this->confirm("Model zaten var. Üzerine yazmak istiyor musunuz?")) {
                return;
            }
        }
        
        $modelContent = $this->getStub('model.stub', [
            '{{modelName}}' => $modelName,
            '{{modelNamePlural}}' => $modelNamePlural,
        ]);
        
        File::put($modelPath, $modelContent);
        $this->info("Model oluşturuldu: " . $modelPath);
    }
    
    /**
     * Migration oluştur
     */
    protected function createMigration($modelName, $modelNamePlural, $modelNamePluralSnake)
    {
        $timestamp = date('Y_m_d_His');
        $migrationPath = database_path('migrations/' . $timestamp . '_create_' . $modelNamePluralSnake . '_table.php');
        
        $migrationContent = $this->getStub('migration.stub', [
            '{{modelName}}' => $modelName,
            '{{modelNamePlural}}' => $modelNamePlural,
            '{{modelNamePluralSnake}}' => $modelNamePluralSnake,
        ]);
        
        File::put($migrationPath, $migrationContent);
        $this->info("Migration oluşturuldu: " . $migrationPath);
    }
    
    /**
     * Stub dosyasını al ve değiştir
     */
    protected function getStub($path, $replacements = [])
    {
        $content = File::get($this->stubDir . '/' . $path);
        
        foreach ($replacements as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }
        
        return $content;
    }

    /**
     * Rotaları web.php dosyasına ekle
     */
    protected function addRoutes($modelName, $modelNamePluralKebab)
    {
        $routesPath = base_path('routes/web.php');
        $routeContent = File::get($routesPath);

        // Rota kontrolü - zaten varsa ekleme
        if (strpos($routeContent, "Route::get('/$modelNamePluralKebab'") !== false) {
            $this->info("Rotalar zaten eklenmiş, atlıyorum.");
            return;
        }

        // Auth middleware grup içinde olup olmadığını kontrol et
        $authGroupPattern = '/Route::middleware\(\[\'auth\',\s*\'verified\'\]\)->group\(function\s*\(\)\s*{(.*?)}\);/s';
        if (preg_match($authGroupPattern, $routeContent, $matches)) {
            // Grup içine rotaları ekle
            $routesBlock = "\n    // $modelName rotaları\n";
            $routesBlock .= "    Route::get('/$modelNamePluralKebab', [App\\Http\\Controllers\\{$modelName}Controller::class, 'index'])->name('$modelNamePluralKebab.index');\n";
            $routesBlock .= "    Route::post('/$modelNamePluralKebab', [App\\Http\\Controllers\\{$modelName}Controller::class, 'store'])->name('$modelNamePluralKebab.store');\n";
            $routesBlock .= "    Route::put('/$modelNamePluralKebab/{" . Str::camel($modelName) . "}', [App\\Http\\Controllers\\{$modelName}Controller::class, 'update'])->name('$modelNamePluralKebab.update');\n";
            $routesBlock .= "    Route::delete('/$modelNamePluralKebab/{" . Str::camel($modelName) . "}', [App\\Http\\Controllers\\{$modelName}Controller::class, 'destroy'])->name('$modelNamePluralKebab.destroy');";

            $newGroupContent = str_replace(
                $matches[1],
                $matches[1] . $routesBlock,
                $matches[0]
            );
            $routeContent = str_replace($matches[0], $newGroupContent, $routeContent);
        } else {
            // Yeni auth grup oluştur
            $routesBlock = "\nRoute::middleware(['auth', 'verified'])->group(function () {\n";
            $routesBlock .= "    // $modelName rotaları\n";
            $routesBlock .= "    Route::get('/$modelNamePluralKebab', [App\\Http\\Controllers\\{$modelName}Controller::class, 'index'])->name('$modelNamePluralKebab.index');\n";
            $routesBlock .= "    Route::post('/$modelNamePluralKebab', [App\\Http\\Controllers\\{$modelName}Controller::class, 'store'])->name('$modelNamePluralKebab.store');\n";
            $routesBlock .= "    Route::put('/$modelNamePluralKebab/{" . Str::camel($modelName) . "}', [App\\Http\\Controllers\\{$modelName}Controller::class, 'update'])->name('$modelNamePluralKebab.update');\n";
            $routesBlock .= "    Route::delete('/$modelNamePluralKebab/{" . Str::camel($modelName) . "}', [App\\Http\\Controllers\\{$modelName}Controller::class, 'destroy'])->name('$modelNamePluralKebab.destroy');\n";
            $routesBlock .= "});\n";

            // require __DIR__.'/auth.php'; satırının hemen üstüne ekle
            $routeContent = preg_replace(
                '/(require __DIR__\.\'\/auth\.php\';)/',
                $routesBlock . "\n$1",
                $routeContent
            );
        }

        File::put($routesPath, $routeContent);
        $this->info("Rotalar web.php dosyasına eklendi.");
    }
} 