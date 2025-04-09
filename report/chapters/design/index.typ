= Design <design>

== MVC Architecture

The Model-View-Controller (MVC) architectural pattern represents a fundamental approach to application design that emphasizes separation of concerns. This separation creates a modular codebase where components have distinct responsibilities, facilitating maintenance, testing, and scalability. Our PHP application embraces these core principles while implementing them in a pragmatic manner suited to web development requirements.

=== Conceptual overview

The MVC implementation divides the application into three primary component types:

*Model Layer*: Responsible for data retrieval, storage, validation, and business rule enforcement. This layer encapsulates all data operations and presents a clean interface to controllers, abstracting database operations and ensuring data integrity.

*View Layer*: Handles the presentation logic, transforming data from models into user interface elements. Our implementation uses PHP-based templates with layout composition, allowing for consistent UI elements across pages.

*Controller Layer*: Orchestrates the application flow by receiving HTTP requests, interacting with appropriate models, and selecting views for rendering. Controllers serve as the intermediary that connects user interaction with system functionality.

=== Directory Structure

The physical organization of the codebase reflects the conceptual divisions of MVC, with additional supporting directories for configuration, middleware, and deployment resources:

```
├── api/                  = API endpoints for AJAX interactions
├── config/               = Configuration files and environment settings
├── controllers/          = Controller classes organized by domain
├── middleware/           = Request preprocessing components
├── migrations/           = Database schema version files
├── models/               = Data and business logic components
├── public/               = Publicly accessible assets
├── views/                = Templates and presentation logic
│   ├── layouts/          = Layout templates for page composition
│   └── [feature dirs]/   = Feature-specific view templates
├── .htaccess             = Web server configuration
├── index.php             = Application entry point
└── routes.php            = URL routing definitions
```

This structure balances conceptual purity with practical organization, grouping files by both responsibility and feature context.

== Application Flow

The system processes user interactions through carefully defined execution paths. These flows can be categorized into two primary patterns with several distinct phases:

=== Standard Web Request Flow

This flow represents the traditional request/response cycle where the server generates complete HTML pages:

1. *Request Initiation*:
  - User requests a URL through their browser
  - Web server receives the request and routes it to the application entry point
  - `.htaccess` settings ensure all requests are directed to `index.php`

2. *Request Preprocessing*:
  - Session is initialized (`session_start()`)
  - Configuration files are loaded (`config/index.php`)
  - Routes are registered (`routes.php`)
  - View utilities are made available (`views/index.php`)
  - Middleware is prepared (`middleware/UserMiddleware.php`)

3. *Route Resolution*:
  - Application extracts the request path and method
  - System checks if the path exists in the registered routes
  - For undefined routes, the system renders a 404 page

4. *Middleware Processing*:
  - UserMiddleware validates session state and authentication
  - Middleware may redirect unauthenticated users to login page
  - Request context is established (e.g., current user)

5. *Controller Delegation*:
  - Appropriate controller is instantiated based on the route
  - Controller's `route()` method receives HTTP method and path
  - Controller determines which action method to execute

6. *Model Interaction*:
  - Controller instantiates required model objects
  - Models connect to the database through the Database singleton
  - Models execute queries and retrieve data
  - Domain objects are created from database records
  - Business rules are applied to the retrieved data

7. *View Preparation*:
  - Controller organizes model data into view-friendly structures
  - Data array is passed to the view rendering function

8. *View Rendering*:
  - Output buffering is initiated to capture rendered content
  - View template is included and executes, generating HTML
  - View may access passed data to populate dynamic elements
  - Layout template is loaded with the buffered content
  - Final HTML is sent to the browser

9. *Response Completion*:
  - Buffer is flushed to the client
  - Connection is closed
  - Browser renders the received HTML

=== AJAX Interaction Flow

This pattern supports dynamic interactions without requiring full page reloads:

1. *Client-side Initiation*:
  - JavaScript event triggers on user interaction
  - AJAX request is constructed with appropriate headers
  - Request is directed to an API endpoint with payload data

2. *Server Preprocessing*:
  - Request arrives at the application entry point
  - System detects API path prefix (`/api/`)
  - Direct file inclusion occurs instead of controller routing

3. *API Endpoint Processing*:
  - Specific API PHP script is loaded (e.g., `search-photos.php`)
  - Authentication and authorization are verified
  - Request parameters are validated

4. *Model Interaction*:
  - API script interacts with appropriate models
  - Database operations are performed
  - Results are processed according to business rules

5. *Response Formatting*:
  - Data is structured as JSON or required format
  - Headers are set for content type and caching
  - Response is encoded and sent to client

6. *Client-side Processing*:
  - JavaScript receives and parses the response
  - DOM is updated based on received data
  - User interface reflects the changes without page reload

This dual-flow architecture provides flexibility to handle both traditional page requests and dynamic interactions while maintaining consistent structural organization and separation of concerns.
