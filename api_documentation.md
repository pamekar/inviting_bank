# API Documentation

This document provides documentation for all the API endpoints available in the application.

## Authentication

All API requests must be authenticated using a Bearer token. The token should be included in the `Authorization` header of your request.

**Example Header:**
```json
{
  "Authorization": "Bearer YOUR_SANCTUM_API_TOKEN",
  "Accept": "application/json",
  "Content-Type": "application/json"
}
```

---

## Endpoints

### Authentication (`/api/auth`)

#### 1. Register

*   **Method:** `POST`
*   **URL:** `/api/auth/register`
*   **Request Body:**
    ```json
    {
        "name": "John Doe",
        "email": "john.doe@example.com",
        "phone_number": "+1234567890",
        "password": "password",
        "password_confirmation": "password"
    }
    ```
*   **Success Response (201 Created):**
    ```json
    {
        "message": "User registered successfully",
        "user": {
            "name": "John Doe",
            "email": "john.doe@example.com",
            "phone_number": "+1234567890",
            "updated_at": "2025-10-21T10:00:00.000000Z",
            "created_at": "2025-10-21T10:00:00.000000Z",
            "id": 1
        }
    }
    ```

#### 2. Login

*   **Method:** `POST`
*   **URL:** `/api/auth/login`
*   **Request Body:**
    ```json
    {
        "email": "john.doe@example.com",
        "password": "password"
    }
    ```
*   **Success Response (200 OK):**
    ```json
    {
        "token": "YOUR_SANCTUM_API_TOKEN",
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john.doe@example.com",
            "email_verified_at": null,
            "created_at": "2025-10-21T10:00:00.000000Z",
            "updated_at": "2025-10-21T10:00:00.000000Z"
        }
    }
    ```

#### 3. Logout

*   **Method:** `POST`
*   **URL:** `/api/auth/logout`
*   **Authentication:** Required
*   **Success Response (200 OK):**
    ```json
    {
        "message": "Logged out successfully"
    }
    ```

### Accounts (`/api/accounts`)

#### 1. Get All Accounts

*   **Method:** `GET`
*   **URL:** `/api/accounts`
*   **Authentication:** Required
*   **Success Response (200 OK):**
    ```json
    [
        {
            "id": 1,
            "user_id": 1,
            "account_tier_id": 1,
            "account_number": "1234567890",
            "type": "savings",
            "balance": 1000.00,
            "status": "active",
            "created_at": "2025-10-21T10:00:00.000000Z",
            "updated_at": "2025-10-21T10:00:00.000000Z"
        }
    ]
    ```

#### 2. Create Account

*   **Method:** `POST`
*   **URL:** `/api/accounts`
*   **Authentication:** Required
*   **Request Body:**
    ```json
    {
        "account_tier_id": 1,
        "type": "savings"
    }
    ```
*   **Success Response (201 Created):**
    ```json
    {
        "id": 2,
        "user_id": 1,
        "account_tier_id": 1,
        "account_number": "0987654321",
        "type": "savings",
        "balance": 0,
        "status": "active",
        "created_at": "2025-10-21T10:05:00.000000Z",
        "updated_at": "2025-10-21T10:05:00.000000Z"
    }
    ```

#### 3. Get Account

*   **Method:** `GET`
*   **URL:** `/api/accounts/{id}`
*   **Authentication:** Required
*   **Success Response (200 OK):**
    ```json
    {
        "id": 1,
        "user_id": 1,
        "account_tier_id": 1,
        "account_number": "1234567890",
        "type": "savings",
        "balance": 1000.00,
        "status": "active",
        "created_at": "2025-10-21T10:00:00.000000Z",
        "updated_at": "2025-10-21T10:00:00.000000Z"
    }
    ```

#### 4. Get Account Balance

*   **Method:** `GET`
*   **URL:** `/api/accounts/{id}/balance`
*   **Authentication:** Required
*   **Success Response (200 OK):**
    ```json
    {
        "account_holder_name": "John Doe",
        "account_number": "1234567890",
        "account_type": "savings",
        "balance": 1000.00,
        "currency": "USD",
        "description": "The current balance for the specified account."
    }
    ```

### Transfers (`/api/transfers`)

#### 1. Initiate Transfer

*   **Method:** `POST`
*   **URL:** `/api/transfers`
*   **Authentication:** Required
*   **Request Body:**
    ```json
    {
        "source_account_id": 1,
        "destination_account_id": 2,
        "amount": 100.00
    }
    ```
