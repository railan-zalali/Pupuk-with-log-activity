<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('customer_id')->nullable();
            $table->datetimes('date');
            $table->decimal('total_amount', 12, 2);
            $table->decimal('paid_amount', 12, 2);
            $table->decimal('down_payment', 15, 2)->default(0);
            $table->decimal('change_amount', 12, 2);
            $table->enum('payment_method', ['cash', 'transfer', 'credit']);
            $table->string('payment_status')->default('paid');
            $table->decimal('remaining_amount', 15, 2)->default(0);
            $table->timestamp('due_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
