   <?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   return new class extends Migration
   {
       public function up()
       {
           Schema::create('audit_logs', function (Blueprint $table) {
               $table->id();
               $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
               $table->string('action'); // ex: create, update, delete, access_denied
               $table->string('model_type')->nullable(); // ex: App\Models\Courrier
               $table->unsignedBigInteger('model_id')->nullable();
               $table->text('description');
               $table->string('ip_address', 45)->nullable();
               $table->text('user_agent')->nullable();
               $table->timestamps();
               
               $table->index(['user_id', 'action']);
               $table->index('created_at');
           });
       }

       public function down()
       {
           Schema::dropIfExists('audit_logs');
       }
   };