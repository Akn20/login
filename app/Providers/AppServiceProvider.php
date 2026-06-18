<?php

namespace App\Providers;

use App\Models\IpdDischarge;
use App\Models\IpdPrescription;
use App\Models\LabRequest;
use App\Models\RadiologyReport;
use App\Observers\IpdDischargeObserver;
use App\Observers\IpdPrescriptionObserver;
use App\Observers\LabRequestObserver;
use App\Observers\RadiologyReportObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Module;
use App\Models\Consultation;
use App\Observers\ConsultationObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Consultation::observe(ConsultationObserver::class);
        Consultation::observe(ConsultationObserver::class);

        LabRequest::observe(LabRequestObserver::class);

        IpdDischarge::observe(IpdDischargeObserver::class);

        IpdPrescription::observe(IpdPrescriptionObserver::class);

        RadiologyReport::observe(RadiologyReportObserver::class);
        View::composer('*', function ($view) {

            $modules = Module::whereNull('parent_module')
                ->where('status', 1)
                ->orderBy('priority')
                ->with([
                    'children' => function ($q) {
                        $q->where('status', 1)->orderBy('priority');
                    }
                ])
                ->get();

            $view->with('sidebarModules', $modules);
        });
        Paginator::useBootstrap();
    }
}
