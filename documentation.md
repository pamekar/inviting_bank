# WhatsApp API Documentation

This documentation provides details on the API endpoints handled by the `WhatsAppAPIController`.

## General Information

-   **Base URL:** `/api/whatsapp`
-   **Authentication:** These endpoints are protected by `auth:sanctum` middleware. A valid Sanctum token must be included in the `Authorization` header as a Bearer token.
-   **Content-Type:** All requests should be sent with `Content-Type: application/json`.
-   **Accept:** All requests should include `Accept: application/json`.

---

## Get Account Balance

-   **Endpoint:** `POST /api/whatsapp/balance`
-   **Description:** Retrieves the account balance for a user based on their phone number.

### Request Payload

```json
{
    "phone_number": "+1234567890"
}
```

| Field          | Type   | Description                      |
| :------------- | :----- | :------------------------------- |
| `phone_number` | String | The user's registered phone number. |

### Sample Response (Success)

```json
{
    "data": {
        "account_holder_name": "John Doe",
        "account_number": "1234567890",
        "account_type": "savings",
        "balance": 1000.00,
        "currency": "USD",
        "description": "The current balance for the specified account."
    }
}
```

### Error Response (User Not Found)

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

## Get Transaction History

-   **Endpoint:** `POST /api/whatsapp/transactions`
-   **Description:** Retrieves a list of the user's most recent transactions.

### Request Payload

```json
{
    "phone_number": "+1234567890",
    "limit": 5
}
```

| Field          | Type    | Description                                         |
| :------------- | :------ | :-------------------------------------------------- |
| `phone_number` | String  | The user's registered phone number.                 |
| `limit`        | Integer | (Optional) The maximum number of transactions to return. Defaults to 10. |

### Sample Response (Success)

```json
{
    "data": [
        {
            "id": 1,
            "type": "deposit",
            "amount": 500.00,
            "status": "completed",
            "created_at": "2025-10-21T10:00:00.000000Z"
        },
        {
            "id": 2,
            "type": "transfer",
            "amount": -50.00,
            "status": "completed",
            "created_at": "2025-10-20T15:30:00.000000Z"
        }
    ]
}
```

### Error Response (User Not Found)

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

## Initiate a Transfer

-   **Endpoint:** `POST /api/whatsapp/transfer`
-   **Description:** Initiates a fund transfer from the user's account to another account. This creates a pending authorization that must be approved.

### Request Payload

```json
{
    "source_phone_number": "+1234567890",
    "destination_account_number": "0987654321",
    "amount": 100.00
}
```

| Field                        | Type    | Description                               |
| :--------------------------- | :------ | :---------------------------------------- |
| `source_phone_number`        | String  | The phone number of the user initiating the transfer. |
| `destination_account_number` | String  | The account number of the recipient.      |
| `amount`                     | Numeric | The amount to transfer.                   |

### Sample Response (Success)

```json
{
    "data": {
        "id": 1,
        "authorization_type": "transfer",
        "transaction_details": {
            "transaction_id": 1,
            "source_account_id": 1,
            "destination_account_id": 2
        },
        "expires_at": "2025-10-21T10:15:00.000000Z",
        "status": "pending",
        "description": "A transfer has been initiated and is awaiting authorization. Source Account: 1, Destination Account: 2, Amount: 100"
    }
}
```

### Error Responses

-   **User Not Found:**
    ```json
    {
        "error": "UserNotFound",
        "message": "A user with the provided source phone number could not be found.",
        "context": {
            "phone_number": "+1234567890"
        }
    }
    ```
-   **Insufficient Funds:**
    ```json
    {
        "message": "Insufficient funds"
    }
    ```

---

## Initiate a Bill Payment

-   **Endpoint:** `POST /api/whatsapp/bill-payment`
-   **Description:** Initiates a bill payment from the user's account. This creates a pending authorization that must be approved.

### Request Payload

```json
{
    "source_phone_number": "+1234567890",
    "amount": 75.50,
    "biller": "Electricity Company",
    "customer_reference": "CUST12345"
}
```

| Field                | Type    | Description                               |
| :------------------- | :------ | :---------------------------------------- |
| `source_phone_number`| String  | The phone number of the user paying the bill. |
| `amount`             | Numeric | The amount of the bill payment.           |
| `biller`             | String  | The name of the company or service being paid. |
| `customer_reference` | String  | The customer's account or reference number with the biller. |

### Sample Response (Success)

```json
{
    "data": {
        "id": 2,
        "authorization_type": "bill_payment",
        "transaction_details": {
            "transaction_id": 2,
            "biller": "Electricity Company",
            "customer_reference": "CUST12345"
        },
        "expires_at": "2025-10-21T10:20:00.000000Z",
        "status": "pending",
        "description": "A bill payment has been initiated and is awaiting authorization. Biller: Electricity Company, Customer Reference: CUST12345, Amount: 75.5"
    }
}
```

### Error Responses

-   **User Not Found:**
    ```json
    {
        "error": "UserNotFound",
        "message": "A user with the provided source phone number could not be found.",
        "context": {
            "phone_number": "+1234567890"
        }
    }
    ```
-   **Insufficient Funds:**
    ```json
    {
        "message": "Insufficient funds"
    }
    ```
