PATCH: `/api/orders/<code>/status`

**billingMethodId**

```diff
-Response code: 400
+Response code: 422

{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
-            "message": "Invalid billing method id. Billing method id \"99\" does not exist",
-            "instance": "billingMethodId"
+            "message": "Invalid billingMethodId \"99\".",
+            "instance": "data.billingMethodId"
        }
    ]
}
```

or

```diff
-Response code: 400
+Response code: 422

{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
            "message": "Invalid billing method id. Billing method id \"99\" does not exist",
-            "instance": "billingMethodId"
+            "instance": "data.billingMethodId"
        }
    ]
}
```

---------

**statusId**

```diff
-Response code: 400
+Response code: 422

{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
-            "message": "Invalid status id. Status id \"99\" does not exist",
-            "instance": "statusId"
+            "message": "Invalid statusId \"99\".",
+            "instance": "data.statusId"
        }
    ]
}
```

or

```diff
-Response code: 400
+Response code: 422

{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
-            "instance": "statusId"
+            "instance": "data.statusId"
        }
    ]
}
```

PATCH: `/api/orders/<code>/head`

**deliveryAddress.countryCode**:
```diff
-Response code: 400
+Response code: 422

{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
-            "message": "Invalid countryCode value \"\". Country not found.",
-            "instance": "integration-call"
+            "message": "Must be at least 1 characters long",
+            "instance": "data.deliveryAddress.countryCode"
        }
    ]
}
```

```diff
-Response code: 400
+Response code: 422

{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
            "message": "Invalid countryCode value \"CZE\". Country not found.",
-            "instance": "integration-call"
+            "instance": "data.deliveryAddress.countryCode"
        }
    ]
}
```

----------

**addressesEqual**:
```diff
{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
-            "message": "Field 'deliveryAddress' must be set when 'addressesEqual' is false.",
+            "message": "Field \"deliveryAddress\" must be set when \"addressesEqual\" is false.",
            "instance": "payload"
        }
    ]
}
```

```diff
{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
-            "message": "Field 'deliveryAddress' must be set when 'addressesEqual' is false.",
+            "message": "Field \"deliveryAddress\" must be set when \"addressesEqual\" is false.",
            "instance": "payload"
        }
    ]
}
```

----------

**billingAddress.countryCode**:
```diff
{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
-            "message": "Invalid billingAddress.countryCode value \"\". Country not found.",
-            "instance": "billingAddress.countryCode"
+            "message": "Must be at least 1 characters long",
+            "instance": "data.billingAddress.countryCode"
        }
    ]
}
```

```diff
{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
-            "message": "Invalid billingAddress.countryCode value \"CZE\". Country not found.",
-            "instance": "billingAddress.countryCode"
+            "message": "Invalid countryCode value \"CZE\". Country not found.",
+            "instance": "data.billingAddress.countryCode"
        }
    ]
}
```

----------

**birthDate**:
```diff
{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
-            "message": "Does not match the regex pattern ^[0-9]{4}-[0-9]{2}-[0-9]{2}$",
+            "message": "Invalid birthDate \"\". Format YYYY-MM-DD is required.",
            "instance": "data.birthDate"
        }
    ]
}
```

```diff
{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
-            "message": "Invalid birthDate. Given value \"2100-05-05\" is in future.",
-            "instance": "payload"
+            "message": "Invalid birthDate. Given value \"2100-05-05\" is in future.",
+            "instance": "data.birthDate"
        }
    ]
}
```

----------

**clientCode**:
```diff
{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
-            "message": "Field clientCode cannot be empty string.",
-            "instance": "payload"
+            "message": "Must be at least 1 characters long",
+            "instance": "data.clientCode"
        }
    ]
}
```

----------

**companyId**:
```diff
{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
-            "message": "Field 'companyId' is required in this eshop.",
-            "instance": "payload"
+            "message": "Array value found, but a string is required",
+            "instance": "data.companyId"
        }
    ]
}
```


```diff
{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
-            "message": "Field 'companyId' is required in this eshop.",
-            "instance": "payload"
+            "message": "Must be at least 1 characters long",
+            "instance": "data.companyId"
        }
    ]
}
```

----------

**creationTime**:
```diff
{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
-            "message": "Field creationTime must be string, array given.",
-            "instance": "payload"
+            "message": "Array value found, but a string is required",
+            "instance": "data.creationTime"
        }
    ]
}
```

```diff
{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
-            "message": "Field creationTime must be string, NULL given.",
-            "instance": "payload"
+            "message": "NULL value found, but a string is required",
+            "instance": "data.creationTime"
        }
    ]
}
```

----------

**customerGuid**:
```diff
{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
-            "message": "Field customerGuid must be string, array given.",
-            "instance": "payload"
+            "message": "Array value found, but a string is required",
+            "instance": "data.customerGuid"
        }
    ]
}
```

```diff
{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
-            "message": "Field customerGuid must be string, NULL given.",
-            "instance": "payload"
+            "message": "NULL value found, but a string is required",
+            "instance": "data.customerGuid"
        }
    ]
}
```

----------

**phone**:
```diff
{
    "data": null,
    "errors": [
        {
            "errorCode": "invalid-request-data",
            "message": "Invalid phone number \"+420925765322\". Please check format of this number.",
-            "instance": "payload"
+            "instance": "data.phone"
        }
    ]
}
```

