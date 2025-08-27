# Lilium Night Platform - Technical Analysis for Laravel/Filament Replication

## 1. Project Overview & Core Functionality

### Primary Purpose
Lilium Night is a comprehensive Arabic-language event management platform that connects customers with service providers for various types of events and occasions. It serves as a marketplace for event-related services including venues, catering, photography, beauty services, entertainment, and more.

### Business Objectives
- **Marketplace Creation**: Connect event service providers with customers
- **Digital Transformation**: Modernize traditional event booking processes
- **Revenue Generation**: Commission-based model from successful bookings
- **Quality Assurance**: Review and rating system for service quality
- **Operational Efficiency**: Automated booking, payment, and contract management

### Target User Types & Roles

#### 1. Customers (العملاء)
- **Primary Role**: Book event services
- **Capabilities**: Browse services, make bookings, payments, reviews
- **Dashboard Features**: Booking management, payment history, rewards program

#### 2. Merchants/Service Providers (مزودو الخدمات)
- **Primary Role**: Offer event services
- **Capabilities**: Service management, booking calendar, financial tracking
- **Dashboard Features**: Comprehensive business management tools

#### 3. Partners/Affiliates (الشركاء)
- **Primary Role**: Refer new merchants to the platform
- **Capabilities**: Track referrals, earn commissions
- **Dashboard Features**: Referral tracking, payout management

#### 4. Administrators (الإدارة)
- **Primary Role**: Platform management and oversight
- **Capabilities**: User management, financial oversight, content management
- **Dashboard Features**: Complete platform administration

### Key Features & Capabilities

#### Core Booking System
- Multi-service booking with package combinations
- Real-time availability calendar management
- Dynamic pricing and promotional systems
- Online and offline booking channels

#### Financial Management
- Integrated payment processing (Stripe, local payment methods)
- Commission-based revenue model
- Automated payout systems
- Financial reporting and analytics

#### Contract & Legal
- Electronic contract signing (DocuSign integration)
- Template-based contract generation
- Legal compliance and terms management

#### Communication & Support
- Multi-channel messaging system
- Notification management (email, SMS, push)
- Support ticket system
- Review and rating system

## 2. System Architecture & Components

### Frontend Architecture (React-based)
```
src/
├── components/
│   ├── admin-dashboard/          # Admin management interfaces
│   ├── customer-dashboard/       # Customer self-service portal
│   ├── merchant-dashboard/       # Service provider management
│   ├── partner-dashboard/        # Affiliate/partner tools
│   ├── layout/                   # Shared layout components
│   ├── pages/                    # Main application pages
│   └── ui/                       # Reusable UI components
```

### Backend Services (To be implemented in Laravel)

#### Core Modules
1. **User Management Service**
   - Multi-role authentication
   - Profile management
   - Permission-based access control

2. **Booking Management Service**
   - Service catalog management
   - Availability calendar
   - Reservation processing
   - Package creation and management

3. **Financial Service**
   - Payment processing
   - Commission calculations
   - Payout management
   - Financial reporting

4. **Communication Service**
   - Notification system
   - Messaging platform
   - Email campaigns
   - SMS integration

5. **Content Management Service**
   - Service listings
   - Media management
   - Review system
   - Legal document management

### Third-party Integrations

#### Payment Gateways
- **Stripe**: International payments
- **Tamara**: Buy now, pay later (BNPL)
- **Tabby**: Alternative BNPL solution
- **Local Saudi payment methods**

#### Communication Services
- **SendGrid**: Email delivery
- **Twilio**: SMS services
- **Push notification services**

#### Document Management
- **DocuSign**: Electronic signatures
- **File storage solutions**

#### Analytics & Monitoring
- **Google Analytics**: Web analytics
- **Custom analytics dashboard**

## 3. Database Design & Structure

### Core Tables Schema

