# WhatsApp API Documentation

This document provides detailed documentation for the API endpoints specifically designed for the WhatsApp chatbot integration.

## Authentication

All API requests must be authenticated using a Bearer token provided upon user registration/login. The token should be included in the `Authorization` header of every request.

---

### Sample Request Headers

All endpoints require the following headers:

```json
{
  "Authorization": "Bearer YOUR_SANCTUM_API_TOKEN",
  "Accept": "application/json",
  "Content-Type": "application/json"
}
```

---

## Endpoints

### 1. Get Account Balance

This endpoint retrieves the account balance for a user identified by their phone number.

*   **Method:** `POST`
*   **URL:** `/api/whatsapp/balance`
*   **Authentication:** Required

#### Sample Request Payload

```json
{
    "phone_number": "+1234567890"
}
```

#### Sample Error Response (404 Not Found)

This response is returned if the user with the specified phone number is not found.

```json
{
    "error": "UserNotFound",
    "message": "A user with the provided phone number could not be found.",
    "context": {
        "phone_number": "+1234567890"
    }
}
```

---

### 2. Get Transaction History

This endpoint retrieves a list of the most recent transactions for a user identified by their phone number.

*   **Method:** `POST`
*   **URL:** `/api/whatsapp/transactions`
*   **Authentication:** Required

#### Sample Request Payload (With Optional Limit)

The `limit` parameter is optional and defaults to 10 if not provided.

```json
{
    "phone_number": "+1234567890",
    "limit": 5
}
```

#### Sample Success Response (200 OK)

```json
[
    {
        "id": 5,
        "type": "bill_payment",
        "amount": 50.00,
        "status": "completed",
        "created_at": "2025-10-21T11:00:00.000000Z"
    },
    {
        "id": 4,
        "type": "transfer",
        "amount": 100.00,
        "status": "completed",
        "created_at": "2025-10-21T10:55:00.000000Z"
    },
    {
        "id": 3,
        "type": "deposit",
        "amount": 200.00,
        "status": "completed",
        "created_at": "2025-10-21T10:45:00.000000Z"
    },
    {
        "id": 2,
        "type": "withdrawal",
        "amount": 75.00,
        "status": "completed",
        "created_at": "2025-10-21T10:30:00.000000Z"
    },
    {
        "id": 1,
        "type": "deposit",
        "amount": 1000.00,
        "status": "completed",
        "created_at": "2025-10-21T10:00:00.000000Z"
    }
]
```

#### Sample Error Response (404 Not Found)

This response is returned if the user with the specified phone number is not found.

```json
{
    "message": "No query results for model [App\\Models\\User] 1"
}
```

---

### 3. Initiate Transfer

This endpoint initiates a funds transfer from the user's account (identified by phone number) to a destination account (identified by account number).

*   **Method:** `POST`
*   **URL:** `/api/whatsapp/transfer`
*   **Authentication:** Required

#### Sample Request Payload

```json
{
    "source_phone_number": "+1234567890",
    "destination_account_number": "0987654321",
    "amount": 150.00
}
```

#### Sample Success Response (201 Created)

This response indicates that the transfer has been initiated and is awaiting authorization.

```json
{
    "id": 3,
    "authorization_type": "transfer",
    "transaction_details": {
        "transaction_id": 3,
        "source_account_id": 1,
        "destination_account_id": 2
    },
    "expires_at": "2025-10-21T11:15:00.000000Z",
    "status": "pending",
    "description": "A transfer has been initiated and is awaiting authorization. Source Account: 1, Destination Account: 2, Amount: 150.00"
}
```

#### Sample Error Response (422 Unprocessable Entity)

This response is returned if the request payload is invalid.

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "destination_account_number": [
            "The selected destination account number is invalid."
        ]
    }
}
```

#### Sample Error Response (400 Bad Request)

This response is returned if the source account has insufficient funds.

```json
{
    "message": "Insufficient funds"
}
```

---

### 4. Initiate Bill Payment

This endpoint initiates a bill payment from the user's account (identified by phone number).

*   **Method:** `POST`
*   **URL:** `/api/whatsapp/bill-payment`
*   **Authentication:** Required

#### Sample Request Payload

```json
{
    "source_phone_number": "+1234567890",
    "amount": 75.00,
    "biller": "DSTV",
    "customer_reference": "987654321"
}
```

#### Sample Success Response (201 Created)

This response indicates that the bill payment has been initiated and is awaiting authorization.

```json
{
    "id": 4,
    "authorization_type": "bill_payment",
    "transaction_details": {
        "transaction_id": 4,
        "biller": "DSTV",
        "customer_reference": "987654321"
    },
    "expires_at": "2025-10-21T11:30:00.000000Z",
    "status": "pending",
    "description": "A bill payment has been initiated and is awaiting authorization. Biller: DSTV, Customer Reference: 987654321, Amount: 75.00"
}
```

#### Sample Error Response (422 Unprocessable Entity)

This response is returned if the request payload is invalid.

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "biller": [
            "The biller field is required."
        ]
    }
}
```
