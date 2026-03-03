<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('apis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('base_url');
            $table->boolean('status')->default(true);
            $table->unsignedInteger('rate_limit_per_minute')->default(60);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['tenant_id', 'slug']);
            $table->index(['tenant_id', 'status']);
        });

        Schema::create('api_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('api_id')->constrained()->cascadeOnDelete();
            $table->string('version');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->unique(['api_id', 'version']);
        });

        Schema::create('api_keys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('api_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('prefix', 16)->index();
            $table->string('key_hash');
            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamp('revoked_at')->nullable()->index();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['tenant_id', 'user_id', 'api_id']);
        });

        Schema::create('request_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('api_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('api_key_id')->nullable()->constrained('api_keys')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('endpoint');
            $table->string('method', 10);
            $table->unsignedSmallInteger('status_code');
            $table->unsignedInteger('response_time_ms');
            $table->ipAddress('ip_address');
            $table->timestamp('requested_at')->index();
            $table->timestamps();
            $table->index(['tenant_id', 'status_code', 'requested_at']);
            $table->index(['tenant_id', 'api_id', 'requested_at']);
        });

        Schema::create('webhook_endpoints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('event');
            $table->string('url');
            $table->string('secret');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(['tenant_id', 'event', 'is_active']);
        });

        Schema::create('usage_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('api_id')->constrained()->cascadeOnDelete();
            $table->foreignId('api_key_id')->nullable()->constrained('api_keys')->nullOnDelete();
            $table->date('period_start');
            $table->date('period_end');
            $table->unsignedBigInteger('requests_count')->default(0);
            $table->unsignedBigInteger('billable_units')->default(0);
            $table->timestamps();
            $table->unique(['tenant_id', 'api_id', 'api_key_id', 'period_start', 'period_end'], 'usage_unique_period');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usage_records');
        Schema::dropIfExists('webhook_endpoints');
        Schema::dropIfExists('request_logs');
        Schema::dropIfExists('api_keys');
        Schema::dropIfExists('api_versions');
        Schema::dropIfExists('apis');
    }
};