#### Users Table
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NULL,
    avatar VARCHAR(255) NULL,
    user_type ENUM('customer', 'merchant', 'partner', 'admin') NOT NULL,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    language VARCHAR(5) DEFAULT 'ar',
    timezone VARCHAR(50) DEFAULT 'Asia/Riyadh',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_user_type (user_type),
    INDEX idx_status (status),
    INDEX idx_email (email)
);
```

#### Merchants Table
```sql
CREATE TABLE merchants (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    business_name VARCHAR(255) NOT NULL,
    business_type VARCHAR(100) NOT NULL,
    cr_number VARCHAR(50) UNIQUE NOT NULL,
    business_address TEXT NULL,
    city VARCHAR(100) NOT NULL,
    verification_status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    commission_rate DECIMAL(5,2) DEFAULT 3.00,
    partner_id BIGINT UNSIGNED NULL,
    account_manager_id BIGINT UNSIGNED NULL,
    settings JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (partner_id) REFERENCES partners(id) ON DELETE SET NULL,
    FOREIGN KEY (account_manager_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_verification_status (verification_status),
    INDEX idx_city (city)
);
```

#### Services Table
```sql
CREATE TABLE services (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    merchant_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    category ENUM('venues', 'catering', 'photography', 'beauty', 'entertainment', 'transportation', 'security', 'flowers_invitations') NOT NULL,
    service_type ENUM('package', 'individual', 'addon') NOT NULL,
    pricing_model ENUM('fixed', 'per_person', 'per_hour') NOT NULL,
    base_price DECIMAL(10,2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'SAR',
    duration_hours INT NULL,
    capacity INT NULL,
    features JSON NULL,
    images JSON NULL,
    status ENUM('active', 'inactive', 'draft') DEFAULT 'draft',
    online_booking_enabled BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (merchant_id) REFERENCES merchants(id) ON DELETE CASCADE,
    INDEX idx_category (category),
    INDEX idx_service_type (service_type),
    INDEX idx_status (status),
    INDEX idx_online_booking (online_booking_enabled)
);
```

#### Service Availability Table
```sql
CREATE TABLE service_availability (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    service_id BIGINT UNSIGNED NOT NULL,
    available_date DATE NOT NULL,
    time_slots JSON NOT NULL,
    max_bookings INT DEFAULT 1,
    current_bookings INT DEFAULT 0,
    special_pricing DECIMAL(10,2) NULL,
    status ENUM('available', 'booked', 'blocked') DEFAULT 'available',
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE,
    UNIQUE KEY unique_service_date (service_id, available_date),
    INDEX idx_available_date (available_date),
    INDEX idx_status (status)
);
```

#### Bookings Table
```sql
CREATE TABLE bookings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    booking_number VARCHAR(20) UNIQUE NOT NULL,
    customer_id BIGINT UNSIGNED NOT NULL,
    service_id BIGINT UNSIGNED NOT NULL,
    merchant_id BIGINT UNSIGNED NOT NULL,
    booking_date DATE NOT NULL,
    booking_time TIME NULL,
    guest_count INT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    commission_amount DECIMAL(10,2) NOT NULL,
    commission_rate DECIMAL(5,2) NOT NULL,
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    booking_status ENUM('pending', 'confirmed', 'completed', 'cancelled', 'no_show') DEFAULT 'pending',
    booking_source ENUM('online', 'manual', 'pos') DEFAULT 'online',
    special_requests TEXT NULL,
    cancellation_reason TEXT NULL,
    cancelled_at TIMESTAMP NULL,
    cancelled_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE,
    FOREIGN KEY (merchant_id) REFERENCES merchants(id) ON DELETE CASCADE,
    FOREIGN KEY (cancelled_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_booking_number (booking_number),
    INDEX idx_booking_date (booking_date),
    INDEX idx_payment_status (payment_status),
    INDEX idx_booking_status (booking_status)
);
```

#### Payments Table
```sql
CREATE TABLE payments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    booking_id BIGINT UNSIGNED NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    payment_gateway VARCHAR(50) NOT NULL,
    gateway_transaction_id VARCHAR(255) NULL,
    amount DECIMAL(10,2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'SAR',
    status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    gateway_response JSON NULL,
    processed_at TIMESTAMP NULL,
    refunded_at TIMESTAMP NULL,
    refund_reason TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_gateway_transaction_id (gateway_transaction_id)
);
```

#### Reviews Table
```sql
CREATE TABLE reviews (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    booking_id BIGINT UNSIGNED NOT NULL,
    customer_id BIGINT UNSIGNED NOT NULL,
    merchant_id BIGINT UNSIGNED NOT NULL,
    service_id BIGINT UNSIGNED NOT NULL,
    rating TINYINT UNSIGNED NOT NULL CHECK (rating >= 1 AND rating <= 5),
    review_text TEXT NULL,
    merchant_reply TEXT NULL,
    replied_at TIMESTAMP NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (merchant_id) REFERENCES merchants(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE,
    UNIQUE KEY unique_booking_review (booking_id),
    INDEX idx_rating (rating),
    INDEX idx_status (status)
);
```

#### Contracts Table
```sql
CREATE TABLE contracts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    booking_id BIGINT UNSIGNED NOT NULL,
    contract_number VARCHAR(20) UNIQUE NOT NULL,
    template_id BIGINT UNSIGNED NULL,
    contract_content LONGTEXT NOT NULL,
    customer_signature TEXT NULL,
    merchant_signature TEXT NULL,
    customer_signed_at TIMESTAMP NULL,
    merchant_signed_at TIMESTAMP NULL,
    status ENUM('pending_merchant', 'pending_customer', 'signed', 'cancelled') DEFAULT 'pending_merchant',
    docusign_envelope_id VARCHAR(255) NULL,
    version INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
    INDEX idx_contract_number (contract_number),
    INDEX idx_status (status)
);
```

#### Partners Table
```sql
CREATE TABLE partners (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    partner_type ENUM('representative', 'affiliate', 'account_manager') NOT NULL,
    referral_code VARCHAR(20) UNIQUE NOT NULL,
    commission_rate DECIMAL(5,2) NOT NULL,
    total_referrals INT DEFAULT 0,
    total_earnings DECIMAL(10,2) DEFAULT 0.00,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    settings JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_partner_type (partner_type),
    INDEX idx_referral_code (referral_code),
    INDEX idx_status (status)
);
```

#### Notifications Table
```sql
CREATE TABLE notifications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    type VARCHAR(50) NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    data JSON NULL,
    channels JSON NOT NULL, -- ['email', 'sms', 'push', 'database']
    read_at TIMESTAMP NULL,
    sent_at TIMESTAMP NULL,
    failed_at TIMESTAMP NULL,
    failure_reason TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_type (type),
    INDEX idx_read_at (read_at)
);
```

#### Wallet Transactions Table
```sql
CREATE TABLE wallet_transactions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    merchant_id BIGINT UNSIGNED NOT NULL,
    booking_id BIGINT UNSIGNED NULL,
    transaction_type ENUM('earning', 'commission', 'withdrawal', 'refund') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'SAR',
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    description TEXT NULL,
    reference_id VARCHAR(255) NULL,
    processed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (merchant_id) REFERENCES merchants(id) ON DELETE CASCADE,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE SET NULL,
    INDEX idx_merchant_id (merchant_id),
    INDEX idx_transaction_type (transaction_type),
    INDEX idx_status (status)
);
```

### Additional Supporting Tables

#### Promotions Table
```sql
CREATE TABLE promotions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    merchant_id BIGINT UNSIGNED NOT NULL,
    code VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    discount_type ENUM('percentage', 'fixed') NOT NULL,
    discount_value DECIMAL(10,2) NOT NULL,
    minimum_amount DECIMAL(10,2) NULL,
    usage_limit INT NULL,
    used_count INT DEFAULT 0,
    applicable_services JSON NULL,
    starts_at TIMESTAMP NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    status ENUM('active', 'inactive', 'expired') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (merchant_id) REFERENCES merchants(id) ON DELETE CASCADE,
    INDEX idx_code (code),
    INDEX idx_status (status),
    INDEX idx_expires_at (expires_at)
);
```

#### Loyalty Program Table
```sql
CREATE TABLE loyalty_points (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_id BIGINT UNSIGNED NOT NULL,
    merchant_id BIGINT UNSIGNED NULL,
    points INT NOT NULL,
    transaction_type ENUM('earned', 'redeemed', 'expired') NOT NULL,
    reference_type VARCHAR(50) NULL, -- 'booking', 'review', 'referral'
    reference_id BIGINT UNSIGNED NULL,
    description VARCHAR(255) NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (merchant_id) REFERENCES merchants(id) ON DELETE SET NULL,
    INDEX idx_customer_id (customer_id),
    INDEX idx_transaction_type (transaction_type)
);
```

## 4. Technical Requirements

### Server Requirements
- **PHP**: 8.1 or higher
- **MySQL**: 8.0 or higher
- **Redis**: For caching and sessions
- **Node.js**: For asset compilation
- **Web Server**: Nginx or Apache with proper configuration

### Required PHP Extensions
```php
// Required extensions
- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PCRE
- PDO
- Tokenizer
- XML
- GD or Imagick (for image processing)
- Redis (for caching)
```

### Laravel Packages Required
```json
{
    "require": {
        "laravel/framework": "^10.0",
        "filament/filament": "^3.0",
        "spatie/laravel-permission": "^5.0",
        "spatie/laravel-media-library": "^10.0",
        "stripe/stripe-php": "^10.0",
        "laravel/cashier": "^14.0",
        "barryvdh/laravel-dompdf": "^2.0",
        "pusher/pusher-php-server": "^7.0",
        "laravel/horizon": "^5.0",
        "spatie/laravel-backup": "^8.0",
        "spatie/laravel-activitylog": "^4.0",
        "filament/spatie-laravel-media-library-plugin": "^3.0",
        "doctrine/dbal": "^3.0"
    }
}
```

### Filament Plugins Needed
```php
// Filament plugins for enhanced functionality
- filament/spatie-laravel-media-library-plugin
- filament/spatie-laravel-settings-plugin
- filament/spatie-laravel-translatable-plugin
- pxlrbt/filament-excel (for data export)
- ryangjchandler/filament-navigation
- z3d0x/filament-logger
```

## 5. User Interface & Experience

### Admin Panel Structure (Filament)

#### Dashboard Widgets
```php
// Key dashboard widgets for different user types
class BookingStatsWidget extends BaseWidget
class RevenueChartWidget extends ChartWidget  
class RecentActivityWidget extends BaseWidget
class SystemHealthWidget extends BaseWidget
```

#### Resource Management
```php
// Main Filament resources
- UserResource (with role-based views)
- MerchantResource 
- BookingResource
- ServiceResource
- PaymentResource
- ReviewResource
- ContractResource
- PartnerResource
- NotificationResource
```

#### Page Layouts
1. **Customer Dashboard**
   - Booking overview and management
   - Payment history and methods
   - Loyalty points and rewards
   - Profile and preferences

2. **Merchant Dashboard**
   - Service and package management
   - Calendar and availability control
   - Financial tracking and payouts
   - Customer communication tools

3. **Admin Dashboard**
   - Platform-wide analytics
   - User and merchant management
   - Financial oversight
   - System configuration

### Form Designs & Validation

#### Booking Form Validation
```php
class BookingRequest extends FormRequest
{
    public function rules()
    {
        return [
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after:today',
            'booking_time' => 'required|date_format:H:i',
            'guest_count' => 'nullable|integer|min:1',
            'special_requests' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:card,bank_transfer,bnpl'
        ];
    }
}
```

#### Service Creation Validation
```php
class ServiceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'category' => 'required|in:venues,catering,photography,beauty,entertainment,transportation,security,flowers_invitations',
            'service_type' => 'required|in:package,individual,addon',
            'pricing_model' => 'required|in:fixed,per_person,per_hour',
            'base_price' => 'required|numeric|min:0',
            'capacity' => 'nullable|integer|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ];
    }
}
```

## 6. Business Logic & Rules

### Commission Calculation Logic
```php
class CommissionCalculator
{
    public function calculateCommission(Booking $booking): array
    {
        $merchant = $booking->merchant;
        $commissionRate = $merchant->commission_rate ?? 3.00;
        $commissionAmount = ($booking->total_amount * $commissionRate) / 100;
        
        return [
            'commission_rate' => $commissionRate,
            'commission_amount' => $commissionAmount,
            'merchant_earnings' => $booking->total_amount - $commissionAmount
        ];
    }
}
```

### Booking Workflow
```php
class BookingWorkflow
{
    public function processBooking(array $bookingData): Booking
    {
        DB::transaction(function () use ($bookingData) {
            // 1. Create booking record
            $booking = Booking::create($bookingData);
            
            // 2. Process payment
            $payment = $this->processPayment($booking);
            
            // 3. Update service availability
            $this->updateServiceAvailability($booking);
            
            // 4. Generate contract
            $this->generateContract($booking);
            
            // 5. Send notifications
            $this->sendBookingNotifications($booking);
            
            return $booking;
        });
    }
}
```

### Permission System
```php
// Role-based permissions using Spatie Laravel Permission
class RolePermissions
{
    public static function defineRoles()
    {
        // Customer permissions
        Permission::create(['name' => 'view_own_bookings']);
        Permission::create(['name' => 'create_bookings']);
        Permission::create(['name' => 'cancel_own_bookings']);
        
        // Merchant permissions  
        Permission::create(['name' => 'manage_own_services']);
        Permission::create(['name' => 'view_own_bookings']);
        Permission::create(['name' => 'manage_calendar']);
        Permission::create(['name' => 'view_financial_reports']);
        
        // Admin permissions
        Permission::create(['name' => 'manage_all_users']);
        Permission::create(['name' => 'manage_platform_settings']);
        Permission::create(['name' => 'view_all_analytics']);
    }
}
```

### Notification System
```php
class NotificationService
{
    public function sendBookingConfirmation(Booking $booking)
    {
        $customer = $booking->customer;
        $merchant = $booking->merchant;
        
        // Send to customer
        $customer->notify(new BookingConfirmationNotification($booking));
        
        // Send to merchant
        $merchant->user->notify(new NewBookingNotification($booking));
    }
}
```

## 7. Laravel/Filament Implementation Strategy

### Model Relationships
```php
// User Model
class User extends Authenticatable
{
    public function merchant()
    {
        return $this->hasOne(Merchant::class);
    }
    
