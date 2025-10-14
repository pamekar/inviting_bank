# Banking System Development Instructions

## Project Overview
Build a comprehensive Nigerian banking system with Laravel, using Laravel Starter Kit for the frontend and Filament PHP for the admin backend. All features must be accessible via REST API with comprehensive PHPDoc documentation for automated API documentation generation.

## Tech Stack
- **Backend Framework**: Laravel 11+
- **Frontend**: Laravel Breeze Starter Kit
- **Admin Panel**: Filament PHP 3.x
- **Database**: MySQL 8.0+
- **API Documentation**: PHPDoc + OpenAPI/Swagger
- **Authentication**: Laravel Sanctum (for API)

## Project Setup Instructions

### 1. Initialize Laravel Project
```bash
laravel new banking-system --with=sqlite
cd banking-system
composer require filament/filament
php artisan filament:install --panels=admin
```

### 3. Database Configuration
- Configure `.env` for MySQL database
- Create migrations for all required tables
- Set up comprehensive seeders for demo data (see Seeders section below)
- Set up factories for model generation

---

## Core Features to Implement

### A. User Management
- User registration and KYC (Know Your Customer) profile
- Phone number verification
- Account tier levels (Basic, Premium, VIP)
- Two-factor authentication (2FA) support
- User profile management via API and dashboard

### B. Account Management
- Create multiple bank accounts per user (Savings, Checking, Investment)
- Account numbers (10-digit Nigerian format)
- Account statuses (Active, Suspended, Closed)
- Account balance tracking
- Account statements (transaction history)
- Monthly interest calculation for savings accounts

### C. Transactions

#### Withdrawals
- Withdrawal requests with amount validation
- Daily/monthly withdrawal limits based on account tier
- Withdrawal status tracking (Pending, Approved, Rejected, Completed)
- Withdrawal charges/fees
- ATM cash withdrawal simulation

#### Deposits
- Direct deposit functionality
- Mobile money deposits (simulation)
- Check deposits
- Bank transfer deposits
- Deposit confirmation and receipts
- Auto-reconciliation of deposits