*   **Success Response (201 Created):**
    ```json
    {
        "id": 1,
        "authorization_type": "transfer",
        "transaction_details": {
            "transaction_id": 1,
            "source_account_id": 1,
            "destination_account_id": 2,
            "transaction": {
                "amount": 100.00
            }
        },
        "expires_at": "2025-10-21T10:20:00.000000Z",
        "status": "pending",
        "description": "A transfer has been initiated and is awaiting authorization. Source Account: 1, Destination Account: 2, Amount: 100.00"
    }
    ```

### Bill Payments (`/api/bills`)

#### 1. Initiate Bill Payment

*   **Method:** `POST`
*   **URL:** `/api/bills/pay`
*   **Authentication:** Required
*   **Request Body:**
    ```json
    {
        "account_id": 1,
        "amount": 50.00,
        "biller": "NEPA",
        "customer_reference": "123456789"
    }
    ```
*   **Success Response (201 Created):**
    ```json
    {
        "id": 2,
        "authorization_type": "bill_payment",
        "transaction_details": {
            "transaction_id": 2,
            "biller": "NEPA",
            "customer_reference": "123456789",
            "transaction": {
                "amount": 50.00
            }
        },
        "expires_at": "2025-10-21T10:25:00.000000Z",
        "status": "pending",
        "description": "A bill payment has been initiated and is awaiting authorization. Biller: NEPA, Customer Reference: 123456789, Amount: 50.00"
    }
    ```

### WhatsApp API (`/api/whatsapp`)

These endpoints are specifically designed for the WhatsApp chatbot integration.

#### 1. Get Account Balance

*   **Method:** `POST`
*   **URL:** `/api/whatsapp/balance`
*   **Authentication:** Required
*   **Request Body:**
    ```json
    {
        "phone_number": "+1234567890"
    }
    ```
*   **Success Response (200 OK):**
    ```json
    {
        "account_holder_name": "John Doe",
        "account_number": "1234567890",
        "account_type": "savings",
        "balance": 1000.00,
        "currency": "USD",
        "description": "The current balance for the specified account."
    }
    ```

#### 2. Get Transaction History

*   **Method:** `POST`
*   **URL:** `/api/whatsapp/transactions`
*   **Authentication:** Required
*   **Request Body:**
    ```json
    {
        "phone_number": "+1234567890",
        "limit": 5
    }
    ```
*   **Success Response (200 OK):**
    ```json
    [
        {
            "id": 1,
            "type": "deposit",
            "amount": 1000.00,
            "status": "completed",
            "created_at": "2025-10-21T10:00:00.000000Z"
        }
    ]
    ```

#### 3. Initiate Transfer

*   **Method:** `POST`
*   **URL:** `/api/whatsapp/transfer`
*   **Authentication:** Required
*   **Request Body:**
    ```json
    {
        "source_phone_number": "+1234567890",
        "destination_account_number": "0987654321",
        "amount": 100.00
    }
    ```
*   **Success Response (201 Created):**
    ```json
    {
        "id": 1,
        "authorization_type": "transfer",
        "transaction_details": {
            "transaction_id": 1,
            "source_account_id": 1,
            "destination_account_id": 2,
            "transaction": {
                "amount": 100.00
            }
        },
        "expires_at": "2025-10-21T10:20:00.000000Z",
        "status": "pending",
        "description": "A transfer has been initiated and is awaiting authorization. Source Account: 1, Destination Account: 2, Amount: 100.00"
    }
    ```

#### 4. Initiate Bill Payment

*   **Method:** `POST`
*   **URL:** `/api/whatsapp/bill-payment`
*   **Authentication:** Required
*   **Request Body:**
    ```json
    {
        "source_phone_number": "+1234567890",
        "amount": 50.00,
        "biller": "NEPA",
        "customer_reference": "123456789"
    }
    ```
*   **Success Response (201 Created):**
    ```json
    {
        "id": 2,
        "authorization_type": "bill_payment",
        "transaction_details": {
            "transaction_id": 2,
            "biller": "NEPA",
            "customer_reference": "123456789",
            "transaction": {
                "amount": 50.00
            }
        },
        "expires_at": "2025-10-21T10:25:00.000000Z",
        "status": "pending",
        "description": "A bill payment has been initiated and is awaiting authorization. Biller: NEPA, Customer Reference: 123456789, Amount: 50.00"
    }
    ```