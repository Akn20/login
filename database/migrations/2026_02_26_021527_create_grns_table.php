
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grns', function (Blueprint $table) {
            $table->id();

            $table->string('grn_no')->unique();                 // GRN-0001
            $table->date('grn_date');

            $table->string('vendor_name');                      // for now keep name (later vendor_id)
            $table->string('invoice_no');
            $table->date('invoice_date');
            $table->string('invoice_file')->nullable();

            $table->string('po_no')->nullable();
            $table->string('status')->default('Draft');         // Draft/Submitted/Verified/Completed/Cancelled
            $table->text('remarks')->nullable();
            $table->string('verify_remarks')->nullable();
            $table->string('reject_reason')->nullable();

            $table->decimal('sub_total', 12, 2)->default(0);
            $table->decimal('total_discount', 12, 2)->default(0);
            $table->decimal('total_tax', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2)->default(0);

            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grns');
    }
};