#### Transfers
- **Intra-bank transfers only** (between user's accounts and to other users within the bank)
- Scheduled transfers (future-dated)
- Transfer limits based on account tier
- Transfer fees and charges
- Transfer status tracking (Pending, Processing, Completed, Failed, Awaiting Authorization)
- Recipient management (saved beneficiaries)
- 2FA verification required for all transfers
- Transfer verification via 2FA before final processing

#### Utility Bill Payments
- Pay electricity bills (NEPA/Disco providers)
- Pay water bills
- Pay internet/broadband bills
- Pay school fees
- Pay insurance premiums
- Pay subscriptions (TV, streaming services)
- Bill payment history
- Saved billers list
- Bill notifications and reminders
- Automatic bill payment scheduling

### D. Wallet/Account Features
- Transaction history with filters (date range, type, amount, status)
- Account statements export (PDF, CSV)
- Transaction receipts
- Mini statements
- Balance inquiries
- Real-time notifications for transactions
- Transaction search functionality

### E. Loan Management (Extended)
- Loan applications with approval workflow
- Loan disbursement
- Loan repayment tracking
- Interest calculations
- Loan statements

### F. Cards Management (Extended)
- Virtual card creation and management
- Debit card requests
- Card activation/deactivation
- Card spending limits
- Card transaction history
- Card blocking/unblocking

### G. Admin Features (Filament)
- User management dashboard
- Transaction monitoring and approval
- Dispute/complaint resolution
- Account tier management
- Fee and charge configuration
- System settings and configurations
- Reports generation (daily, monthly, yearly)
- User activity logs
- Audit trails

### H. Security Features
- **Two-Factor Authentication (2FA) System** - Core authorization mechanism:
    - Time-based One-Time Password (TOTP) via authenticator apps (Google Authenticator, Authy)
    - SMS OTP as backup method
    - In-app push notifications with approval/rejection buttons
    - 2FA required for all sensitive operations (transfers, withdrawals, bill payments, profile changes)
    - 2FA session management with configurable expiration (5-30 minutes)
    - Backup codes generation for account recovery
    - Device trust/whitelist feature (remember this device for X days)
- Transaction verification workflow (2FA approval before finalization)
- Fraud detection (suspicious activity flags)
- IP whitelisting/blacklisting
- Device management and tracking
- Login attempt tracking and lockout mechanism
- Session management
- Rate limiting on API endpoints

---

## Database Seeders

### Overview
Create comprehensive seeders that generate realistic, interconnected demo data. Run seeders in this order to maintain referential integrity.

### Seeders to Create

#### 1. AdminSeeder
Generates administrative users with Filament access.

**Data to generate:**
- 3-5 admin users with roles:
    - Super Admin (full access)
    - Finance Admin (transaction approvals, reports)
    - Compliance Admin (audit logs, disputes)
    - Support Admin (user assistance)
- Realistic admin emails: admin@nigerianbank.com, finance@nigerianbank.com, etc.
- Assign proper permissions/roles for Filament

**Records: 5**

#### 2. AccountTierSeeder
Generates account tier configurations.

**Data to generate:**
- Basic Tier:
    - Daily withdrawal limit: ₦500,000
    - Daily transfer limit: ₦1,000,000
    - Monthly transaction limit: 50 transactions
    - Maintenance fee: ₦500/month
- Premium Tier:
    - Daily withdrawal limit: ₦2,000,000
    - Daily transfer limit: ₦5,000,000
    - Monthly transaction limit: Unlimited
    - Maintenance fee: ₦2,000/month
- VIP Tier:
    - Daily withdrawal limit: ₦10,000,000
    - Daily transfer limit: ₦50,000,000
    - Monthly transaction limit: Unlimited
    - Maintenance fee: ₦5,000/month
- Corporate Tier:
    - Higher limits for business accounts

**Records: 4**

#### 3. TransactionFeeSeeder
Generates transaction fee configurations.

**Data to generate:**
- Transfer fees (intra-bank):
    - Up to ₦50,000: ₦25 flat
    - ₦50,001-₦1,000,000: ₦50 flat
    - Above ₦1,000,000: ₦100 flat
- Withdrawal fees:
    - ATM withdrawal: ₦65 per transaction
    - OTC withdrawal: ₦100 per transaction
    - Premium tier discounts: 50% off
- Bill payment fees:
    - Electricity: ₦50
    - Water: ₦50
    - Internet: ₦50
    - School fees: ₦100
- Cross-tier fees (if applicable)

**Records: 12**

#### 4. UserSeeder
Generates diverse customer users with realistic profiles.

**Data to generate:**
- 50-100 customers with:
    - Mixed genders and realistic Nigerian names
    - Varied locations across Nigeria (Lagos, Abuja, Kano, etc.)
    - Realistic phone numbers (+234 format)
    - Varied email domains (gmail, yahoo, outlook)
    - Different account tiers (distributed: 60% Basic, 25% Premium, 15% VIP)
    - Account creation dates spread over past 12 months
    - Realistic profile data (date of birth, address, BVN simulation)
    - Email verification status (90% verified)
    - Account status (95% active, 5% suspended)
    - 2FA setup status (70% enabled)

**Name Sources:** Use Nigerian name generators
**Realistic Distribution:**
- Account tiers: Basic 60%, Premium 25%, VIP 15%
- Verified accounts: 90%
- 2FA enabled: 70%
- Active accounts: 95%

**Records: 100**

#### 5. AccountSeeder
Generates bank accounts for users.

**Data to generate:**
- 1-3 accounts per user (Checking, Savings, Investment)
- Realistic 10-digit account numbers (unique, Nigerian format: 0XX-XXXXXXXX)
- Account types:
    - Checking (0% interest)
    - Savings (2-3% annual interest)
    - Investment (5-7% annual interest)
- Initial balances:
    - Minimum: ₦1,000
    - Maximum: ₦50,000,000
    - Distribution: Most accounts have ₦10,000-₦500,000 (realistic)
    - Few accounts have ₦5,000,000+ (high-net-worth customers)
- Account creation dates (varied, some older than others)
- Account status: 95% active, 5% inactive
- Interest rates per account type
- Account statements available

**Smart Distribution:**
- VIP users: 3 accounts each
- Premium users: 2 accounts each
- Basic users: 1 account on average
- Average account balance varies by tier (VIP higher, Basic lower)

**Records: 150-200 accounts**

#### 6. BeneficiarySeeder
Generates saved beneficiaries (intra-bank only).

**Data to generate:**
- 1-10 beneficiaries per user (realistic)
- Random selection from other users' accounts
- Beneficiary details:
    - Account number
    - Account holder name
    - User-given nickname
    - Relationship type (Friend, Family, Colleague, etc.)
    - Date added (spread over time)

**Realistic Pattern:**
- Some users have many beneficiaries (frequent transfers)
- Some users have few (minimal transfers)
- Simulate real relationships (not completely random)

**Records: 200-300**

#### 7. TransactionSeeder
Generates realistic transaction history (deposits, withdrawals, transfers).

**Data to generate:**
- 1000-2000 total transactions spread across all accounts
- Transaction types:
    - **Deposits: 20%** (various amounts, varied sources)
    - **Withdrawals: 25%** (ATM and OTC mix)
    - **Transfers: 55%** (most common activity)
- Transaction details per type:
    - Deposits:
        - Mobile money transfers
        - Direct bank transfers
        - Salary deposits
        - Amounts: ₦5,000-₦5,000,000
    - Withdrawals:
        - ATM and Over-The-Counter (OTC)
        - Amounts: ₦2,000-₦500,000
        - Fees applied based on tier
    - Transfers:
        - To beneficiaries
        - To random other accounts
        - Amounts: ₦1,000-₦10,000,000
- Transaction statuses:
    - 85% Completed
    - 10% Pending (recent transactions)
    - 3% Failed
    - 2% Reversed
- Timestamps:
    - Spread across past 6-12 months
    - More recent transactions more frequent
    - Realistic business hours concentration (80% between 6 AM - 10 PM)
    - Random weekend/weekday distribution
- Descriptions and references
- Fee calculations applied automatically

**Intelligent Randomization:**
- Frequent small transfers between common beneficiaries
- Occasional large transfers
- Regular salary deposits on specific days
- Realistic spending patterns (utilities on certain days, etc.)

**Records: 1500-2000 transactions**

#### 8. WithdrawalSeeder
Generates withdrawal records (subset of transactions).

**Data to generate:**
- 200-300 withdrawal records
- Withdrawal details:
    - Account source
    - Amount: ₦2,000-₦500,000
    - Type: ATM or OTC
    - Status distribution:
        - 70% Completed
        - 15% Pending
        - 10% Approved
        - 5% Rejected
    - Withdrawal reason (ATM, OTC Cash, Emergency)
    - Location/ATM ID (for ATM withdrawals)
    - Approver (admin) for large withdrawals
    - Timestamps matching transaction records

**Records: 250**

#### 9. DepositSeeder
Generates deposit records (subset of transactions).

**Data to generate:**
- 300-400 deposit records
- Deposit details:
    - Account destination
    - Amount: ₦5,000-₦5,000,000
    - Source type:
        - Mobile Money (30%)
        - Bank Transfer (40%)
        - Salary Deposit (20%)
        - Cash Deposit (10%)
    - Status distribution:
        - 90% Completed
        - 8% Pending
        - 2% Failed
    - Reference/Check number (if applicable)
    - Depositor name/account
    - Timestamps spread realistically

**Records: 350**

#### 10. TransferSeeder
Generates transfer records (majority of transactions).

**Data to generate:**
- 800-1000 transfer records
- Transfer details:
    - Source and destination accounts (intra-bank)
    - Amount: ₦1,000-₦10,000,000
    - Status distribution:
        - 80% Completed
        - 12% Pending
        - 5% Awaiting Authorization (recent)
        - 3% Failed/Reversed
    - Transfer fees applied
    - Beneficiary used (from saved list when possible)
    - Narrative/description
    - Timestamps
- Realistic patterns:
    - Regular transfers to same beneficiaries
    - Round amounts (₦5000, ₦10000, etc.)
    - Some precise amounts (₦47,850)
    - Cluster around paydays

**Records: 900**

#### 11. UtilityPaymentSeeder
Generates bill payment records.

**Data to generate:**
- 100-200 bill payment transactions
- Payment details:
    - User account
    - Bill type: Electricity, Water, Internet, School Fees, Insurance
    - Provider: NEPA, LagosWater, MTN, Airtel, specific schools
    - Amount: varies by type (₦2,000-₦50,000)
    - Customer reference/account number
    - Status:
        - 85% Completed
        - 10% Pending
        - 5% Failed
    - Timestamps
    - Scheduled (recurring) vs. one-time
- Realistic distribution:
    - Electricity bills most frequent
    - Monthly patterns (bills due on specific days)
    - Some recurring payments

**Records: 150**

#### 12. PendingAuthorizationSeeder
Generates sample pending authorizations.

**Data to generate:**
- 5-10 pending authorizations
- Authorization details:
    - User (random)
    - Type: Transfer, Withdrawal, Bill Payment
    - Transaction details (referenced transaction)
    - Status: awating_verification
    - Created 1-30 minutes ago (not yet expired)
    - IP address and User Agent
    - No approval yet (to demonstrate pending state)

**Records: 8**

#### 13. AuditLogSeeder
Generates system audit logs.

**Data to generate:**
- 500-1000 audit log entries
- Log details:
    - User performing action
    - Action type: LOGIN, TRANSFER, WITHDRAWAL, ADMIN_ACTION, 2FA_SETUP, etc.
    - Target entity: User, Transaction, Account
    - Changes made (before/after values)
    - IP address
    - Timestamp (spread across past 30 days)
    - Status: SUCCESS, FAILED
- Realistic patterns:
    - User logins (1-3 per user per day)
    - Transactions logged
    - 2FA setups
    - Admin actions

**Records: 800**

#### 14. DeviceSeeder
Generates trusted devices for users.

**Data to generate:**
- 50-100 trusted devices across users
- Device details:
    - User
    - Device name: "iPhone 14", "Samsung S23", "Chrome Windows", etc.
    - Device type: mobile, web, tablet
    - Device identifier (hashed)
    - Is trusted: 90% true, 10% false
    - Last used: various times in past month
    - Trust expiration: null (permanent) or future date
    - IP address
    - User Agent

**Records: 75**

#### 15. NotificationSeeder (Optional)
Generates notification history.

**Data to generate:**
- 200-300 notifications
- Notification types: Transaction, 2FA, System, Alert
- Channels: Push, SMS, In-app
- Read/unread status
- Content and timestamps

**Records: 250**

### Running Order
```bash
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=AccountTierSeeder
php artisan db:seed --class=TransactionFeeSeeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=AccountSeeder
php artisan db:seed --class=BeneficiarySeeder
php artisan db:seed --class=TransactionSeeder
php artisan db:seed --class=WithdrawalSeeder
php artisan db:seed --class=DepositSeeder
php artisan db:seed --class=TransferSeeder
php artisan db:seed --class=UtilityPaymentSeeder
php artisan db:seed --class=PendingAuthorizationSeeder
php artisan db:seed --class=AuditLogSeeder
php artisan db:seed --class=DeviceSeeder
php artisan db:seed --class=NotificationSeeder
```

Or run all at once:
```bash
php artisan db:seed
```

### Seeder Implementation Notes

- Use Faker library for realistic data generation
- Use custom faker providers for Nigerian-specific data:
    - Nigerian names
    - Nigerian phone numbers (+234 format)
    - Nigerian locations
    - Realistic account numbers
- Use Carbon for intelligent timestamp generation
- Use factories for related models (e.g., UserFactory, AccountFactory)
- Ensure referential integrity (foreign keys)
- Use transactions to rollback on error
- Seed only development/staging environments (guard with APP_ENV check)
- Create README with seeding instructions
- Include options to seed partial datasets

### Test Data Access

Create a `.env.testing` configuration with seeded data for:
- API integration tests
- UI testing
- Demo/presentation purposes

#### Sample Admin Credentials (for login)
```
Email: admin@nigerianbank.com
Password: password123

Email: finance@nigerianbank.com
Password: password123
```

#### Sample Customer Credentials
Generated dynamically in seeder with deterministic passwords for testing:
```
Email: customer1@example.com
Password: password123
```

All generated customer email addresses and passwords can be listed in a `DEMO_CREDENTIALS.md` file.

---

### Overview
The 2FA system is designed to protect sensitive operations (especially from chatbot API requests) by requiring users to explicitly authorize transactions through one of three methods: TOTP (Time-based One-Time Password), SMS OTP, or in-app push notifications.

### How It Works

#### Setup Phase
1. User enables 2FA in settings
2. System generates TOTP secret key
3. User scans QR code with authenticator app (Google Authenticator, Authy, Microsoft Authenticator)
4. User verifies setup by entering TOTP code
5. System generates 6 backup codes for account recovery
6. User can optionally enable SMS OTP as backup method

#### Authorization Flow for Sensitive Operations

**Scenario: Chatbot initiates a transfer request**

1. **Initiation**: Chatbot calls `POST /api/transfers` with transfer details
2. **Validation**: System validates transfer (amount, limits, balance)
3. **Pending Authorization**: System creates pending authorization record with:
    - Unique authorization ID
    - Transaction details
    - User ID
    - Status: `awaiting_verification`
    - Timestamp
    - Expiration time (5-30 minutes configurable)
4. **Notification**: System sends:
    - Push notification to user's mobile app (with Approve/Reject buttons)
    - SMS notification (optional, based on settings)
    - In-app alert
5. **User Action**: User opens app and:
    - Reviews transaction details
    - Either approves or rejects
6. **2FA Verification**:
    - If approved, user must verify with one of:
        - TOTP code from authenticator app
        - SMS OTP sent to registered phone
        - Biometric (if enabled)
7. **Completion**: Upon successful 2FA:
    - Authorization record updated with approval details
    - Transaction processed
    - Confirmation sent to user

#### Expiration & Security
- Authorization requests expire after configured time (default: 15 minutes)
- Multiple failed 2FA attempts trigger account lockout protection
- Each authorization attempt logged for audit trail
- Device trust can skip 2FA on specific operations for X days

### Database Schema Details

#### `two_factor_auths` Table
```
- id: bigint (primary key)
- user_id: bigint (foreign key)
- is_enabled: boolean (default: false)
- method: enum('totp', 'sms', 'both') (default: 'totp')
- phone_number: string (for SMS OTP)
- backup_codes_generated_at: timestamp
- created_at: timestamp
- updated_at: timestamp
```

#### `totp_secrets` Table
```
- id: bigint (primary key)
- user_id: bigint (foreign key, unique)
- secret: string (encrypted TOTP secret)
- backup_codes: json (encrypted backup codes)
- verified_at: timestamp (null until verified)
- created_at: timestamp
```

#### `otp_verifications` Table
```
- id: bigint (primary key)
- user_id: bigint (foreign key)
- phone_number: string
- code: string (hashed OTP code)
- attempts: integer (default: 0)
- max_attempts: integer (default: 3)
- expires_at: timestamp
- verified_at: timestamp (null if not verified)
- created_at: timestamp
```

#### `pending_authorizations` Table
```
- id: uuid (primary key)
- user_id: bigint (foreign key)
- authorization_type: enum('transfer', 'withdrawal', 'bill_payment', 'profile_change')
- transaction_id: bigint (foreign key to specific transaction table)
- transaction_details: json (serialized transaction data for display)
- status: enum('awaiting_verification', 'approved', 'rejected', 'expired')
- verification_method: enum('totp', 'sms_otp', 'push_notification')
- push_notification_sent: boolean
- ip_address: string
- user_agent: string
- expires_at: timestamp
- approved_at: timestamp (nullable)
- approved_via: enum('totp', 'sms_otp', 'backup_code', 'biometric')
- created_at: timestamp
- updated_at: timestamp
```

#### `devices` Table
```
- id: bigint (primary key)
- user_id: bigint (foreign key)
- device_identifier: string (hashed device fingerprint)
- device_name: string (user-friendly name)
- device_type: enum('mobile', 'web', 'tablet')
- is_trusted: boolean (default: false)
- last_used_at: timestamp
- trusted_until: timestamp (null if permanently trusted)
- ip_address: string
- user_agent: string
- created_at: timestamp
- updated_at: timestamp
```

### Sensitive Operations Requiring 2FA

The following operations automatically trigger 2FA verification:
1. Transfer (any amount)
2. Large withdrawals (configurable threshold, e.g., > ₦100,000)
3. Adding new beneficiary
4. Utility bill payment (configurable threshold)
5. Changing profile information (email, phone, password)
6. Enabling/disabling 2FA
7. Adding/removing trusted devices
8. Any API request from unfamiliar IP/device

### Configuration Options
- `2FA_ENABLED`: Global 2FA requirement toggle
- `2FA_EXPIRATION_MINUTES`: How long authorization requests stay valid
- `2FA_MAX_ATTEMPTS`: Maximum failed verification attempts before lockout
- `2FA_LOCKOUT_MINUTES`: Duration of account lockout after max attempts
- `TRUSTED_DEVICE_DURATION_DAYS`: How long a device can skip 2FA
- `TRANSFER_2FA_THRESHOLD`: Minimum transfer amount requiring 2FA
- `WITHDRAWAL_2FA_THRESHOLD`: Minimum withdrawal requiring 2FA
- `SMS_OTP_VALID_MINUTES`: Duration SMS OTP codes are valid
- `PUSH_NOTIFICATION_TIMEOUT_SECONDS`: How long to wait for push notification response

---

### Tables to Create
1. `users` - User profiles
2. `accounts` - Bank accounts
3. `transactions` - All transaction records
4. `transfers` - Transfer details (intra-bank only)
5. `withdrawals` - Withdrawal records
6. `deposits` - Deposit records
7. `utility_payments` - Bill payment records
8. `beneficiaries` - Saved recipients (intra-bank only)
9. `transaction_fees` - Fee configurations
10. `account_tiers` - Account tier configurations
11. `two_factor_auths` - 2FA setup and status per user
12. `totp_secrets` - TOTP secret keys for authenticator apps
13. `otp_verifications` - SMS OTP records and attempts
14. `pending_authorizations` - Pending 2FA authorization requests
15. `authorization_approvals` - 2FA approval history and logs
16. `audit_logs` - System audit trails
17. `disputes` - Transaction disputes
18. `notifications` - User notifications (push, SMS, in-app)
19. `cards` - Virtual/debit cards
20. `loans` - Loan records
21. `devices` - Trusted devices for 2FA bypass

---

## API Endpoints Structure

### Authentication Endpoints
- `POST /api/auth/register` - User registration
- `POST /api/auth/login` - User login
- `POST /api/auth/verify-2fa` - Verify 2FA code
- `POST /api/auth/logout` - User logout
- `POST /api/auth/refresh-token` - Refresh access token

### Account Endpoints
- `GET /api/accounts` - List user accounts
- `POST /api/accounts` - Create new account
- `GET /api/accounts/{id}` - Get account details
- `GET /api/accounts/{id}/balance` - Get account balance
- `GET /api/accounts/{id}/statements` - Get statements
- `PATCH /api/accounts/{id}` - Update account settings

### Transaction Endpoints
- `GET /api/transactions` - List all transactions
- `GET /api/transactions/{id}` - Get transaction details
- `GET /api/transactions/export/pdf` - Export statements as PDF
- `GET /api/transactions/export/csv` - Export statements as CSV

### Withdrawal Endpoints
- `POST /api/withdrawals` - Request withdrawal
- `GET /api/withdrawals` - List withdrawals
- `GET /api/withdrawals/{id}` - Get withdrawal details
- `PATCH /api/withdrawals/{id}/cancel` - Cancel withdrawal

### Deposit Endpoints
- `POST /api/deposits` - Create deposit
- `GET /api/deposits` - List deposits
- `GET /api/deposits/{id}` - Get deposit details
- `POST /api/deposits/{id}/confirm` - Confirm deposit

### Transfer Endpoints (Intra-Bank Only)
- `POST /api/transfers` - Initiate transfer (returns pending authorization ID)
- `GET /api/transfers` - List transfers
- `GET /api/transfers/{id}` - Get transfer details
- `PATCH /api/transfers/{id}/cancel` - Cancel transfer (if pending)
- `POST /api/transfers/schedule` - Schedule future transfer (requires 2FA verification)
- `GET /api/beneficiaries` - List saved beneficiaries (intra-bank only)
- `POST /api/beneficiaries` - Add new beneficiary (intra-bank only)
- `DELETE /api/beneficiaries/{id}` - Remove beneficiary

### 2FA Authorization Endpoints
- `POST /api/2fa/setup` - Initialize 2FA (returns QR code for TOTP)
- `POST /api/2fa/verify-setup` - Verify 2FA setup with TOTP code
- `POST /api/2fa/disable` - Disable 2FA for user
- `POST /api/2fa/backup-codes` - Generate backup codes
- `GET /api/2fa/status` - Get user's 2FA status
- `POST /api/2fa/send-sms-otp` - Send SMS OTP for verification
- `POST /api/2fa/verify-otp` - Verify SMS OTP code
- `GET /api/authorizations/pending` - List pending authorization requests
- `POST /api/authorizations/{id}/approve` - Approve authorization with 2FA
- `POST /api/authorizations/{id}/reject` - Reject authorization
- `POST /api/authorizations/{id}/verify-totp` - Verify TOTP for authorization
- `POST /api/authorizations/{id}/verify-sms-otp` - Verify SMS OTP for authorization
- `POST /api/devices/trusted` - Add trusted device
- `GET /api/devices/trusted` - List trusted devices
- `DELETE /api/devices/{id}` - Remove trusted device
- `POST /api/devices/{id}/forget` - Forget all devices

### Utility Bill Payment Endpoints
- `POST /api/bills/pay` - Pay utility bill
- `GET /api/bills` - List bill payment history
- `GET /api/bills/{id}` - Get bill payment details
- `GET /api/bills/providers` - Get list of available providers
- `POST /api/bills/schedule` - Schedule recurring bill payment
- `GET /api/bills/saved-billers` - List saved billers
- `POST /api/bills/saved-billers` - Add saved biller

### User Dashboard Endpoints
- `GET /api/dashboard/summary` - Get dashboard summary (balance, recent transactions)
- `GET /api/dashboard/quick-actions` - Get available quick actions
- `GET /api/profile` - Get user profile
- `PATCH /api/profile` - Update user profile
- `POST /api/profile/change-password` - Change password
- `POST /api/profile/enable-2fa` - Enable 2FA
- `POST /api/profile/disable-2fa` - Disable 2FA

### Admin Endpoints (Filament will handle UI)
- `GET /api/admin/users` - List all users
- `GET /api/admin/transactions` - Monitor transactions
- `PATCH /api/admin/transactions/{id}/approve` - Approve transaction
- `PATCH /api/admin/transactions/{id}/reject` - Reject transaction
- `GET /api/admin/reports` - Generate reports
- `GET /api/admin/audit-logs` - View audit logs

---

## PHPDoc Standards

### Controller Method Format
```php
/**
 * Brief description of what the endpoint does
 *
 * Longer detailed description explaining the functionality,
 * business logic, and any important notes.
 *
 * @authenticated
 * @group Accounts
 * @urlParam id int required The account ID
 * @queryParam limit int The number of records to return. Example: 10
 * @bodyParam amount decimal required The transaction amount. Example: 50000
 * @response 200 {
 *   "status": "success",
 *   "data": {...},
 *   "message": "Operation successful"
 * }
 * @response 400 {
 *   "status": "error",
 *   "message": "Validation error",
 *   "errors": {...}
 * }
 * @response 401 {
 *   "status": "error",
 *   "message": "Unauthorized"
 * }
 *
 * @return JsonResponse
 */
```

### Model Method Format
```php
/**
 * Get the user's accounts with balance greater than specified amount
 *
 * @param float $minBalance Minimum balance threshold
 * @return Collection Account collection filtered by balance
 */
```

### Request Validation Format
```php
/**
 * Get the validation rules that apply to the request
 *
 * @return array Validation rules array with field => rule pairs
 */
```

---

## Implementation Priorities

### Phase 1 (Core)
1. User authentication and registration
2. 2FA setup (TOTP + SMS OTP backup)
3. Account creation and management
4. Balance inquiries
5. Deposits and withdrawals (with 2FA verification)
6. Simple transfers (intra-bank only) with 2FA requirement
7. Pending authorization workflow and approval system
8. API endpoints with PHPDoc
9. User dashboard (basic)

### Phase 2 (Extended)
1. Utility bill payments (with 2FA verification)
2. Scheduled transfers (with 2FA verification)
3. Beneficiary management (intra-bank)
4. Transaction fees and charges
5. Filament admin panel setup
6. Reports generation
7. 2FA session management and device trust
8. Push notification system for authorizations

### Phase 3 (Advanced)
1. Advanced fraud detection and monitoring
2. Card management
3. Loan management
4. Dispute resolution
5. Advanced reporting and analytics
6. Audit trails and comprehensive logging
7. Biometric authentication (optional: fingerprint/face recognition for mobile)

---

## Additional Requirements

### Code Quality
- Use Laravel best practices and conventions
- Implement proper error handling and validation
- Use Laravel's Query Builder or Eloquent ORM
- Create meaningful database transactions for critical operations
- Implement proper logging for audit trails

### API Response Format
All API responses should follow consistent JSON structure:
```json
{
  "status": "success|error",
  "data": { ... },
  "message": "Human-readable message",
  "errors": { ... }
}
```

### Testing
- Create unit tests for critical business logic
- Create feature tests for API endpoints
- Create seeder for demo data

### Documentation
- Comprehensive PHPDoc for all controller methods
- README with setup instructions
- API documentation generation (use Scribe or L5-Swagger)

### Security
- Validate all inputs
- Use middleware for rate limiting
- Implement CORS properly
- Hash sensitive data
- Use environment variables for secrets
- Implement proper authorization checks

---

## File Structure
```
banking-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── AccountController.php
│   │   │   │   ├── TransactionController.php
│   │   │   │   ├── WithdrawalController.php
│   │   │   │   ├── DepositController.php
│   │   │   │   ├── TransferController.php
│   │   │   │   ├── BillPaymentController.php
│   │   │   │   └── DashboardController.php
│   │   │   └── Filament/
│   │   ├── Requests/
│   │   └── Middleware/
│   ├── Models/
│   ├── Services/
│   └── Exceptions/
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
│   ├── api.php
│   ├── web.php
│   └── admin.php
└── resources/
    └── views/
```

---

## Deliverables
1. Complete Laravel application with all features
2. API endpoints fully documented with PHPDoc
3. Filament admin panel for management
4. User dashboard with Breeze Starter Kit
5. Comprehensive README with setup instructions
6. Database migrations and seeders
7. API documentation (generated from PHPDoc)
8. Sample `.env.example` file

---

## Notes
- Nigerian banks typically use 10-digit account numbers
- Common currency: Nigerian Naira (₦)
- Consider implementing USSD integration simulation
- Add realistic transaction processing delays
- Implement proper decimal handling for monetary values
- Use Carbon for datetime handling
- Consider implementing event-driven notifications