    public function partner()
    {
        return $this->hasOne(Partner::class);
    }
    
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }
}

// Merchant Model
class Merchant extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}
```

### Filament Resource Examples
```php
class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    
    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('customer_id')
                ->relationship('customer', 'name')
                ->required(),
            Select::make('service_id')
                ->relationship('service', 'name')
                ->required(),
            DatePicker::make('booking_date')
                ->required()
                ->minDate(now()),
            TimePicker::make('booking_time'),
            TextInput::make('guest_count')
                ->numeric()
                ->minValue(1),
            Textarea::make('special_requests')
                ->maxLength(1000),
        ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('booking_number')
                ->searchable()
                ->sortable(),
            TextColumn::make('customer.name')
                ->searchable(),
            TextColumn::make('service.name')
                ->limit(30),
            TextColumn::make('booking_date')
                ->date()
                ->sortable(),
            TextColumn::make('total_amount')
                ->money('SAR'),
            BadgeColumn::make('booking_status')
                ->colors([
                    'warning' => 'pending',
                    'success' => 'confirmed',
                    'primary' => 'completed',
                    'danger' => 'cancelled',
                ]),
        ]);
    }
}
```

### API Structure
```php
// API Routes for mobile app or external integrations
Route::prefix('api/v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        // Customer routes
        Route::get('/bookings', [BookingController::class, 'index']);
        Route::post('/bookings', [BookingController::class, 'store']);
        
        // Merchant routes
        Route::get('/merchant/dashboard', [MerchantController::class, 'dashboard']);
        Route::get('/merchant/bookings', [MerchantController::class, 'bookings']);
        
        // Service routes
        Route::apiResource('services', ServiceController::class);
    });
    
    // Public routes
    Route::get('/services/search', [ServiceController::class, 'search']);
    Route::get('/merchants/{merchant}/services', [ServiceController::class, 'merchantServices']);
});
```

## 8. Implementation Challenges & Considerations

### Multi-tenancy Considerations
- **Merchant Isolation**: Each merchant should only access their own data
- **Shared Resources**: Some data (categories, cities) can be shared
- **Performance**: Proper indexing for large datasets

### Localization Requirements
- **RTL Support**: Right-to-left layout for Arabic
- **Multi-language**: Support for Arabic and English
- **Date/Time Formatting**: Islamic calendar support
- **Currency**: Saudi Riyal (SAR) as primary currency

### Security Considerations
- **Data Protection**: GDPR-like compliance for user data
- **Payment Security**: PCI DSS compliance for payment processing
- **Access Control**: Strict role-based permissions
- **Audit Logging**: Complete activity tracking

### Performance Optimization
- **Database Indexing**: Proper indexes for search and filtering
- **Caching Strategy**: Redis for session and application caching
- **Queue Management**: Laravel Horizon for background jobs
- **Image Optimization**: Automatic image resizing and compression

### Integration Complexity
- **Payment Gateways**: Multiple payment providers
- **SMS/Email Services**: Reliable delivery systems
- **Document Signing**: DocuSign API integration
- **Analytics**: Custom reporting requirements

## 9. Development Phases

### Phase 1: Core Foundation
1. Laravel application setup with Filament
2. User authentication and role management
3. Basic merchant and customer models
4. Core database schema implementation

### Phase 2: Booking System
1. Service catalog and management
2. Booking workflow implementation
3. Calendar and availability system
4. Basic payment integration

### Phase 3: Advanced Features
1. Contract management system
2. Review and rating system
3. Notification system
4. Financial reporting

### Phase 4: Business Intelligence
1. Analytics and reporting
2. Partner/affiliate system
3. Advanced admin tools
4. Performance optimization

### Phase 5: Integrations & Polish
1. Third-party service integrations
2. Mobile API development
3. Advanced security features
4. Production deployment and monitoring

## 10. Estimated Development Timeline

- **Phase 1**: 4-6 weeks
- **Phase 2**: 6-8 weeks  
- **Phase 3**: 4-6 weeks
- **Phase 4**: 3-4 weeks
- **Phase 5**: 4-5 weeks

**Total Estimated Timeline**: 21-29 weeks (5-7 months)

This comprehensive analysis provides the foundation for replicating the Lilium Night platform using Laravel v10, Filament v3, and PHP v8.1, maintaining all the sophisticated functionality while leveraging Laravel's robust ecosystem.