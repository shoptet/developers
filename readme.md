# Postman collection for Shoptet API

If you use Postman as an API platform for building and using APIs, we provide you a complex collection of Shoptet API.

You have 2 options how to import our postman collection (created from [openApi schema](https://swagger.io/specification/) - openapi.yaml ) into your postman client

## Fork `Shoptet API Collection` from `Shoptet Public API Workspace` (recommended)

See [Shoptet Public API Workspace](https://www.postman.com/orange-rocket-771692/shoptet-public-api-workspace).

Also check postman documentation for more details: [Fork a collection](https://learning.postman.com/docs/collaborating-in-postman/forking-collections/).

### Step 1: Navigate to Shoptet Public API Workspace
- Launch Postman on your desktop or in the browser.
- In the search bar in the top header of app, type **Shoptet Public API** and select collection from Shoptet public API Workspace.

### Step 2: Locate the Shoptet API Collection
- Once inside the Shoptet Public API Workspace, go to the **Collections** tab.
- Find the **Shoptet API** collection.

### Step 3: Fork the Collection
- Click on the **Shoptet API** collection to open it.
- In the collection view, click the **Fork** button in the top-right corner.
- In the fork dialog, choose a name for your forked collection.
- Select the workspace where you want to save the forked collection.
- **It’s recommended to check `watch original collection` to get notified about changes in the original collection.**
- Click **Fork Collection**.

### Step 4: Access Your Forked Collection
- Navigate to the workspace where you saved the forked collection.
- You’ll now find the forked **Shoptet API** collection under the **Collections** tab, ready for you to use and modify.

Now you have your own copy of the Shoptet API collection!

## Import `openapi.yaml` into Postman as a Collection

### Step 1: Upload the `openapi.yaml` File
- Download the [openapi.yaml](https://github.com/shoptet/developers/blob/master/openapi/openapi.yaml) file from this repository.
- Launch Postman on your desktop or in the browser.
- In the top-left corner of Postman, click the **Import** button.
- A pop-up window will appear.
- Drag and drop your `openapi.yaml` file into the window, or click **Upload Files** and browse to the file's location.

### Step 2: Verify OpenAPI Import
- Postman will automatically recognize the OpenAPI schema.
- It will display a preview of the API schema.

### Step 3: Import as Collection
- Once the file is recognized, click **Import**.
- Postman will convert the OpenAPI schema into a collection of requests, based on the defined endpoints in the `openapi.yaml` file.

### Step 4: Access the Imported Collection
- After the import is successful, go to the **Collections** tab.
- You’ll find your new collection, named after the OpenAPI schema, containing all the API requests generated from the file.



Now you can explore the API endpoints and use them directly within Postman!

## Collection settings

1. Click the **Shoptet API** collection name.
2. Go to **Authorization** tab.
3. Set your access token into the `value` of `Shoptet-Access-Token` key.
4. Go to **Variables** tab.
4. You can set `baseUrl` variable here.

