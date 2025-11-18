**Laravel 12 & AdminLTE Trucking Management System** - Ringkasan Lengkap

## 🛠 **Tech Stack Specification**
- **Backend**: Laravel 12
- **Frontend**: AdminLTE 3 (Bootstrap 5)
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Breeze/Jetstream
- **Additional**: Livewire untuk komponen interaktif

## 📋 **Alur Aplikasi (Laravel Implementation)**

### **1. Master Data & Setup**
```
Routes: /containers, /trains, /depos, /trucks
Controllers: ContainerController, TrainController, DepoController
Models: Container, TrainShipment, Depo, ContainerMovement
```

### **2. Core Workflow Laravel**

```php
// Example Container Status Flow in Laravel
class ContainerController extends Controller
{
    public function updateStatus($containerId, $newStatus)
    {
        $container = Container::find($containerId);
        $container->previous_status = $container->current_status;
        $container->current_status = $newStatus;
        $container->save();
        
        // Log movement
        ContainerMovement::create([
            'container_id' => $containerId,
            'from_status' => $container->previous_status,
            'to_status' => $newStatus,
            'user_id' => auth()->id()
        ]);
        
        return redirect()->back()->with('success', 'Status updated');
    }
}
```

## 🚀 **Modul & Fitur (Laravel Structure)**

### **A. Authentication & Authorization**
```bash
php artisan make:model User -m
php artisan make:controller Auth/LoginController
```
- **Roles**: Admin, Manager, Operator, Driver
- **Permissions**: Spatie Laravel Permission package
- **Views**: AdminLTE login/register pages

### **B. Modul Inventory Container** 🏷️
```php
// Database Migration
Schema::create('containers', function (Blueprint $table) {
    $table->id();
    $table->string('container_number')->unique();
    $table->enum('size', ['20ft', '40ft', '45ft']);
    $table->enum('type', ['STANDARD', 'REEFER', 'FLATRACK']);
    $table->enum('status', [
        'ON_TRAIN', 'DISCH', 'FULL_OUT_CY', 
        'EMPTY_IN_CY', 'EMPTY_OUT_CY', 'FULL_IN_CY', 'LOAD'
    ]);
    $table->string('current_location');
    $table->foreignId('train_shipment_id')->nullable();
    $table->foreignId('depo_id')->nullable();
    $table->enum('condition', ['GOOD', 'DAMAGED', 'MAINTENANCE']);
    $table->boolean('is_borrowed')->default(false);
    $table->timestamps();
});
```

**Routes:**
```php
Route::resource('containers', ContainerController::class);
Route::post('containers/{id}/update-status', [ContainerController::class, 'updateStatus']);
```

### **C. Modul Train Management** 🚆
```php
// TrainShipment Model
class TrainShipment extends Model
{
    protected $fillable = [
        'train_number', 'train_name', 'origin_station',
        'destination_station', 'departure_time', 'estimated_arrival',
        'actual_arrival', 'wagon_count', 'status'
    ];
    
    public function containers()
    {
        return $this->hasMany(Container::class);
    }
}
```

**AdminLTE Blade View Example:**
```blade
@extends('adminlte::page')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Train Arrivals</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Train Number</th>
                    <th>Train Name</th>
                    <th>Origin</th>
                    <th>Estimated Arrival</th>
                    <th>Containers</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trains as $train)
                <tr>
                    <td>{{ $train->train_number }}</td>
                    <td>{{ $train->train_name }}</td>
                    <td>{{ $train->origin_station }}</td>
                    <td>{{ $train->estimated_arrival->format('d M Y H:i') }}</td>
                    <td>
                        <span class="badge bg-primary">{{ $train->containers_count }}</span>
                    </td>
                    <td>
                        <a href="{{ route('trains.process-arrival', $train->id) }}" 
                           class="btn btn-sm btn-success">
                            Process Arrival
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
```

### **D. Modul DEPO Management** 🏢
```php
// Depo Controller
class DepoController extends Controller
{
    public function emptyInCy()
    {
        $containers = Container::where('status', 'EMPTY_IN_CY')
                              ->with('depo')
                              ->paginate(20);
        return view('depo.empty-in-cy', compact('containers'));
    }
    
    public function processEmptyOut(Request $request, $containerId)
    {
        $container = Container::find($containerId);
        $container->update([
            'status' => 'EMPTY_OUT_CY',
            'purpose' => $request->purpose // 'STUFFING' or 'RETURN'
        ]);
        
        return back()->with('success', 'Container processed for empty out');
    }
}
```

### **E. Modul Trucking Operations** 🚛
```php
// TruckSchedule Model
class TruckSchedule extends Model
{
    protected $fillable = [
        'truck_id', 'driver_id', 'container_id', 
        'schedule_type', 'departure_time', 'estimated_arrival',
        'actual_arrival', 'status', 'origin', 'destination'
    ];
    
    public function container()
    {
        return $this->belongsTo(Container::class);
    }
    
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
```

## 🎨 **AdminLTE Dashboard Implementation**

### **Main Dashboard Blade**
```blade
@extends('adminlte::page')

@section('content')
<div class="row">
    <!-- Status Cards -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $onTrainCount }}</h3>
                <p>ON TRAIN</p>
            </div>
            <div class="icon">
                <i class="fas fa-train"></i>
            </div>
            <a href="{{ route('containers.index', ['status' => 'ON_TRAIN']) }}" 
               class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $emptyInCyCount }}</h3>
                <p>EMPTY IN CY</p>
            </div>
            <div class="icon">
                <i class="fas fa-box"></i>
            </div>
            <a href="{{ route('depo.empty-in-cy') }}" 
               class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<!-- Container Status Chart -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Container Status Distribution</h3>
    </div>
    <div class="card-body">
        <canvas id="containerStatusChart" height="100"></canvas>
    </div>
</div>
@endsection

@push('js')
<script>
    // Chart.js implementation for status distribution
    const ctx = document.getElementById('containerStatusChart').getContext('2d');
    const statusChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($statusLabels) !!},
            datasets: [{
                data: {!! json_encode($statusData) !!},
                backgroundColor: ['#ffc107', '#17a2b8', '#28a745', '#6c757d', '#dc3545', '#007bff', '#6610f2']
            }]
        }
    });
</script>
@endpush
```

### **Navigation Menu (config/adminlte.php)**
```php
return [
    'menu' => [
        [
            'text' => 'Dashboard',
            'url'  => '/dashboard',
            'icon' => 'fas fa-tachometer-alt',
        ],
        [
            'text'    => 'Container Management',
            'icon'    => 'fas fa-boxes',
            'submenu' => [
                [
                    'text' => 'All Containers',
                    'url'  => '/containers',
                ],
                [
                    'text' => 'Container Status',
                    'url'  => '/containers/status',
                ],
            ],
        ],
        [
            'text' => 'Train Management',
            'url'  => '/trains',
            'icon' => 'fas fa-train',
        ],
        [
            'text' => 'DEPO Management',
            'icon' => 'fas fa-warehouse',
            'submenu' => [
                [
                    'text' => 'EMPTY IN CY',
                    'url'  => '/depo/empty-in-cy',
                ],
                [
                    'text' => 'FULL IN CY',
                    'url'  => '/depo/full-in-cy',
                ],
            ],
        ],
    ],
];
```

## 🔄 **Laravel Workflow Implementation**

### **1. Train Arrival Workflow**
```php
// TrainController.php
public function processArrival($trainId)
{
    $train = TrainShipment::with('containers')->find($trainId);
    
    // Update train status
    $train->update([
        'status' => 'ARRIVED',
        'actual_arrival' => now()
    ]);
    
    // Update all containers to DISCH status
    $train->containers()->update([
        'status' => 'DISCH',
        'previous_status' => 'ON_TRAIN'
    ]);
    
    // Log movements
    foreach($train->containers as $container) {
        ContainerMovement::create([
            'container_id' => $container->id,
            'from_status' => 'ON_TRAIN',
            'to_status' => 'DISCH',
            'movement_type' => 'TRAIN_ARRIVAL',
            'user_id' => auth()->id()
        ]);
    }
    
    return redirect()->route('trains.show', $trainId)
                    ->with('success', 'Train arrival processed successfully');
}
```

### **2. Container Status Change Livewire Component**
```php
// app/Http/Livewire/ContainerStatusUpdate.php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Container;

class ContainerStatusUpdate extends Component
{
    public $container;
    public $selectedStatus;
    
    protected $rules = [
        'selectedStatus' => 'required|in:ON_TRAIN,DISCH,FULL_OUT_CY,EMPTY_IN_CY,EMPTY_OUT_CY,FULL_IN_CY,LOAD'
    ];
    
    public function updateStatus()
    {
        $this->validate();
        
        $previousStatus = $this->container->status;
        $this->container->update(['status' => $this->selectedStatus]);
        
        // Log movement
        ContainerMovement::create([
            'container_id' => $this->container->id,
            'from_status' => $previousStatus,
            'to_status' => $this->selectedStatus,
            'user_id' => auth()->id()
        ]);
        
        session()->flash('message', 'Container status updated successfully');
        $this->emit('statusUpdated');
    }
    
    public function render()
    {
        return view('livewire.container-status-update');
    }
}
```

## 📊 **Laravel Reporting & Analytics**

### **Report Controller**
```php
class ReportController extends Controller
{
    public function containerStatusReport()
    {
        $statusCounts = Container::select('status', DB::raw('count(*) as count'))
                                ->groupBy('status')
                                ->get();
        
        return view('reports.container-status', compact('statusCounts'));
    }
    
    public function trainPerformanceReport()
    {
        $trains = TrainShipment::withCount('containers')
                              ->with('containers')
                              ->where('actual_arrival', '!=', null)
                              ->orderBy('created_at', 'desc')
                              ->paginate(10);
        
        return view('reports.train-performance', compact('trains'));
    }
}
```

## 🗃️ **Database Seeder for Development**
```php
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            DepoSeeder::class,
            TrainShipmentSeeder::class,
            ContainerSeeder::class,
        ]);
    }
}
```

## 📦 **Package Dependencies (composer.json)**
```json
{
    "require": {
        "laravel/framework": "^12.0",
        "jeroennoten/laravel-adminlte": "^3.0",
        "spatie/laravel-permission": "^5.0",
        "livewire/livewire": "^3.0",
        "maatwebsite/excel": "^3.1"
    }
}
```

## 🚀 **Development Roadmap**

### **Phase 1: Foundation (Week 1-2)**
- Laravel 12 setup dengan AdminLTE
- Authentication & role management
- Basic models and migrations

### **Phase 2: Core Modules (Week 3-4)**
- Container CRUD dengan status management
- Train management system
- DEPO management interface

### **Phase 3: Workflow Integration (Week 5-6)**
- Container status workflow
- Truck scheduling system
- Real-time updates dengan Livewire

### **Phase 4: Reporting & Analytics (Week 7-8)**
- Advanced reporting
- Chart.js integration
- Export functionality

### **Phase 5: Polish & Deployment (Week 9-10)**
- Testing & bug fixes
- Performance optimization
- Deployment preparation

## 💡 **Key Laravel Features Utilized**
- **Eloquent Relationships** untuk model connectivity
- **Middleware** untuk authorization
- **Events & Listeners** untuk status notifications
- **Policies** untuk access control
- **Resource Controllers** untuk clean API
- **Blade Components** untuk reusable UI
